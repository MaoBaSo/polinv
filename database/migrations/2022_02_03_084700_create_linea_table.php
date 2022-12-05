<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_linea', function (Blueprint $table) {
            $table->id();
            
            $table->string('nombre', 125);//Nombre de Linea
            $table->text('caracteristicas')->nullable(); // Caracteristicas de la linea
            $table->unsignedBigInteger('pais_id')->nullable();// Pais de la Linea {Parametro}

            $table->softDeletes();
            $table->timestamps();
            
            //CONSTRAINS
            $table->foreign('pais_id')->references('id')->on('conf_parametros')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_linea');
    }
}
