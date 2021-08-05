<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimientoProductoTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('movimiento_productos', function (Blueprint $table) {
         $table->id();
         $table->enum('tipo_movimiento', ['INGRESO', 'EGRESO', 'ELIMINADO']);
         $table->integer('cantidad');
         $table->double('precio_unitario')->nullable();
         $table->double('iva')->nullable();
         $table->double('sub_total')->nullable();
         $table->double('total')->nullable();

         $table->unsignedBigInteger('productos_id');
         $table->foreign('productos_id', 'fk_ingresos_productos')->references('id')->on('productos');

         $table->unsignedBigInteger('ingresos_id')->nullable();
         $table->foreign('ingresos_id', 'fk_movimientoproductos_ingresos')->references('id')->on('ingresos');

         $table->unsignedBigInteger('salidas_id')->nullable();
         $table->foreign('salidas_id', 'fk_movimientoproductos_salidas')->references('id')->on('salidas');

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
      Schema::dropIfExists('movimiento_productos');
   }
}
