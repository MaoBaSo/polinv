<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Parametros del sistema
 * Author: Mauricio Baquero Soto
 * Enero de 2.021
 * =====================================
 * Editado por / Fecha ediciòn
 * 
 */

class CreateParametrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conf_parametros', function (Blueprint $table) {
            $table->id();

            $table->string('key', 100); //Referencia principal de parametro
            $table->string('descripcion', 100);//Descripcion del registro
            $table->string('modulos', 100)->nullable();//Modulos relacionados 
            $table->string('relacion', 100)->nullable();// Campo relacion, ID de registro relacionado de esta misma tabla
            $table->string('variable_1', 100);//Dato variable 1
            $table->string('variable_2', 100)->nullable();//Dato variable 1
            $table->string('variable_3', 100)->nullable();//Dato variable 2
            $table->string('variable_4', 100)->nullable();//Dato variable 3
            $table->text('script')->nullable(); //Script
            $table->boolean('de_sistema')->default(0); // Dato de manejo para el sistema, en caso de ser asi, NO podra ser Eliminado o Editado

            $table->softDeletes();
            $table->timestamps();

            //CONSTRAINS
            $table->index('key');
            $table->index('relacion');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conf_parametros');
    }
}
