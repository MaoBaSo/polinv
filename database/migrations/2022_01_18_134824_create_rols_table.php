<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Roles del sistema
 * Author: Mauricio Baquero Soto
 * Enero de 2.021
 * =====================================
 * Editado por / Fecha ediciòn
 * 
 */

class CreateRolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seg_roles', function (Blueprint $table) {
            $table->id();

            $table->string('nombre', 100)->unique(); //Nombre del Rol
            $table->string('slug', 120); //Slug del Rol
            $table->string('nota', 200)->nullable(); //Nota

            $table->softDeletes();
            $table->timestamps();

            //CONSTRAINS
            $table->index('nombre');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seg_roles');
    }
}
