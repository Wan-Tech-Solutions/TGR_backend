<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'country_of_residence' => ['required', 'string', 'max:255'],
            'nationality' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nationality' => $request->nationality,
            'country_of_residence' => $request->country_of_residence,
            'password' => Hash::make($request->password),
            'status' => 0,
        ]);
        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }

}
