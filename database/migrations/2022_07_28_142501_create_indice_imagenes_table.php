<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndiceImagenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv_indice_imagenes', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('item_id');//Relacion con la tabla de ítems
            $table->integer('origen'); //Origen de la imagen 1=Valorización, 2=Calidad
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
        Schema::dropIfExists('serv_indice_imagenes');
    }
}
