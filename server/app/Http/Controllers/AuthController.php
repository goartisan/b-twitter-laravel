<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SignUpRequest;
use App\Http\Requests\LogInRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param App\Http\Requests\SignUpRequest $request
     */
    function signUp(SignUpRequest $request)
    {
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $user->password = null;
        $request->session()->regenerate();
        $request->session()->put('auth', $user);
        // return redirect('/profile/tweets/' . $user->username);
    }

    /**
     * @param App\Http\Requests\LogInRequest $request
     */
    function logIn(LogInRequest $request)
    {
        $user = User::where('username', $request->username)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->view('auth.auth', ['form' => 'login', 'success' => false], 402);
        }
        $request->session()->regenerate();
        $request->session()->put('auth', $user);
        // return redirect('/profile/tweets/' . $user->username);
    }

    /**
     * @param Illuminate\Http\Request $request
     */
    function logOut(Request $request)
    {
        $request->session()->forget('auth');
        return redirect('/login');
    }
}