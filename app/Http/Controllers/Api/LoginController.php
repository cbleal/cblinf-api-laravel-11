<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        # se as credenciais do usuario estiverem corretas, o usuario será logado
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            # recupera o usuario logado
            $user = Auth::user();

            # cria um token para o usuario logado
            $token = $request->user()->createToken('api-token')->plainTextToken;

            # retorna os dados no formato json com msg de sucesso
            return response()->json([
                'status' => true,
                'token' => $token,
                'user' => $user,
                'message' => 'usuário logado'
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'login ou senha incorretos'
            ], 404);
        }
    }

    public function logout(): JsonResponse
    {
        try {
            # verificar se o usuario está logado
            $authUser = User::where('id', Auth::id())->first();

            # se o usuario não estiver logado
            if (!$authUser) {
                # retorna msg de erro
                return response()->json([
                    'status' => false,
                    'message' => 'usuário não está logado...'
                ], 400);
            }

            # excluir os tokens do usuario
            $authUser->tokens()->delete();

            # retorna msg de sucesso
            return response()->json([
                'status' => true,
                'message' => 'deslogado com sucesso...'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'não deslogado...'
            ], 400);
        }
    }
}
