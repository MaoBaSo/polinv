<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServDescuentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv_descuentos', function (Blueprint $table) {
            $table->id();
                $table->unsignedBigInteger('serv_servicios_id');//Referencia a la tabla de servicios
                $table->unsignedBigInteger('item_servicios_id');//Referencia a la tabla item servicios
                $table->integer('valor')->default(0); //Valor de descuento
                $table->text('nota_descuento')->nullable(); //Motivo descuento
                $table->unsignedBigInteger('creado_por');// Usuario que crea el registro
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
        Schema::dropIfExists('serv_descuentos');
    }
}
