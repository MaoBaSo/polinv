<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndiceImagenesFlotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flt_indice_imagenes_flotas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('vehiculo_id');//Relacion con la tabla de vehículos
            $table->integer('origen'); //Origen de la imagen 1=Inventario, N=tipo de foto requerida
            $table->string('nombre_archivo', 250)->unique();// Nombre del archivo cargado
            $table->text('url')->nullable(); //URL de ubicación de archivo

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
        Schema::dropIfExists('flt_indice_imagenes_flotas');
    }
}
