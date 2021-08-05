<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('productos', function (Blueprint $table) {
         $table->id();
         $table->string('nombre');
         $table->string('codigo');
         $table->string('presentacion');
         $table->string('descripcion')->nullable();
         $table->boolean('estado');
         $table->string('rutaimagen')->nullable();
         $table->string('cant_minima')->nullable();
         $table->integer('user_ing');
         $table->softDeletes();

         $table->unsignedBigInteger('categorias_id');
         $table->foreign('categorias_id', 'fk_categorias_categorias')->references('id')->on('categorias')->onDelete('restrict')->onUpdate('restrict');

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
      Schema::dropIfExists('productos');
   }
}
