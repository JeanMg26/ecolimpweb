<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoERequest extends FormRequest
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
         'categoria'       => 'required',
         'cod_producto'    => 'required|string|unique:productos,codigo,' . $this->producto . ',id,deleted_at,NULL',
         'nom_producto'    => 'required',
         'presen_producto' => 'required',
         'cant_minima'     => 'required',
         'est_producto'    => 'required',
         'img_producto'    => 'nullable|image|mimes:jpeg,jpg,png|max:1024'
      ];
   }
}
