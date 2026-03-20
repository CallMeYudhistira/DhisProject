<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = Str::random(80);
            $user->update(['api_token' => $token]);

            // Set cookie and redirect
            $response = redirect('/projects');
            $response->headers->setCookie(
                new \Symfony\Component\HttpFoundation\Cookie('auth_token', $token, time() + 86400, '/', null, false, true, false, null)
            );
            return $response;
        }

        return redirect('/login/for/projects/management?error=1');
    }

    public function logout(Request $request)
    {
        $token = $request->cookie('auth_token');
        if ($token) {
            User::where('api_token', $token)->update(['api_token' => null]);
        }

        $response = redirect('/login/for/projects/management');
        $response->headers->setCookie(
            new \Symfony\Component\HttpFoundation\Cookie('auth_token', null, -1, '/', null, false, true, false, null)
        );
        return $response;
    }
}
