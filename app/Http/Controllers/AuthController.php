<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Registrar um novo usuário.
     */
    public function register(Request $request)
    {
        // Validação dos dados de entrada
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed', // "password_confirmation" já é tratado automaticamente
        ]);

        // Se houver falha na validação
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Criação do usuário
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Criptografando a senha
        ]);

        // Gerar um token de autenticação (se for usar JWT ou outra estratégia)
        $token = $user->createToken('YourAppName')->accessToken;

        return response()->json([
            'message' => 'Usuário registrado com sucesso.',
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ], 201);
    }
  
}
