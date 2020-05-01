<?php

namespace Tecnovitalmedica\Http\Requests;

use Tecnovitalmedica\Http\Requests\Request;

class EquipoCreateRequest extends Request
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
      'url_imagen_equipo' => 'required', 
      'nombre_equipo_medico' => 'required', 
      'marca' => 'required', 
      'modelo' => 'required', 
      'serie' => 'required',
      'activo_fijo' => 'required',
      'ubicacion' => 'required',
    ];
  }
}
