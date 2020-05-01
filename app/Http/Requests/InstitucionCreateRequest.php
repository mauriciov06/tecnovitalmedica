<?php

namespace Tecnovitalmedica\Http\Requests;

use Tecnovitalmedica\Http\Requests\Request;

class InstitucionCreateRequest extends Request
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
        'nombre_instituciones' => 'required', 
        'email_instituciones' => 'required|email|unique:instituciones', 
        'id_ciudad' => 'required', 
        'nombre_carpeta_institucion' => 'required',
        //'celular_instituciones' => 'required|digits:10', 
        //'telefono_instituciones' => 'required|digits:7',
        //'direccion_instituciones' => 'required',
        //'avatar_instituciones' => 'required',
      ];
    }
}
