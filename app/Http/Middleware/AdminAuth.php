<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $password = config('proofwork.admin_password');

        // Check session
        if (session('proofwork_admin') === true) {
            return $next($request);
        }

        // Basic HTTP auth as fallback
        if ($request->getUser() === 'admin' && $request->getPassword() === $password) {
            session(['proofwork_admin' => true]);
            return $next($request);
        }

        // Show login form
        if ($request->isMethod('POST') && $request->input('password') === $password) {
            session(['proofwork_admin' => true]);
            return redirect()->route('admin.waitlist');
        }

        return response(view('admin.login'), 401);
    }
}
