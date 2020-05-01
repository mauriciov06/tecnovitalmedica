<?php

namespace Tecnovitalmedica;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Equipos_medicos extends Model
{
  protected $table = 'equipos_medicos';

  protected $fillable = ['id_instituciones', 'nombre_equipo_medico', 'marca' ,'modelo', 'activo_fijo', 'serie', 'ubicacion' ,'url_imagen_equipo'];

  public static function equiposmedicos($id){
    return Equipos_medicos::where('id_instituciones','=',$id)
    ->get();
  }

  public function setUrlImagenEquipoAttribute($avatar){
    if(!empty($avatar)){
      $name = Carbon::now()->second.$avatar->getClientOriginalName();
      $this->attributes['url_imagen_equipo'] = $name;
      \Storage::disk('local')->put($name, \File::get($avatar));
    }
  }  

  public function scopeBusquedaEquipo($query, $name, $ubicacion_equipo, $serie, $institucion){
    if(trim($name) != ''){
      return $query->where('nombre_equipo_medico', 'LIKE', "%$name%");
    }elseif(trim($ubicacion_equipo) != ''){
      return $query->where('ubicacion', $ubicacion_equipo);
    }elseif(trim($serie) != ''){
      return $query->where('serie', $serie);
    }elseif($institucion != ''){
      return $query->where('id_instituciones', $institucion);
    }
  }
}
