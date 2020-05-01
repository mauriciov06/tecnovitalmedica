<?php

namespace Tecnovitalmedica\Http\Requests;

use Tecnovitalmedica\Http\Requests\Request;

class FileManagerCreateRequest extends Request
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
          'id_instituciones' => 'required', 
          'id_equipo_medico' => 'required', 
          'tipo_archivo' => 'required', 
          'nombre_archivo' => 'required', 
          'url_archivo' => 'required|mimes:pdf',
        ];
    }
}
