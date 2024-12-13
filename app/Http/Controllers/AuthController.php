<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {


        $passwordHashed = bcrypt($request->password);

        $Aluno = new Aluno();

        $Aluno->nome = $request->nome;
        $Aluno->email = $request->email;
        $Aluno->password = $passwordHashed;

        $Aluno->save();

        $token = $Aluno->createToken('token')->plainTextToken;

        return response()->json([
            'user' => $Aluno,
            'token' => $token
        ], 201);
    }


    public function login(Request $request)
    {

        $Aluno = Aluno::where('email', $request->email)->first();

        $PasswordExiste = Hash::check($request->password, $Aluno->password);

        if (!$Aluno || !$PasswordExiste) {
            return response()->json([
                "message" => "Combinação incorreta"
            ]);
        }

        $token = $Aluno->createToken('token')->plainTextToken;

        return response()->json([
            'aluno' => $Aluno,
            'token' => $token
        ]);
    }


    public function logout(Request $request)
    {
        auth()->aluno()->tokens()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso',
        ]);
    }
}
