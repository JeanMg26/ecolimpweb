<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalidasTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('salidas', function (Blueprint $table) {
         $table->id();
         $table->string('codigo');
         $table->datetime('fecha_inicial');
         $table->datetime('fecha_final');
         $table->integer('creado_por');
         $table->integer('editado_por')->nullable();
         $table->string('observaciones')->nullable();
         $table->string('recibido_por')->nullable();

         $table->unsignedBigInteger('instalaciones_id');
         $table->foreign('instalaciones_id', 'fk_salidas_instalaciones')->references('id')->on('instalaciones');

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
      Schema::dropIfExists('salidas');
   }
}
