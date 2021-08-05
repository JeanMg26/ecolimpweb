<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstalacionERequest extends FormRequest
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
         'nom_instalacion'    => 'required|max:50|unique:instalaciones,nombre,' . $this->instalacione . ',id,deleted_at,NULL',
         'nrodoc_instalacion' => 'required|min:12|max:12|unique:instalaciones,nrodoc,' . $this->instalacione . ',id,deleted_at,NULL',
         'email_instalacion'  => 'required|email|max:50|unique:instalaciones,email,' . $this->instalacione . ',id,deleted_at,NULL',
         'dir_instalacion'    => 'required|max:50',
         'tel_instalacion'    => 'nullable|min:9|max:9',
         'est_instalacion'    => 'required',

         'region'             => 'required',
         'provincia'          => 'required',
         'comuna'             => 'required',

         'nom_contacto'       => 'required|max:40|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
         'nrodoc_contacto'    => 'nullable|min:12|max:12',
         'email_contacto'     => 'required|email|max:50',
         'cel_contacto'       => 'nullable|min:9|max:9'
      ];
   }
}
