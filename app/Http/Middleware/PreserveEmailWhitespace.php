<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreserveEmailWhitespace
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
            // Ambil email mentah dari input asli (tanpa trimming)
            $emailRaw = $request->server('REQUEST_METHOD') === 'POST'
            ? request()->getContent()
            : null;

            if ($emailRaw) {
                // Ambil email secara manual (asumsikan form-urlencoded)
                parse_str($emailRaw, $parsed);
                if (isset($parsed['email'])) {
                    $request->merge([
                        'email' => $parsed['email'],
                    ]);
                }
            }

            return $next($request);
    }
}
