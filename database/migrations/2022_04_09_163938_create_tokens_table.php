<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seg_tokens', function (Blueprint $table) {
            $table->id();

                $table->unsignedBigInteger('user_id');//Codigo de usuario
                $table->string('token_private');//Clave privada
                $table->string('token_public');//Clave publica

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
        Schema::dropIfExists('seg_tokens');
    }
}
