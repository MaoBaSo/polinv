<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUbicacionBodegaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cli_ubicacion_bodega', function (Blueprint $table) {
            $table->id();

                $table->unsignedBigInteger('patio_id');// Patio del cliente
                $table->unsignedBigInteger('bodega_id');//Bodega asignada al patio
                $table->text('nota')->nullable();
                $table->unsignedBigInteger('creado_por');// Usuario que crea el registro             
            
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
        Schema::dropIfExists('cli_ubicacion_bodega');
    }
}
