<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('ingresos', function (Blueprint $table) {
         $table->id();
         $table->string('codigo')->nullable();
         $table->string('tipodoc');
         $table->string('nrodoc');
         $table->string('observaciones')->nullable();
         $table->integer('creado_por');
         $table->integer('editado_por')->nullable();
         $table->datetime('fecha_emision');
         $table->unsignedBigInteger('proveedores_id');
         $table->foreign('proveedores_id', 'fk_ingresos_proveedores')->references('id')->on('proveedores')->onDelete('restrict')->onUpdate('restrict');

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
      Schema::dropIfExists('ingresos');
   }
}
