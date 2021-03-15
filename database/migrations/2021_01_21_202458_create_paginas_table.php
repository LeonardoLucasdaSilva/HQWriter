<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaginasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paginas', function (Blueprint $table) {
            $table->id();
            $table->TEXT('conteudo');
            $table->string('plano');
            $table->string('angulo');
            $table->TEXT('anotacoes');
            $table->boolean('is_flashback');
            $table->boolean('is_subjetivo');
            $table->boolean('is_impacto');
            $table->boolean('is_off');
            $table->foreignId('roteiro_id')->references('id')->on('roteiros')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paginas');
    }
}
