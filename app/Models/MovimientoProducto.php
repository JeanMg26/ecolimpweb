<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovimientoProducto extends Model
{
   use HasFactory;
   use SoftDeletes;

   protected $table = 'movimiento_productos';

   public function producto()
   {
      return $this->belongsTo(Producto::class, 'productos_id');
   }

   public function salida()
   {
      return $this->belongsTo(Salida::class, 'salidas_id');
   }

}
