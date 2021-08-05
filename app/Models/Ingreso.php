<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingreso extends Model
{
   use HasFactory;
   use SoftDeletes;

   protected $table = 'ingresos';
   // protected $fillable = ['nombre', 'estado'];
   protected $guarded = ['id'];

   // **************** Relaciones *******************

   public function usuario_creador()
   {
      return $this->belongsTo('App\Models\User', 'creado_por');
   }

   public function usuario_editor()
   {
      return $this->belongsTo('App\Models\User', 'editado_por');
   }

   public function proveedor()
   {
      return $this->belongsTo(Proveedor::class, 'proveedores_id');
   }

   public function mov_producto()
   {
      return $this->hasMany(MovimientoProducto::class, 'ingresos_id');
   }

}
