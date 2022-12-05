<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seg_logs', function (Blueprint $table) {
            $table->id();

            $table->string('procedencia', 250);//Procedencia del registro
            $table->string('tipo', 50);//Tipo de Log
            $table->text('descripcion')->nullable(); // Descripcion del log
            $table->softDeletes();
            $table->timestamps();

            //CONSTRAINS
            $table->index('procedencia');

        /**NOTA DE PROGRAMACION
         * Tabla de gestion de logs de operaciones sensibles o errores 
         */

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seg_logs');
    }
}
