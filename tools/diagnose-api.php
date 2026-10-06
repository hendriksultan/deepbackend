<?php
define('LARAVEL_START', microtime(true));
$root = dirname(__DIR__);
require $root.'/vendor/autoload.php';
$autoload = microtime(true);
$app = require $root.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$boot = microtime(true);
printf("PHP %s | Xdebug: %s\n", PHP_VERSION, extension_loaded('xdebug') ? 'loaded' : 'not loaded');
printf("autoload_ms: %.1f\nbootstrap_ms: %.1f\n", ($autoload-LARAVEL_START)*1000, ($boot-$autoload)*1000);
$start = microtime(true);
try {
    \Illuminate\Support\Facades\DB::connection()->getPdo();
    printf("db_connect_ms: %.1f\n", (microtime(true)-$start)*1000);
    $start = microtime(true);
    \Illuminate\Support\Facades\DB::select('SELECT 1');
    printf("db_select_ms: %.1f\n", (microtime(true)-$start)*1000);
    $start = microtime(true);
    \App\Models\User::query()->select('id')->limit(1)->get();
    printf("user_query_ms: %.1f\n", (microtime(true)-$start)*1000);
} catch (\Throwable $e) {
    printf("database_test_failed: %s | elapsed_ms: %.1f\n", get_class($e), (microtime(true)-$start)*1000);
    exit(1);
}
printf("cache_driver: %s | session_driver: %s | queue_driver: %s\n", config('cache.default'), config('session.driver'), config('queue.default') ?: '(empty)');
