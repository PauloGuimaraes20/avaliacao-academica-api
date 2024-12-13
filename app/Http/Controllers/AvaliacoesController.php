<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avaliacao;
use App\Http\Requests\StoreAvaliacaoRequest;

class AvaliacoesController extends Controller
{

    //Cadastra uma nova avaliação
    public function store(StoreAvaliacaoRequest $request)
    {

        try
        {

            $rate = new Avaliacao();

            $rate->data_avaliacao = $request->data_avaliacao;
            $rate->comentario = $request->comentario;
            $rate->nota = $request->nota;
            $rate->aluno_id = $request->aluno_id;

            if ($request->professor_id || $request->curso_id || $request->uc_id) {
                if ($request->professor_id) {
                    $rate->professor_id = $request->professor_id;
                }

                if ($request->curso_id) {
                    $rate->curso_id = $request->curso_id;
                }

                if ($request->uc_id) {
                    $rate->uc_id = $request->uc_id;
                }
            }



            $rate->save();

            return response()->json($rate, 201);

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



    //mostra todas as avaliações
    public function index()
    {
        $rates = Avaliacao::all();

        return response()->json($rates, 200);
    }


    public function destroy($id)
    {
        $doesucExists = Avaliacao::where('id', $id)->exists();

        if (!$doesucExists) {
            return response()->json([
                "status" => false,
                "message" => "Não foi possível encontrar a avaliação",
                "data" => [$doesucExists],
            ], 400);
        }

        $uc = Avaliacao::where('id', '=', $id)->first();

        $uc->delete();

        return response()->json([
            "status" => true,
            "message" => "Avaliacao excluída com sucesso",
            "data" => [$uc],
        ], 200);
    }


}
