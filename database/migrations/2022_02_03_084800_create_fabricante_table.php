<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFabricanteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_fabricante', function (Blueprint $table) {
            $table->id();

            $table->string('nombre', 200); //Nombre de proveedor
            $table->text('caracteristicas')->nullable(); // Caracteristicas del fabricante
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_fabricante');
    }
}
