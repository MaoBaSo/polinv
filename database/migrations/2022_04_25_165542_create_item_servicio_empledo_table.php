<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemServicioEmpledoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ope_item_servicio_empledo', function (Blueprint $table) {
            $table->id();

                $table->string('token', 200)->unique(); //Token de cobro
                $table->unsignedBigInteger('servicio_id');// Servicio
                $table->unsignedBigInteger('item_id');// ítem del servicio
                $table->unsignedBigInteger('empleado_id');// Empleado responsable del servicio
                $table->integer('valor_comision'); //Valor de comisión de la reparacion viene de inv_servicio
                $table->integer('porcentaje'); //Porcentaje a pagar al tecnico
                $table->integer('valor_pagar'); //Valor efectivo a pagar al técnico sobre el item
                $table->integer('estado'); //1=Asignado, 2=Recibido, 3=Terminado, 4=Lista Pago, 5=Cancelado, incia con valor 1 
                $table->string('nota', 200)->nullable(); //Nota
                $table->unsignedBigInteger('creado_por');// Usuario que crea el registro
            
            $table->softDeletes();
            $table->timestamps();

            //CONSTRAINS  
            $table->foreign('servicio_id')->references('id')->on('serv_servicios')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('item_id')->references('id')->on('serv_servicios_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');     
            $table->foreign('empleado_id')->references('id')->on('emp_empleados')
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
        Schema::dropIfExists('ope_item_servicio_empledo');
    }
}
