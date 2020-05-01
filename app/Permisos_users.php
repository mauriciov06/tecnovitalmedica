<?php

namespace Tecnovitalmedica;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Permisos_users extends Model
{
  protected $table = 'permisos_usuarios';

  protected $fillable = ['id_users', 'ids_permisos'];

  
}
