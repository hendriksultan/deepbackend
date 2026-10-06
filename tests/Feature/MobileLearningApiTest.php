<?php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema, Hash};

class MobileLearningApiTest extends \Illuminate\Foundation\Testing\TestCase
{
    public function createApplication()
    {
        $app = require dirname(__DIR__, 2).'/bootstrap/app.php';
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        return $app;
    }
    protected function setUp(): void
    {
        parent::setUp();
        if (!extension_loaded('pdo_sqlite')) $this->markTestSkipped('PDO SQLite diperlukan.');
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:', 'cache.default' => 'array', 'api_diagnostics.enabled' => false]);
        DB::purge('sqlite');
        Schema::create('users', function (Blueprint $t) { $t->id(); $t->string('name'); $t->string('email'); $t->string('password'); $t->string('role'); $t->boolean('is_verified'); $t->timestamps(); });
        Schema::create('personal_access_tokens', function (Blueprint $t) { $t->id(); $t->morphs('tokenable'); $t->string('name'); $t->string('token', 64)->unique(); $t->text('abilities')->nullable(); $t->timestamp('last_used_at')->nullable(); $t->timestamp('expires_at')->nullable(); $t->timestamps(); });
        Schema::create('teacher_profiles', function (Blueprint $t) { $t->id(); $t->unsignedBigInteger('user_id'); });
        Schema::create('bookings', function (Blueprint $t) { $t->id(); $t->unsignedBigInteger('user_id'); $t->unsignedBigInteger('teacher_profile_id'); $t->string('status'); $t->string('method'); $t->string('group_name')->nullable(); });
        Schema::create('study_materials', function (Blueprint $t) { $t->id(); $t->string('title'); $t->text('description')->nullable(); $t->string('type')->default('document'); $t->string('program_type')->default('all'); $t->unsignedBigInteger('teacher_profile_id')->nullable(); $t->string('group_name')->nullable(); $t->string('file_path')->nullable(); $t->string('video_url')->nullable(); $t->boolean('is_active')->default(true); $t->timestamps(); });
        Schema::create('study_material_user', function (Blueprint $t) { $t->id(); $t->unsignedBigInteger('study_material_id'); $t->unsignedBigInteger('user_id'); $t->timestamps(); });
        Schema::create('self_study_progress', function (Blueprint $t) { $t->id(); $t->unsignedBigInteger('user_id'); $t->string('lesson_key'); $t->timestamps(); $t->unique(['user_id', 'lesson_key']); });
        Schema::create('quran_bookmarks', function (Blueprint $t) { $t->id(); $t->unsignedBigInteger('user_id'); $t->integer('surat_nomor'); $t->integer('ayat_nomor'); $t->timestamps(); $t->unique(['user_id', 'surat_nomor', 'ayat_nomor']); });
    }
    private function participant(string $email): User
    {
        return User::forceCreate(['name' => 'Test', 'email' => $email, 'password' => Hash::make('test-password'), 'role' => 'student', 'is_verified' => true]);
    }
    private function loginAs(User $user): void
    {
        $this->withHeader('Authorization', 'Bearer '.$user->createToken('test', ['student'])->plainTextToken);
    }
    public function test_progress_requires_auth_and_is_isolated_and_idempotent(): void
    {
        $this->getJson('/api/v1/learning/progress')->assertUnauthorized();
        $one = $this->participant('one@example.test'); $two = $this->participant('two@example.test');
        DB::table('self_study_progress')->insert(['user_id' => $two->id, 'lesson_key' => 'arab-benda']);
        $this->loginAs($one);
        $this->getJson('/api/v1/learning/progress')->assertOk()->assertJsonPath('data.completed', []);
        $this->postJson('/api/v1/learning/progress', ['lesson_ids' => ['iqro-huruf'], 'user_id' => $two->id])->assertOk();
        $this->postJson('/api/v1/learning/progress', ['lesson_ids' => ['iqro-huruf']])->assertOk();
        $this->assertSame(1, DB::table('self_study_progress')->where('user_id', $one->id)->count());
        $this->assertSame(1, DB::table('self_study_progress')->where('user_id', $two->id)->count());
        $this->postJson('/api/v1/learning/progress', ['lesson_ids' => ['unknown-lesson']])->assertUnprocessable();
    }
    public function test_material_access_keeps_teacher_and_group_paired(): void
    {
        $user = $this->participant('student@example.test'); $teacher = $this->participant('teacher@example.test');
        DB::table('teacher_profiles')->insert([['id' => 1, 'user_id' => $teacher->id], ['id' => 2, 'user_id' => $teacher->id]]);
        DB::table('bookings')->insert([
            ['user_id' => $user->id, 'teacher_profile_id' => 1, 'status' => 'active', 'method' => 'online', 'group_name' => 'Red'],
            ['user_id' => $user->id, 'teacher_profile_id' => 2, 'status' => 'active', 'method' => 'online', 'group_name' => 'Blue'],
        ]);
        DB::table('study_materials')->insert([
            ['id' => 1, 'title' => 'Global', 'teacher_profile_id' => null, 'group_name' => null],
            ['id' => 2, 'title' => 'Allowed', 'teacher_profile_id' => 2, 'group_name' => 'Blue'],
            ['id' => 3, 'title' => 'Wrong pairing', 'teacher_profile_id' => 1, 'group_name' => 'Blue'],
        ]);
        $this->loginAs($user);
        $response = $this->getJson('/api/v1/learning/materials')->assertOk();
        $this->assertEqualsCanonicalizing([1, 2], array_column($response->json('data.data'), 'id'));
        $this->postJson('/api/v1/learning/materials/3/complete')->assertNotFound();
        $this->postJson('/api/v1/learning/materials/2/complete')->assertOk();
        $this->postJson('/api/v1/learning/materials/2/complete')->assertOk();
        $this->assertSame(1, DB::table('study_material_user')->count());
    }
    public function test_bookmarks_validate_surah_length_and_preserve_other_marks(): void
    {
        $this->loginAs($this->participant('reader@example.test'));
        $this->postJson('/api/v1/quran/bookmark', ['surat_nomor' => 1, 'ayat_nomor' => 8])->assertUnprocessable();
        $this->postJson('/api/v1/quran/bookmark', ['surat_nomor' => 1, 'ayat_nomor' => 3])->assertOk();
        $this->postJson('/api/v1/quran/bookmark', ['surat_nomor' => 1, 'ayat_nomor' => 3])->assertOk();
        $this->assertSame(1, DB::table('quran_bookmarks')->count());
        $this->getJson('/api/v1/quran/bookmark')->assertOk()->assertJsonPath('data.surat_nomor', 1)->assertJsonPath('data.ayat_nomor', 3);
    }
}
