<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiciosAdminstrativoTiemposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv_administrativo_tiempos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('serv_servicios_id');//Referencia a la tabla de servicios
            $table->string('nuevo_tipo', 20); //Valoracion -> Orden Trabajo -> Orden Compra
            $table->boolean('nuevo_estado');//Estado del servicio 1=Abierto, 2=En Proceso, 3=Control Calidad(JPEX), 4=Cerrado(Aceptado Cliente), 5=Cancelado
            $table->unsignedBigInteger('creado_por');// Usuario que gestiona el registro 
            $table->text('nota')->nullable(); //Notas de procedimiento administrativo

            $table->softDeletes();
            $table->timestamps();

            //CONSTRAINS  
            $table->foreign('serv_servicios_id')->references('id')->on('serv_servicios')
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
        Schema::dropIfExists('serv_administrativo_tiempos');
    }
}
