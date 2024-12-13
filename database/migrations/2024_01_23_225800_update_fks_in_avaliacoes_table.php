<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('avaliacoes')) {
            Schema::table('avaliacoes', function (Blueprint $table) {

                $table->unsignedTinyInteger('nota');

                $table->unsignedBigInteger('aluno_id')->nullable();
                $table->foreign('aluno_id')->references('id')->on('alunos');

                $table->unsignedBigInteger('professor_id')->nullable();
                $table->foreign('professor_id')->references('id')->on('professores');

                $table->unsignedBigInteger('curso_id')->nullable();
                $table->foreign('curso_id')->references('id')->on('cursos');

                $table->unsignedBigInteger('uc_id')->nullable();
                $table->foreign('uc_id')->references('id')->on('unidades_curriculares');
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('avaliacoes', function (Blueprint $table) {
            // Remova as colunas
            $table->dropColumn('nota');

            $table->dropForeign(['aluno_id']);
            $table->dropColumn('aluno_id');

            $table->dropForeign(['professor_id']);
            $table->dropColumn('professor_id');

            $table->dropForeign(['curso_id']);
            $table->dropColumn('curso_id');

            $table->dropForeign(['uc_id']);
            $table->dropColumn('uc_id');
        });

    }
};
