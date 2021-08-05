<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salida extends Model
{
   use HasFactory;
   use SoftDeletes;

   protected $table = 'salidas';
   // protected $fillable = ['nombre', 'estado'];
   protected $guarded = ['id'];

   public function usuario_creador()
   {
      return $this->belongsTo('App\Models\User', 'creado_por');
   }

   public function usuario_editor()
   {
      return $this->belongsTo('App\Models\User', 'editado_por');
   }

   public function instalacion()
   {
      return $this->belongsTo(Instalacion::class, 'instalaciones_id');
   }

}
