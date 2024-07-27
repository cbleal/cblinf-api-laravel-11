<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        # recuperar os usuarios da tabela
        // $users = User::get();
        $users = User::orderBy('id', 'DESC')->paginate(10);

        # retornar os dados no formato de objeto e com status 200
        return response()->json([
            'status' => true,
            'users' => $users
        ], 200);
    }

    public function show(User $user): JsonResponse
    {
        # retornar os dados no formato de objeto e com status 200
        return response()->json([
            'status' => true,
            'user' => $user
        ], 200);
    }

    public function store(UserRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            DB::commit();

            # retornar os dados no formato de objeto e com status 201
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'Usuário cadastrado com sucesso!',
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();

            # retornar os dados no formato de objeto e com status 400
            return response()->json([
                'status' => false,
                'message' => 'Usuário não cadastrado com sucesso!',
            ], 400);
        }
    }

    public function update(UserRequest $request, User $user): JsonResponse
    {
        DB::beginTransaction();

        try {

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            DB::commit();

            # retornar os dados no formato de objeto e com status 200
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'Usuário editado com sucesso!',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();

            # retornar os dados no formato de objeto e com status 400
            return response()->json([
                'status' => false,
                'message' => 'Usuário não editado!',
            ], 400);
        }
    }

    public function updatePassword(UserRequest $request, User $user): JsonResponse
    {
        DB::beginTransaction();

        try {

            $user->update([
                'password' => Hash::make($request->password, ['rounds' => 12])
            ]);

            DB::commit();

            # retornar os dados no formato de objeto e com status 200
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'Senha editada com sucesso!',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();

            # retornar os dados no formato de objeto e com status 400
            return response()->json([
                'status' => false,
                'message' => 'Usuário não editado!',
            ], 400);
        }
    }

    public function destroy(User $user): JsonResponse
    {
        DB::beginTransaction();

        try {

            $user->delete();

            DB::commit();

            # retornar os dados no formato de objeto e com status 200
            return response()->json([
                'status' => true,
                'message' => 'Usuário apagado com sucesso!',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();

            # retornar os dados no formato de objeto e com status 400
            return response()->json([
                'status' => false,
                'message' => 'Usuário não apagado!',
            ], 400);
        }
    }
}
