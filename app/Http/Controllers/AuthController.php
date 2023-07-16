<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\Random;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'resetPassword', 'postResetPassword']);
    }

    public function getRegister()
    {
        return view('register');
    }

    public function postRegister(RegisterRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = bcrypt($request->password);
        $user->save();

        if ($user) {
            return redirect()->route('login')->with('success', 'Registration successful');
        }
        else {
            dd('$user');
            return redirect()->back()->with('error', 'Something went wrong');
        }

    }

    public function getLogin()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }



        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            //check if user is admin
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            else {
                return redirect()->route('user.dashboard');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid credentials');
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login')->with('success', 'Logout successful');
    }

}
