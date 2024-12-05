<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8', 
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type' => 1, 
        ]);

        return response()->json([
            'message' => 'Usuario registrado exitosamente.',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);
    
        
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $user = Auth::user();
    
            return response()->json([
                'message' => 'Login exitoso',
                'user' => $user
            ], 200);  
        }
    
       
        return response()->json([
            'message' => 'Las credenciales proporcionadas no coinciden con nuestros registros.'
        ], 401);  
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['message' => 'Has cerrado sesión exitosamente.']);
    }
}
