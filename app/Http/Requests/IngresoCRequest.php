<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngresoCRequest extends FormRequest
{
   /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
   public function authorize()
   {
      return true;
   }

   /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
   public function rules()
   {
      return [

         // "producto_ingreso"   => "required|array|min:1",
         // "producto_ingreso.*" => "required|string|min:1",

         // "cantidad_ingreso"   => "required|array|min:1",
         // "cantidad_ingreso.*" => "required|string|min:1",

         // "precio_ingreso"     => "required|array|min:1",
         // "precio_ingreso.*"   => "required|string|min:1",

         // "iva"                => "required|array|min:1",
         // "iva.*"              => "required|string|min:1",

         // "total"              => "required|array|min:1",
         // "total.*"            => "required|string|min:1",

         'proveedor'       => 'required',
         'tipodoc_ingreso' => 'required',
         'nrodoc_ingreso'  => 'required|max:12'

      ];
   }
}
