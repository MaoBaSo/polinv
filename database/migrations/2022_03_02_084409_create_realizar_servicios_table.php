<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealizarServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv_servicios', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('patio_id');//Referencia a la tabla de patios de clientes
            $table->unsignedBigInteger('cliente_id');//Referencia a la tabla de clientes
            $table->unsignedBigInteger('pais_id');// Pais de registro {Parametro}
            $table->string('placa', 10)->default("N/A"); //Numero de placa de vehículo
            $table->string('movil', 20)->nullable(); //Numero de movil de vehículo
            $table->text('nota_servicio')->nullable(); //Notas del servicio
            //***************************************************************************************************************** */            
            $table->string('tipo', 20); //Valoracion -> Orden Trabajo -> Orden Compra
            $table->boolean('estado')->default(1);//Estado del servicio 1=Abierto, 2=En Proceso, 3=Control Calidad(JPEX), 4=Cerrado(Aceptado Cliente), 5=Cancelado
            /**
             * 1. Tipo Valoracion -> Estado Abierto = Inicio de proceso interviene solo personal JPEX.
             * 2. Tipo Orden Trabajo -> Estado En Proceso = Personal de cliente autoriza o acepta la valoración.
             * 3. Tipo Orden trabajo -> Estado Control Calidad(JPEX) = Supervisor JPEX realiza control de calidad.
             * 4. Tipo Orden Trabajo -> Estado Cerrado = Personal de Cliente acepta el trabajo.
             * 5. Tipo Orden Compra -> Estado Cerrado = Personal JPEX indica el numero de Orden de compra para realizar el cierre definitivo
             * 
             * Items 1 y 2 pueden tener estado 4   
             */
            //***************************************************************************************************************** */            
            $table->integer('valor_bruto_procedimiento')->nullable(); // Valor bruto de procedimiento / Sin IVA
            $table->string('numero_orden_trabajo', 250)->nullable(); //Numero de orden de trabajo
            $table->string('numero_orden_compra', 250)->nullable(); //Numero de orden de compra
            $table->unsignedBigInteger('creado_por');// Usuario que crea el registro 
            $table->dateTime('fecha_servicio', $precision = 0);//fecha de servicio

            $table->softDeletes();
            $table->timestamps();

        });

            /**NOTAS DE PROGRAMACION

            * Las fotografias se almacenan en la siguiente ruta
             * PUBLIC
             * ├──imgservices
             * │   └── Carpeta Código Ciente
             * │       └── [Código Ítem + Numero de imagen]
             */

            // SE DEBEN CARGAR LOS DIFERENTES PATIOS DEL CLIENTE, si usurio tiene patio, filtra de no tenerlo muestra todo
            //Procedimiento pára cambiar de patio a usuario

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('serv_servicios');
    }
}
