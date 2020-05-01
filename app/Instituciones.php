<?php

namespace Tecnovitalmedica;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Instituciones extends Model
{
  protected $table = 'instituciones';

  protected $fillable = ['id_contacto_usuario', 'nombre_instituciones', 'email_instituciones' ,'id_ciudad', 'celular_instituciones', 'telefono_instituciones', 'direccion_instituciones' ,'avatar_instituciones', 'nombre_carpeta_institucion'];

  //Se crea un mutador para modificar elementos antes de ser guardados.
  public function setAvatarInstitucionesAttribute($avatar){
    if(!empty($avatar && $avatar != 'default-avatar.png')){
        $name = Carbon::now()->second.$avatar->getClientOriginalName();
        $this->attributes['avatar_instituciones'] = $name;
        \Storage::disk('local')->put($name, \File::get($avatar));
    }else{
        $this->attributes['avatar_instituciones'] = 'default-avatar.png';
    }
  }

  public function scopeBusquedaInstitucion($query, $name, $correo, $ciudad){
    if(trim($name) != ''){
      return $query->where('nombre_instituciones', 'LIKE', "%$name%");
    }elseif(trim($correo) != ''){
      if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
        return $query->where('email_instituciones', $correo);
      }
    }elseif($ciudad != ''){
      return $query->where('id_ciudad', $ciudad);
    }
  }
}
