<?php

namespace App\Http\Requests;

use App\Rules\ValidarPassword;
use App\Rules\ValidarContraseña;
use Illuminate\Foundation\Http\FormRequest;

class UsuarioERequest extends FormRequest
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
         'nom_usu'    => 'required|string',
         'username'        => 'required|string|unique:users,username,' . $this->usuario . ',id,deleted_at,NULL',
         'email_usu'      => 'required|email|max:40|unique:users,email,' . $this->usuario . ',id,deleted_at,NULL',
         'est_usu'        => 'required',
         'rol_usu'        => 'required',
         'oldpass_usu'    => ['sometimes', 'required', new ValidarPassword],
         'pass_usu'       => 'sometimes|required|min:6|max:20',
         'repass_usu'     => 'sometimes|required|same:pass_usu|min:6|max:20',
         'imagen_usu'     => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
      ];
   }
}
