<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cli_clientes', function (Blueprint $table) {
            $table->id();

            $table->string('nombre', 200); //Nombre del Cliente
            $table->string('nit', 20); //NIT del Cliente
            $table->string('direccion', 100); //Direccion del cliente
            $table->string('email', 100)->nullable(); //Direccion electronica del cliente
            $table->string('telefono_1', 50); //Telefono del cliente
            $table->string('telefono_2', 50)->nullable(); //Telefono del cliente
            $table->string('contacto', 100)->nullable(); //Nombre de contacto del cliente
            $table->string('telefono_contacto', 50)->nullable(); //Telefono de contacto en cliente
            $table->text('notas')->nullable(); //Notas del cliente
            //Datos de Localizacion
            $table->unsignedBigInteger('pais_id');// Pais de registro {Parametro}
            $table->unsignedBigInteger('ciudad_id');//Ciudad de registro {Parametro}
            $table->unsignedBigInteger('creado_por');// Usuario que crea el registro 

            $table->softDeletes();
            $table->timestamps();

            //CONSTRAINS  
            $table->foreign('pais_id')->references('id')->on('conf_parametros')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('ciudad_id')->references('id')->on('conf_parametros')
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
        Schema::dropIfExists('cli_clientes');
    }
}
