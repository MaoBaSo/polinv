<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Casos de uso
 * Author: Mauricio Baquero Soto
 * Enero de 2.021
 * =====================================
 * Editado por / Fecha ediciòn
 * 
 */

class CreateCasoUsosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seg_caso_uso', function (Blueprint $table) {
            $table->id();

            $table->string('caso_uso', 100)->unique(); //Nombre del Caso de Uso
            $table->string('slug', 120); //Slug del caso de uso
            $table->string('nota', 200)->nullable(); //Nota

            $table->softDeletes();
            $table->timestamps();

            //CONSTRAINS
            $table->index('caso_uso');            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seg_caso_uso');
    }
}
