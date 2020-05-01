<?php

namespace Tecnovitalmedica\Http\Requests;

use Tecnovitalmedica\Http\Requests\Request;

class UserCreateRequest extends Request
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
            'name' => 'required', 
            'email' => 'required|email|unique:users', 
            'tipo_cuenta' => 'required',
            'id_ciudad' => 'required', 
            //'id_institucion' => 'required', 
            //'celular' => 'required|digits:10', 
            //'telefono' => 'required|digits:7',
            'password' => 'required|min:6',
            'avatar' => 'required', 
        ];
    }
}
