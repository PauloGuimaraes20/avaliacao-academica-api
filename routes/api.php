<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlunosController;
use App\Http\Controllers\AvaliacoesController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\ProfessoresController;
use App\Http\Controllers\UnidadesCurricularesController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



//example route: Route::{command get/post}({modelName}, [{controllerName}, {commandInController}]);
//rotas do Aluno

Route::apiResource('Alunos', AlunosController::class);
Route::post("Alunos/login", [AlunosController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post("Alunos/logout", [AlunosController::class, 'logout']);
});


//rotas da Avaliação
Route::apiResource('Avaliacoes', AvaliacoesController::class);


//rotas do Curso
Route::apiResource('Cursos', CursosController::class);

Route::get("Cursos/procuraCurso/{nome_curso}", [CursosController::class, 'procCurso']);
Route::get("Cursos/count/Cursos", [CursosController::class, 'count']);



//rotas do Professor
Route::apiResource('Professores', ProfessoresController::class);

Route::get("Professores/show/{id}", [ProfessoresController::class, 'show']);


//rotas da Unidade Curricular
Route::apiResource('UCs', UnidadesCurricularesController::class);

Route::get("UCs/count/UCs", [UnidadesCurricularesController::class, 'count']);
Route::get("UCs/{nome_uc}", [UnidadesCurricularesController::class, 'getUCs']);

