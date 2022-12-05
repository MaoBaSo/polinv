<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperacionCalidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ope_calidad', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('serv_servicios_id');//Referencia a la tabla de servicios
            $table->unsignedBigInteger('item_id');//Referencia a la tabla de servicios
            $table->integer('cant_img')->default(0); //Cantidad de imagenes subidas, despues se recuperan con un while
            $table->unsignedBigInteger('creado_por');// Usuario que gestiona el registro 
            $table->text('nota')->nullable(); //Notas de procedimiento administrativo
            $table->boolean('estado_revision');//Estado de la revision del servicio 0=No pasa, 1=Pasa

            $table->softDeletes();
            $table->timestamps();

            //CONSTRAINS  
            $table->foreign('serv_servicios_id')->references('id')->on('serv_servicios')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('item_id')->references('id')->on('serv_servicios_items')
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
        Schema::dropIfExists('ope_calidad');
    }
}
