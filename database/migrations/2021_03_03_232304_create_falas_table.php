<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFalasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('falas', function (Blueprint $table) {
            $table->id();
            $table->string('conteudo');
            $table->string('balao');
            $table->foreignId('char_id')->references('id')->on('chars');
            $table->foreignId('pagina_id')->references('id')->on('paginas');
            $table->softDeletes();
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
        Schema::dropIfExists('falas');
    }
}
