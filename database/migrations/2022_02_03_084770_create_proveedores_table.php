<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_proveedores', function (Blueprint $table) {
            $table->id();
                //DATOS PATRONIMICOS
                $table->string('token', 200)->unique(); //Token del proveedor
                $table->string('nombre', 200); //Nombre de proveedor
                $table->string('nit', 20); //NIT del Proveedor
                $table->string('codigo', 50); //Codigo de proveedor
                $table->string('email', 100)->nullable(); //Direccion electronica de proveedor
                $table->string('direccion', 100); //Direccion de proveedor
                $table->string('telefono_1', 50); //Telefono de proveedor
                $table->string('telefono_2', 50)->nullable(); //Telefono de proveedor
                $table->string('contacto', 100); //Nombre de contaco de proveedor
                $table->string('telefono_contacto', 50)->nullable(); //Telefono de contacto en proveedor
                $table->unsignedBigInteger('linea_id')->nullable();// Linea de distribucion del proveedor {{Parametro}}
                $table->integer('cupo_credito')->nullable(); //Cupo de credito del proveedor
                $table->unsignedBigInteger('pais_id');// Pais de registro {Parametro}
                $table->unsignedBigInteger('ciudad_id')->nullable();//Ciudad de registro {Parametro}

                //DATOS DE CONEXION A OTRO GSV
                $table->string('UUID_', 200)->unique()->nullable(); //Numero unico de programa externo SGV
                $table->string('TOKEN_', 250)->unique()->nullable(); //Token de conexion

            $table->softDeletes();
            $table->timestamps();

            //CONSTRAINS
            $table->foreign('linea_id')->references('id')->on('conf_parametros')
                ->onDelete('cascade')
                ->onUpdate('cascade');  
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
        Schema::dropIfExists('inv_proveedores');
    }
}
