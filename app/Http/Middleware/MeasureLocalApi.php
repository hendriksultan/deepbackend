<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Log};

class MeasureLocalApi
{
    public function handle(Request $request, Closure $next)
    {
        if (!app()->environment('local') || !config('api_diagnostics.enabled') || !$request->is('api/v1/*')) return $next($request);
        $start = microtime(true); $queries = 0; $dbMs = 0;
        DB::listen(function (QueryExecuted $query) use (&$queries, &$dbMs) { $queries++; $dbMs += $query->time; });
        $response = $next($request);
        $now = microtime(true);
        $total = ($now - (defined('LARAVEL_START') ? LARAVEL_START : $start)) * 1000;
        $appMs = ($now - $start) * 1000;
        $response->headers->set('Server-Timing', sprintf('app;dur=%.1f, db;dur=%.1f, total;dur=%.1f', $appMs, $dbMs, $total));
        try {
            Log::build(['driver' => 'single', 'path' => storage_path('logs/api-performance.log')])->info('api.performance', [
                'method' => $request->method(), 'route' => $request->route()?->uri(), 'status' => $response->getStatusCode(),
                'total_ms' => round($total, 1), 'bootstrap_ms' => round(max(0, $total - $appMs), 1),
                'app_ms' => round($appMs, 1), 'db_ms' => round($dbMs, 1), 'queries' => $queries,
            ]);
        } catch (\Throwable $e) { /* Diagnostics must not break the API. */ }
        return $response;
    }
}
