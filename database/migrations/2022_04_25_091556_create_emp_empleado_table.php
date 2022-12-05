<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpEmpleadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_empleados', function (Blueprint $table) {
            $table->id();

                $table->string('identificacion', 50)->unique(); //Identificación de Empleado
                $table->string('primer_nombre', 100); //Nombre de Empleado
                $table->string('segundo_nombre', 100)->nullable(); //Nombre de Empleado
                $table->string('primer_apellido', 100); //Nombre de Empleado
                $table->string('segundo_apellido', 100)->nullable(); //Nombre de Empleado
                $table->unsignedBigInteger('pais_id');// Pais de registro {Parametro}
                $table->unsignedBigInteger('ciudad_id');//Ciudad de registro {Parametro}
                $table->unsignedBigInteger('cliente_id')->nullable();//Tabla Clientes
                $table->unsignedBigInteger('patio_id')->nullable();//Tabla Patios
                $table->unsignedBigInteger('especialidad_id');// Especialidad empleado {Parametro}
                $table->string('direccion', 200)->nullable(); //Dirección de Empleado
                $table->string('telefono_1', 50)->nullable(); //Teléfono 1 de Empleado
                $table->string('telefono_2', 50)->nullable(); //Teléfono 2 de Empleado
                $table->integer('valor_hora')->nullable(); //Valor de trabajo hora
                $table->integer('porcentaje_hora')->nullable(); //Porcentaje sobre valor bruto ítem
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
            $table->foreign('especialidad_id')->references('id')->on('conf_parametros')
                ->onDelete('cascade')
                ->onUpdate('cascade');                
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
        Schema::dropIfExists('emp_empleados');
    }
}
