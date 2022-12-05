<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelInventarioBodegaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_productorbodega', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('producto_id');//Relacion a producto en Inventarios [Tabla asociada
            $table->unsignedBigInteger('bodega_id');//Bodega a donde entra el producto [Tabla asociada]
            $table->integer('cantidad_actual'); //Cantidad actual del producto
            $table->unsignedBigInteger('creado_por');// Usuario que crea el registro   

            $table->softDeletes();
            $table->timestamps();

            //CONSTRAINS
            $table->foreign('producto_id')->references('id')->on('inv_productos')
                ->onDelete('cascade')
                ->onUpdate('cascade'); 
            $table->foreign('bodega_id')->references('id')->on('inv_bodegas')
                ->onDelete('cascade')
                ->onUpdate('cascade');                

        /** NOTAS DE PROGRAMACION
         * 
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
        Schema::dropIfExists('inv_productorbodega');
    }
}
