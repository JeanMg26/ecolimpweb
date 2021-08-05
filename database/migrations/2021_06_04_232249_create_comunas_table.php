<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComunasTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('comunas', function (Blueprint $table) {
         $table->id();
         $table->string('nombre');

         $table->unsignedBigInteger('provincias_id')->nullable();
         $table->foreign('provincias_id', 'fk_comunas_provincias')->references('id')->on('provincias')->onDelete('restrict')->onUpdate('restrict');

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
      Schema::dropIfExists('comunas');
   }
}
