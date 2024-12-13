<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Http\Requests\StoreCursoRequest;
use App\Http\Requests\UpdateCursoRequest;

class CursosController extends Controller
{

    //Cadastra um novo curso
    public function store(StoreCursoRequest $request)
    {

        try
        {
            $course = new Curso();

            $course->codigo = $request->codigo;
            $course->nome_curso = $request->nome_curso;
            $course->descricao = $request->descricao;
            $course->acronimo = $request->acronimo;

            $course->save();

        }
        catch (\Exception $error)
        {

            return response()->json([
                "status" => false,
                "message" => 'Ocorreu um erro no servidor',
                "data" => [$error]
            ], 500);
        }

        return response()->json($course, 201);

    }



    //mostra todos os cursos
    public function index()
    {
        $curs = Curso::all();

        return response()->json($curs, 200);
    }



    //mostra os cursos criados
    public function show($id)
    {
        $course = Curso::where('id', '=', $id)->first();

        return response()->json($course, 200);
    }



    //Atualiza os dados do cuso
    public function update(UpdateCursoRequest $request, $id)//inverter id e request
    {
        // Retorna boolean = True // False
        $courseExists = Curso::where('id', '=', $id)->exists();

        if ($courseExists === false) {

            return response()->json([
                "status" => false,
                "message" => 'O curso escolhido não existe',
                "data" => [$courseExists],
            ], 400);
        }

        $course = Curso::where('id', '=', $id)->first();

        $course->codigo = $request->codigo;
        $course->nome_curso = $request->nome_curso;
        $course->descricao = $request->descricao;
        $course->acronimo = $request->acronimo;

        $course->save();

        $updMessage = "o curso {$course["nome_curso"]} foi atualizado e possui o código {$course["codigo"]}.";
        //$course->courseUnits()->sync($request->course_units);

        return response()->json($updMessage, 202);

    }



    //conta o numero de cursos na base de dados
    public function count()
    {
        $numCursos = Curso::count();
        $cursCount ="Existe(m) {$numCursos} curso(s) cadastrado(s)";

        return response()->json($cursCount, 200);
    }



    public function destroy($id)
    {
        $doesCurExists = Curso::where('id', $id)->exists();

        if (!$doesCurExists) {
            return response()->json([
                "status" => false,
                "message" => "Não foi possível encontrar o curso",
                "data" => [$doesCurExists],
            ], 400);
        }

        $cur = Curso::where('id', '=', $id)->first();

        $cur->delete();

        return response()->json([
            "status" => true,
            "message" => "Curso removido com sucesso",
            "data" => [$cur],
        ], 200);
    }



    //pesquisa os cursos pelo título
    public function procCurso($nomeCurso)
    {

        if (!empty($nomeCurso) && strlen($nomeCurso) <= 5) {
            $curs = Curso::where(function ($query) use ($nomeCurso) {
                return $query->where(
                    'acronimo',
                    'like',
                    '%' . $nomeCurso . '%'
                );
            })->get();

            return response()->json($curs, 200);
        }


        if (!empty($nomeCurso))
        {
            $curs = Curso::where( function ($query) use ($nomeCurso) {
                return $query->where(
                    'nome_curso',
                    'like',
                    '%' . $nomeCurso . '%'
                );
            })->get();

            return response()->json($curs, 200);
        }


        return response()->json("Curso não encontrado", 400);
    }



}
