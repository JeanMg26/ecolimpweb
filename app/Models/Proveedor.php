<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model
{
   use HasFactory;
   use SoftDeletes;

   protected $table   = 'proveedores';
   protected $dates   = ['deleted_at'];
   protected $guarded = ['id'];

   public function region()
   {
      return $this->belongsTo(Region::class, 'regiones_id');
   }

   public function provincia()
   {
      return $this->belongsTo(Provincia::class, 'provincias_id');
   }

   public function comuna()
   {
      return $this->belongsTo(Comuna::class, 'comunas_id');
   }
}
