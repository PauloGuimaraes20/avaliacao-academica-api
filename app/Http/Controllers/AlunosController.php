<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Http\Requests\StoreAlunoRequest;
use App\Http\Requests\UpdateAlunoRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AlunosController extends Controller
{

    //Cadastra um novo aluno
    public function store(Request $request)
    {

        try
        {
            $passwordHashed = bcrypt($request->password);

            $stud = new Aluno();

            $stud->nif = $request->nif;
            $stud->nome = $request->nome;
            $stud->data_nascimento = $request->data_nascimento;
            $stud->email = $request->email;
            $stud->cod_aluno = $request->cod_aluno;
            $stud->curso_id = $request->curso_id;
            $stud->password = $passwordHashed;

            $stud->save();
            $token = $stud->createToken('token')->plainTextToken;


            return response()->json([
                'aluno' => $stud,
                'token' => $token
                ], 201);

        }
        catch (\Exception $error)
        {

            return response()->json([
                'status' => false,
                'message' => 'Ocorreu um erro',
                'data' => [$error],
            ], 500);
        }
    }


    public function login(Request $request)
    {

        $stud = Aluno::where('email', $request->email)->first();

        $isPasswordValid = Hash::check($request->password, $stud->password);

        if (!$stud || !$isPasswordValid) {
            return response()->json([
                "message" => "Combinação errada"
            ]);
        }

        $token = $stud->createToken('token')->plainTextToken;

        return response()->json([
            'aluno' => $stud,
            'token' => $token
        ]);
    }


    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso',
        ]);
    }


    //mostra todos os alunos
    public function index()
    {
        $studs = Aluno::all(); //usar get

        return response()->json($studs, 200);
    }



    //mostra os alunos cadastrados
    public function show($id)
    {
        $stud = Aluno::where('id', $id)->get()->first();

        return response()->json($stud, 200);
    }



    //Atualiza os dados do Aluno
    public function update(UpdateAlunoRequest $request, $id)
    {
        $studExists = Aluno::where('id', '=', $id)->exists();

        if ($studExists === false) {
            return response()->json([
                'status' => false,
                'message' => 'O aluno não existe',
                'data' => [$studExists],
            ], 400);
        }

        $stud = Aluno::where('id', '=', $id)->first();

        $stud->nif = $request->nif;
        $stud->nome = $request->nome;
        $stud->email = $request->email;

        $stud->save();

        $updMessage = "o aluno {$stud["nome"]} foi atualizado e possui o nif {$stud["nif"]}.";

        return response()->json($updMessage, 202);

    }



    public function destroy($id)
    {
        $doesStudExists = Aluno::where('id', $id)->exists();

        if (!$doesStudExists) {
            return response()->json([
                "status" => false,
                "message" => "Não foi possível encontrar o aluno",
                "data" => [$doesStudExists],
            ], 400);
        }

        $stud = Aluno::where('id', '=', $id)->first();

        $stud->delete();

        return response()->json([
            "status" => true,
            "message" => "Estudante removido com sucesso",
            "data" => [$stud],
        ], 200);
    }

}
