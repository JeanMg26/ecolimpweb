<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedoresTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('proveedores', function (Blueprint $table) {
         $table->id();
         $table->string('nombre');
         $table->string('nom_fantasia')->nullable();
         $table->string('nrodoc');
         $table->string('email');
         $table->string('direccion');
         $table->string('telefono')->nullable();
         $table->boolean('estado');
         $table->string('nom_contacto');
         $table->string('nrodoc_contacto')->nullable();
         $table->string('cel_contacto')->nullable();
         $table->string('email_contacto');

         $table->unsignedBigInteger('regiones_id');
         $table->foreign('regiones_id', 'fk_proveedores_regiones')->references('id')->on('regiones')->onDelete('restrict')->onUpdate('restrict');

         $table->unsignedBigInteger('provincias_id');
         $table->foreign('provincias_id', 'fk_proveedores_provincias')->references('id')->on('provincias')->onDelete('restrict')->onUpdate('restrict');

         $table->unsignedBigInteger('comunas_id');
         $table->foreign('comunas_id', 'fk_proveedores_comunas')->references('id')->on('comunas')->onDelete('restrict')->onUpdate('restrict');

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
      Schema::dropIfExists('proveedores');
   }
}
