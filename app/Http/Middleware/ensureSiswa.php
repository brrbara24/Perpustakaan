<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ensureSiswa
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || $request->user()->role !== 'siswa') {
            abort(403, 'Halaman ini khusus siswa.');
        }

        return $next($request);
    }
}
