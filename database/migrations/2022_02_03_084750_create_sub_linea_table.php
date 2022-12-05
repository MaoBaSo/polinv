<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubLineaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_sub_linea', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('linea_id');//Referencia de linea
            $table->string('nombre', 125);//Nombre de Sub Linea
            $table->text('caracteristicas')->nullable(); // Caracteristicas de la sub linea

            $table->softDeletes();
            $table->timestamps();

            //CONSTRAINS
            $table->foreign('linea_id')->references('id')->on('inv_linea')
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
        Schema::dropIfExists('inv_sub_linea');
    }
}
