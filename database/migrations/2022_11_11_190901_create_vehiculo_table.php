<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flt_vehiculo', function (Blueprint $table) {
            $table->id();
                
                //DATOS PUNTEROS
                $table->string('token', 200)->unique(); //Token de Vehículo
                $table->string('placa',10)->unique(); // Placa del vehículo
                $table->unsignedBigInteger('cliente_id');//Referencia a la tabla de clientes
                $table->unsignedBigInteger('patio_id');//Referencia a la tabla de patios de clientes
                //DATOS IDENTIDAD
                $table->string('numero_motor', 80)->unique()->nullable(); // Numero de Motor
                $table->string('numero_chasis', 80)->unique()->nullable(); //Numero de Chasis
                $table->string('modelo', 10)->nullable(); //Modelo del vehículo
                $table->unsignedBigInteger('tipo_vehiculo');// Tipo de vehículo se lee de la tabla de {{parámetros}} automovil, bus, buceta
                $table->string('cilindrada', 10)->nullable(); // Cilindrada del vehículo
                //DATOS DISTINTIVOS
                $table->integer('capacidad_toneladas')->nullable(); // Capacidad en toneladas del vehículo
                $table->integer('cantidad_ejes')->nullable(); // Cantidad Ejes del vehículo
                $table->integer('capacidad_pasajeros')->nullable(); // Capacidad pasajeros del vehículo                    
                $table->unsignedBigInteger('tipo_combustible');//Tipo de servicio lee de la tabla de {{parámetros}} gasolina, gas, diesel.....
                $table->unsignedBigInteger('tipo_servicio');//Tipo de servicio lee de la tabla de {{parámetros}} particular, publico, diplomatico.....
                $table->string('color', 100)->nullable(); // Color del vehículo
                $table->string('movil',60)->nullable(); // Movil del vehículo  
                //DATOS LEGALES
                $table->unsignedBigInteger('ciudad_matricula')->nullable();// Ciudad de matrícula del vehículo {{Parametro}}
                $table->unsignedBigInteger('ciudad_rodamiento')->nullable();// Ciudad de rodamiento del vehículo {{Parametro}}
                $table->date('vencimiento_impuesto'); // Vencimiento de IMPUESTO
                $table->date('vencimiento_tm'); // Vencimiento de Tecnomecanica
                $table->date('vencimiento_soat'); // Vencimiento de SOAT
                $table->date('vencimiento_seguro_1')->nullable(); // Vencimiento POLIZA 1
                $table->date('vencimiento_seguro_2')->nullable(); // Vencimiento POLIZA 2
                $table->date('vencimiento_seguro_3')->nullable(); // Vencimiento POLIZA 3
                //DATOS FINANCIEROS
                $table->integer('valor_inventario')->nullable(); // Valor inventario del vehículo
                //DATOS OPERATIVOS DE VENCIMIENTO DE REVISIONES
                $table->integer('km_actual')->nullable(); //Kilometraje actual del vehículo
                $table->integer('horas_prox_servicio')->nullable(); //Horas para el proximo servicio
                $table->dateTime('fecha_prox_servicio', $precision = 0)->nullable();//fecha del proximo servicio
                $table->date('actualizacion_vencimiento')->nullable(); // fecha actualización de klimometraje

                $table->text('nota')->nullable(); //Notas del vehículo

            $table->softDeletes();
            $table->timestamps();

            //CONSTRAINS
            $table->foreign('cliente_id')->references('id')->on('cli_clientes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('patio_id')->references('id')->on('cli_patios')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('tipo_vehiculo')->references('id')->on('conf_parametros')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('tipo_combustible')->references('id')->on('conf_parametros')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('tipo_servicio')->references('id')->on('conf_parametros')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('ciudad_matricula')->references('id')->on('conf_parametros')
                ->onDelete('cascade')
                ->onUpdate('cascade'); 
            $table->foreign('ciudad_rodamiento')->references('id')->on('conf_parametros')
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
        Schema::dropIfExists('flt_vehiculo');
    }
}
