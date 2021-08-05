<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('empleados', function (Blueprint $table) {
         $table->id();
         $table->string('nombres');
         $table->string('apellidos');
         $table->string('completos')->nullable();
         $table->string('email');
         $table->char('genero');
         $table->string('tipodoc');
         $table->string('nrodoc');
         $table->date('fec_nac')->nullable();
         $table->string('celular')->nullable();
         $table->string('rutaimagen')->nullable();
         $table->boolean('estado');
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
      Schema::dropIfExists('empleados');
   }
}
