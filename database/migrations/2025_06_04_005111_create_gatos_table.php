<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gatos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->integer('edad')->unsigned();
            $table->string('raza')->nullable();
            $table->integer('collar')->unique();
            $table->enum('estado', ['disponible', 'adoptado'])->default('disponible');
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
        Schema::dropIfExists('gatos');
    }
}
