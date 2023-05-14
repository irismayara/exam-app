<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePasswordController extends Controller
{
    
    public function create()
    {
        if (Auth::check() && Auth::user()->password_changed_at == '') 
        {
            return view('password.change-password');
        }
    }

    public function store(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->password = Hash::make($request->password);
        $user->password_changed_at = now();
        $user->save();

        return redirect('/')->with('success', 'Password changed successfully!');
    }
}
