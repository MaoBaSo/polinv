<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKardexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_kardex', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('producto_id');//Relacion a producto [Tabla asociada]
            $table->string('tipo_movimiento', 100); //Tipo de movimiento de producto Entrada = E, Transferencia = T, Salida = S, Ajuste = A {Parametro}
            $table->unsignedBigInteger('proveedor_id')->nullable();//Relacion a proveedores [Tabla asociada]
            $table->string('documento_referencia', 10)->nullable();//Numero de documento del movimiento
            $table->date('vencimiento_garantia')->nullable();//Fecha de vencimiento garantia
            $table->unsignedBigInteger('bodega_procedencia')->nullable();//Bodega desde donde viene el producto [Tabla asociada]
            $table->unsignedBigInteger('bodega_destino')->nullable();//Bodega desde donde viene el producto [Tabla asociada]
            $table->integer('cantidad_movimiento'); //Cantidad del movimiento
            $table->integer('costo_bruto')->nullable(); //Valor de compra
            $table->integer('iva')->nullable(); //valor de IVA
            $table->integer('costo_neto')->nullable(); //valor de IVA 
            $table->text('nota')->nullable(); //Notas de la transaccion
            $table->unsignedBigInteger('creado_por');// Usuario que crea el registro
            
            $table->softDeletes();
            $table->timestamps();

            //CONSTRAINS
            $table->foreign('producto_id')->references('id')->on('inv_productos')
                ->onDelete('cascade')
                ->onUpdate('cascade');             
            $table->foreign('proveedor_id')->references('id')->on('inv_proveedores')
                ->onDelete('cascade')
                ->onUpdate('cascade');                 
            $table->foreign('bodega_procedencia')->references('id')->on('inv_bodegas')
                ->onDelete('cascade')
                ->onUpdate('cascade');  
            $table->foreign('bodega_destino')->references('id')->on('inv_bodegas')
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
        Schema::dropIfExists('inv_kardex');
    }
}
