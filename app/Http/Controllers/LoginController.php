<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function authorization(Request $request)
    {
        $credentials = $request->validate([
            'name' => [
                'required'
            ],
            'password' => [
                'required'
            ]
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('admin');
        }

        return back()->withErrors([
            'msg' => 'Ошибка авторизации! Неверный логин или пароль'
        ]);
    }

    public function logout(Auth $user)
    {
        if ($user::hasUser()) {
            Auth::user()->tokens()->where('id', $user::user()->id)->delete();
            $user::logout();
            return redirect()->intended('login');
        };
    }
}
