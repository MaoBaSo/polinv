<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seg_firmas', function (Blueprint $table) {
            $table->id();
                $table->unsignedBigInteger('servicio_id');//Codigo de servicio
                $table->unsignedBigInteger('token_id');//Codigo del token
                $table->string('proceso', 50);//Proceso que esta firmando
                $table->text('firma'); //LLAVE UNICA DE FIRMA**************************************
                $table->unsignedBigInteger('creado_por');//Codigo de usaurio creador de la firma
            $table->timestamps();

            //CONSTRAINS  
            $table->foreign('servicio_id')->references('id')->on('serv_servicios')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('token_id')->references('id')->on('seg_tokens')
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
        Schema::dropIfExists('seg_firmas');
    }
}
