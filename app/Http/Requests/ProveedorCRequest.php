<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorCRequest extends FormRequest
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
         'nom_proveedor'    => 'required|min:6|max:50|unique:proveedores,nombre,NULL,id,deleted_at,NULL',
         'nom_fantasia'     => 'required|min:6|max:50',
         'nrodoc_proveedor' => 'required|min:12|max:12|unique:proveedores,nrodoc,NULL,id,deleted_at,NULL',
         'email_proveedor'  => 'required|email|max:50|unique:proveedores,email,NULL,id,deleted_at,NULL',
         'dir_proveedor'    => 'required|max:50',
         'tel_proveedor'    => 'nullable|min:9|max:9',
         'est_proveedor'    => 'required',

         'region'           => 'required',
         'provincia'        => 'required',
         'comuna'           => 'required',

         'nom_contacto'     => 'required|max:40|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
         'nrodoc_contacto'  => 'nullable|min:12|max:12',
         'email_contacto'   => 'required|email|max:50',
         'cel_contacto'     => 'nullable|min:9|max:9'
      ];
   }
}
