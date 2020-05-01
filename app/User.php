<?php

namespace Tecnovitalmedica;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Carbon\Carbon;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
  use Authenticatable, Authorizable, CanResetPassword;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'users';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name', 'email', 'tipo_cuenta' ,'id_ciudad', 'id_institucion', 'celular', 'telefono', 'avatar' ,'password'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = ['password', 'remember_token'];

  public function setAvatarAttribute($avatar){
    if(!empty($avatar && $avatar != 'default-avatar.png')){
      $name = Carbon::now()->second.$avatar->getClientOriginalName();
      $this->attributes['avatar'] = $name;
      \Storage::disk('local')->put($name, \File::get($avatar));
    }else{
      $this->attributes['avatar'] = 'default-avatar.png';
    } 
  }

  public function setPasswordAttribute($valor){
    if(!empty($valor)){
        $this->attributes['password'] = bcrypt($valor);
    }
  }
  public function scopeBusquedaUsuario($query, $name, $correo, $ciudad){
    if(trim($name) != ''){
      return $query->where('name', 'LIKE', "%$name%");
    }elseif(trim($correo) != ''){
      if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
        return $query->where('email', $correo);
      }
    }elseif($ciudad != ''){
      return $query->where('id_ciudad', $ciudad);
    }
  }
}
