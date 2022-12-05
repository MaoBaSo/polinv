<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_servicios', function (Blueprint $table) {
            $table->id();

            $table->string('nombre', 200); //Nombre de servicio
            //********************************************************************************************************* */
            //Código de SKU se hace con la unión de (codigo_servicio + tipo_vehiculo)
            $table->string('sku', 100)->unique();//Stock Keeping Unit -> Se hace en forma automática por el sistema.
            $table->string('codigo_servicio', 50); //Código de servicio
            $table->string('tipo_vehiculo', 50); //Tipo de vehículo se lee de la tabla de parámetros
            //********************************************************************************************************* */
            $table->integer('valor_reparar_pintar')->default(0); //Valor reparar
            $table->integer('valor_cambiar_pintar')->default(0); //Valor cambiar
            $table->integer('valor_cambiar_reparar')->default(0); //Valor pintar
            $table->integer('valor_fabricar')->default(0); //Valor fabricar
            $table->integer('valor_base_hora')->default(0); //Valor base hora
            $table->float('tiempo_estandar', 8, 2)->default(0); //tiempo estandar del servicio en HORAS
            $table->text('caracteristicas')->nullable(); // Caracteristicas del servicio
            //Datos de Localizacion
            $table->unsignedBigInteger('pais_id');// Pais de registro {Parametro}

            $table->softDeletes();
            $table->timestamps();

            //CONSTRAINS 
            $table->foreign('pais_id')->references('id')->on('conf_parametros')
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
        Schema::dropIfExists('inv_servicios');
    }
}
