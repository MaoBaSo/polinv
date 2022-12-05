<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('tipo_id')->default(0); //Tipo de usuario, esta en tabla parametros, inicialmente Administrador, Laboratorio(Carparts) y Cliente, predeterminado 0 = Sin Tipo
            $table->unsignedBigInteger('rol_id')->default(0); //Rol de el Usuario, Predeterminado 0 = Sin Rol
            $table->unsignedBigInteger('company_id')->nullable(); //Compañia a la cual pertenece el usuario
            $table->unsignedBigInteger('pais_id'); //Pais al que pertenece el usuario
            $table->unsignedBigInteger('patio_id')->nullable(); //Patio al que pertenece el usuario
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
