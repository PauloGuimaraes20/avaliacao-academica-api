<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnidadeCurricular;
use App\Http\Requests\StoreUnidadeCurricularRequest;
use App\Http\Requests\UpdateUnidadeCurricularRequest;

class UnidadesCurricularesController extends Controller
{

    //Cadastra uma nova UC
    public function store(StoreUnidadeCurricularRequest $request)
    {

        try {
            $UC = new UnidadeCurricular();

            $UC->nome_uc = $request->nome_uc;
            $UC->descricao = $request->descricao;
            $UC->ects = $request->ects;

            $UC->save();

        } catch (\Exception $error) {

            return response()->json([
                "status" => false,
                "message" => 'Ocorreu um erro no servidor',
                "data" => [$error]
            ], 500);
        }

        return response()->json($UC, 201);

    }



    //mostra todas as UCs
    public function index()
    {
        $UCs = UnidadeCurricular::all();

        return response()->json($UCs, 200);
    }


    public function count()
    {
        $UCsCount = UnidadeCurricular::count();

        return response()->json("existe(m) {$UCsCount} UC(s) cadastrada(s)", 200);
    }


    //mostra a UC com esse id
    public function show($id)
    {
        $UC = UnidadeCurricular::where('id', '=', $id)->first();

        return response()->json($UC, 200);
    }



    //Atualiza os dados das UCs
    public function update(UpdateUnidadeCurricularRequest $request, $id)
    {
        // Retorna boolean = True // False
        $UCExists = UnidadeCurricular::where('id', '=', $id)->exists();

        if ($UCExists === false) {

            return response()->json([
                "status" => false,
                "message" => 'O curso escolhido não existe',
                "data" => [],
            ], 400);
        }

        $UC = UnidadeCurricular::where('id', '=', $id)->first();

        $UC->nome_uc = $request->nome_uc;
        $UC->descricao = $request->descricao;
        $UC->ects = $request->ects;

        $UC->save();

        $updMessage = "A unidade curricular {$UC["nome_uc"]} foi atualizada e possui {$UC["ects"]} ects.";

        return response()->json($updMessage, 202);

    }



    //conta o numero de UCs na base de dados



    public function destroy($id)
    {
        $doesUcExists = UnidadeCurricular::where('id', $id)->exists();

        if (!$doesUcExists) {
            return response()->json([
                "status" => false,
                "message" => "Não foi possível encontrar a Unidade Curricular",
                "data" => [$doesUcExists],
            ], 400);
        }

        $uc = UnidadeCurricular::where('id', '=', $id)->first();

        $uc->delete();

        return response()->json([
            "status" => true,
            "message" => "UC removida com sucesso",
            "data" => [$uc],
        ], 200);
    }


    //pesquisa as UCs pelo título
    public function getUCs(Request $nome_uc)
    {

        $UCs = UnidadeCurricular::when($nome_uc->filled('nome_uc'), function ($query) use ($nome_uc) {
            return $query->where(
                'nome_uc',
                'like',
                '%' . $nome_uc->input('nome_uc') . '%'
            );
        })->get();

        return response()->json($UCs, 200);
    }
}
