<?php

namespace App\Http\Middleware;

use App\Models\Login_Token;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // dd($request->cookie('token'));
        $login_token = Login_Token::where(['token' => $request->cookie('token')])->first();
        
        // đã log và nhập otp
        if ($login_token) {

            $role = Auth::user()->role_id;

            return $role == 1 ? redirect('/') : redirect('/admin');
        } else {
            // chưa log
            return $next($request);
            // dd(Auth::viaRemember());
        }
    }
}
