<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professor;
use App\Http\Requests\StoreProfessorRequest;

class ProfessoresController extends Controller
{

    //Cadastra um novo professor
    public function store(StoreProfessorRequest $request)
    {

        try {

            $prof = new Professor();

            $prof->nome = $request->nome;

            $prof->save();

            return response()->json($prof, 201);

        } catch (\Exception $error) {

            return response()->json([
                'status' => false,
                'message' => 'Ocorreu um erro',
                'data' => [$error],
            ], 500);
        }
    }



    //mostra todos os professores
    public function index()
    {
        $profs = Professor::all();

        return response()->json($profs, 200);
    }



    //mostra os professores cadastrados
    public function show($id)
    {
        $prof = Professor::where('id', '=', $id)->first();

        return response()->json($prof, 200);
    }


    public function destroy($id)
    {
        $doesProfExists = Professor::where('id', $id)->exists();

        if (!$doesProfExists) {
            return response()->json([
                "status" => false,
                "message" => "Não foi possível encontrar o professor",
                "data" => [$doesProfExists],
            ], 400);
        }

        $prof = Professor::where('id', '=', $id)->first();

        $prof->delete();

        return response()->json([
            "status" => true,
            "message" => "O professor foi demitido :(",
            "data" => [$prof],
        ], 200);
    }

}
