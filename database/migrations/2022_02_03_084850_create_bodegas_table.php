<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBodegasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_bodegas', function (Blueprint $table) {
            $table->id();
            
            $table->string('nombre', 200); //Nombre de bodega
            $table->string('direccion', 250)->nullable();//Direccion de la bodega
            $table->string('referencia_direccion', 250)->nullable();//referencia de la direccion
            $table->text('notas')->nullable(); //Notas de la bodega
            $table->unsignedBigInteger('creado_por');// Usuario que crea el registro
            //Datos de Localizacion
            $table->unsignedBigInteger('pais_id');// Pais de registro {Parametro}
            $table->unsignedBigInteger('ciudad_id');//Ciudad de registro {Parametro}
            
            $table->softDeletes();
            $table->timestamps();
            
            //CONSTRAINS
            $table->foreign('pais_id')->references('id')->on('conf_parametros')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('ciudad_id')->references('id')->on('conf_parametros')
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
        Schema::dropIfExists('inv_bodegas');
    }
}
