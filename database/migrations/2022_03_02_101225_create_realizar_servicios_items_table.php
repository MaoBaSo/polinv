<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealizarServiciosItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv_servicios_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('serv_servicios_id');//Referencia a la tabla de servicios
            $table->unsignedBigInteger('inv_servicios_id');//Referencia a la tabla de tipos de servicios
            $table->float('valor', 10, 2);//inv_servicios.valor_base_hora *  inv_servicios.tiempo_estandar, este valor puede ser editado por JPEX
            $table->integer('descuento')->default(0);//Descuento
            $table->string('accion', 100)->nullable(); //Accion del Ítem
            $table->integer('cant_img')->default(0); //Cantidad de imagenes subidas, despues se recuperan con un while
            $table->text('nota_item')->nullable(); //Notas del ítem
            $table->boolean('ok_revisado')->default(0); //Marcador de proceso de calidad

            $table->softDeletes();            
            $table->timestamps();

            //CONSTRAINS  
            $table->foreign('serv_servicios_id')->references('id')->on('serv_servicios')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('inv_servicios_id')->references('id')->on('inv_servicios')
                ->onDelete('cascade')
                ->onUpdate('cascade');                

            /**
             *Tabla de operarios vs item para seguimineto de tiempos y pago de comisiones 
             */


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('serv_servicios_items');
    }
}
