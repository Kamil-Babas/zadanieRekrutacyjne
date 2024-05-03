<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showLoginView(){
        return view('loginView');
    }

    public function showRegisterView(){
        return view('registerView');
    }

    //Log in user
    public function authenticate(Request $request) {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect('/');
        }

        return back()->withErrors(['password' => 'Bad credentials'])->onlyInput('email');
    }

    //Register new user
    public function registerUser(Request $request){
        $formFields = $request->validate([
            'email' => ['required', 'email', Rule::unique('users', 'email'), 'min:4', 'max:100'],
            'password' => 'required|confirmed|min:6'
        ]);


        $formFields['password'] = bcrypt($formFields['password']);
        $user = User::create($formFields);

        auth()->login($user);

        return redirect('/');

    }


    //Wylogowywanie
    public function logout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

}
