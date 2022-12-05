<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsumosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_insumos', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('sevicio_id');//Relacion a tabla de servicios
            $table->unsignedBigInteger('producto_id');//Relacion a tabla de productos
            $table->float('cantidad', 8, 2)->default(0);//Cantidad de producto
            $table->unsignedBigInteger('presentacion_id');//Relacion con tipo de presentacion, Unidad, Gramos, metros ETC {Parametro}
            $table->integer('costo_neto')->nullable(); //Valor del insumo
            $table->text('nota')->nullable(); //Notas del insumo
            $table->unsignedBigInteger('creado_por');// Usuario que crea el registro

            $table->softDeletes();
            $table->timestamps();

            //CONSTRAINS
            $table->foreign('sevicio_id')->references('id')->on('inv_servicios')
                ->onDelete('cascade')
                ->onUpdate('cascade'); 
            $table->foreign('producto_id')->references('id')->on('inv_productos')
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
        Schema::dropIfExists('inv_insumos');
    }
}
