<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla de permisos
 * Author: Mauricio Baquero Soto
 * Enero de 2.021
 * =====================================
 * Editado por / Fecha ediciòn
 * 
 */

class CreatePermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seg_permisos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('rol_id');//Relacion con Roles
            $table->unsignedBigInteger('caso_id');//Relacion con Permisos
            $table->boolean('lee')->default(0); // Puede leer Registro
            $table->boolean('crea')->default(0); // Puede crear Registro
            $table->boolean('edita')->default(0); // Puede editar Registro
            $table->boolean('elimina')->default(0); // Puede eliminar Registro

            $table->softDeletes();
            $table->timestamps();

            //CONSTRAINS
            $table->foreign('rol_id')->references('id')->on('seg_roles')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('caso_id')->references('id')->on('seg_caso_uso')
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
        Schema::dropIfExists('seg_permisos');
    }
}
