<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuditLogging
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        
        $response = $next($request);
        
        $endTime = microtime(true);
        $duration = round(($endTime - $startTime) * 1000, 2);
        
        // Log security-sensitive operations
        if ($this->shouldLog($request)) {
            $this->logSecurityEvent($request, $response, $duration);
        }
        
        return $response;
    }
    
    private function shouldLog(Request $request): bool
    {
        $sensitiveRoutes = [
            'berita.store',
            'berita.update', 
            'berita.destroy',
            'news.upload',
            'login',
            'logout'
        ];
        
        return in_array($request->route()?->getName(), $sensitiveRoutes) ||
               $request->is('admin/*') ||
               $request->is('fakultas/*') ||
               $request->is('prodi/*');
    }
    
    private function logSecurityEvent(Request $request, Response $response, float $duration): void
    {
        $logData = [
            'timestamp' => now()->toISOString(),
            'user_id' => auth()->id(),
            'user_role' => auth()->user()?->role,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'route_name' => $request->route()?->getName(),
            'status_code' => $response->getStatusCode(),
            'duration_ms' => $duration,
            'request_data' => $this->sanitizeRequestData($request->all()),
        ];
        
        if ($response->getStatusCode() >= 400) {
            Log::warning('Security Event - Error Response', $logData);
        } else {
            Log::info('Security Event - Success', $logData);
        }
    }
    
    private function sanitizeRequestData(array $data): array
    {
        // Remove sensitive data from logs
        $sensitiveKeys = ['password', 'password_confirmation', '_token', 'file'];
        
        foreach ($sensitiveKeys as $key) {
            if (isset($data[$key])) {
                $data[$key] = '[REDACTED]';
            }
        }
        
        return $data;
    }
}
