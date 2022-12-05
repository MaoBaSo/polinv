<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendaServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flt_agenda_servicios', function (Blueprint $table) {
            $table->id();

                //DATOS PUNTEROS
                $table->unsignedBigInteger('vehiculo_id');//Referencia a la tabla de vehículos
                $table->string('token', 200); //Token de Vehículo
                $table->string('placa',10); // Placa del vehículo
                $table->unsignedBigInteger('cliente_id')->nullable();//Referencia a la tabla de clientes
                $table->unsignedBigInteger('patio_id')->nullable();//Referencia a la tabla de patios de clientes
                //DATOS DEL SERVICIO
                $table->unsignedBigInteger('inv_servicios_id')->nullable();//Tipo de servicio referencia a la tabla de servicios
                $table->dateTime('fecha_solicitada', $precision = 0);// Fecha de solicitud
                $table->dateTime('fecha_aprobada', $precision = 0); //Fecha aprobada para el servicio
                $table->text('descripcion')->nullable(); //Descripción del servicio a solicitar
                $table->unsignedBigInteger('user_id');//Creado por referencia tabla usuarios
                $table->string('origen',30); // Sistema, Manual

                //DATOS DEL PRESTADOR
                $table->unsignedBigInteger('proveedor_id')->nullable();//Proveedor encargado del servicio referencia a la tabla de proveedores
            
            $table->softDeletes();
            $table->timestamps();

            //CONSTRAINS
            $table->foreign('vehiculo_id')->references('id')->on('flt_vehiculo')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('cliente_id')->references('id')->on('cli_clientes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('patio_id')->references('id')->on('cli_patios')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('inv_servicios_id')->references('id')->on('inv_servicios')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('proveedor_id')->references('id')->on('inv_proveedores')
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
        Schema::dropIfExists('flt_agenda_servicios');
    }
}
