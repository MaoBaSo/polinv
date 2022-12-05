<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhiteListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seg_white_list', function (Blueprint $table) {
            $table->id();

            $table->string('ip', 20); //IP autorizada
            $table->unsignedBigInteger('cliente_id');// Cliente a quien se autoriza la dirección
            $table->string('origen', 250); //Descripción de origen de conección Ej.Sede Central, equipo Juan
            $table->string('email_report', 100)->nullable(); //Email de reportes de conexiones fallidas.
            $table->unsignedBigInteger('creado_por');// Usuario que crea el registro
            
            $table->softDeletes();
            $table->timestamps();

            //CONSTRAINS  
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
        Schema::dropIfExists('seg_white_list');
    }
}
