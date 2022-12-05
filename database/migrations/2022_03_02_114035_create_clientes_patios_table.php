<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesPatiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cli_patios', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cliente_id');//Referencia a la tabla de clientes
            $table->string('nombre', 250); //Nombre de patio
            $table->string('direccion', 100); //Direccion del patio

            $table->softDeletes();
            $table->timestamps();

            //CONSTRAINS  
            $table->foreign('cliente_id')->references('id')->on('cli_clientes')
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
        Schema::dropIfExists('cli_patios');
    }
}
