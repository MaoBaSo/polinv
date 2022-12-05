<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_productos', function (Blueprint $table) {
            $table->id();
            
            $table->string('nombre', 200); //Nombre de producto
            $table->string('sku', 100)->unique(); //Stock Keeping Unit, Codigo de producto o servicio
            $table->string('numero_parte', 200)->nullable(); //Numero de parte del producto
            $table->string('oem', 200)->nullable(); //OEM de producto
            $table->unsignedBigInteger('presentacion_id');//Relacion con tipo de presentacion, Unidad, Gramos, metros ETC {Parametro}
            $table->unsignedBigInteger('fabricante_id')->nullable();//Fabricante del producto [Tabla asociada]
            $table->unsignedBigInteger('sublinea_id');//Relacion con sublinea Inventario [Tabla asociada]
            $table->integer('factor_maximo')->nullable(); //Maximo de producto
            $table->integer('factor_minimo')->nullable(); //Minimo de producto
            $table->text('caracteristicas')->nullable(); // Caracteristicas de producto
            $table->string('keywords', 150)->nullable();//Palabras clave de busqueda
            $table->unsignedBigInteger('creado_por');// Usuario que crea el registro
            //Datos de Localizacion
            $table->unsignedBigInteger('pais_id');// Pais de registro {Parametro}

            $table->softDeletes();
            $table->timestamps();

            //CONSTRAINS
            $table->foreign('fabricante_id')->references('id')->on('inv_fabricante')
                ->onDelete('cascade')
                ->onUpdate('cascade'); 
            $table->foreign('sublinea_id')->references('id')->on('inv_sub_linea')
                ->onDelete('cascade')
                ->onUpdate('cascade'); 
            $table->foreign('pais_id')->references('id')->on('conf_parametros')
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
        Schema::dropIfExists('inv_productos');
    }
}
