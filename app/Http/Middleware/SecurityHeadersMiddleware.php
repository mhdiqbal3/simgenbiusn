<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Hapus header identitas server yang berpotensi membocorkan versi
        if (function_exists('header_remove')) {
            @header_remove('X-Powered-By');
        }
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        // Proteksi Clickjacking: Mengizinkan rendering hanya dari origin yang sama
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Mencegah browser menebak MIME type secara sembarangan (MIME Sniffing)
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Proteksi XSS bawaan browser lama
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Batasi kebocoran URL asal referer
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Pembatasan akses hardware/fitur sensitif perangkat
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');

        // Content Security Policy (CSP): Melindungi dari injeksi skrip berbahaya
        // Dikonfigurasi agar tetap kompatibel dengan CDN Tailwind, Google Fonts, dan SVG/Base64 Image
        $csp = "default-src 'self' data: blob:; "
            . "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com; "
            . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; "
            . "font-src 'self' https://fonts.gstatic.com data:; "
            . "img-src 'self' data: blob: https:; "
            . "connect-src 'self'; "
            . "frame-ancestors 'self';";

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}

