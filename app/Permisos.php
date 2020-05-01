<?php

namespace Tecnovitalmedica;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Permisos extends Model
{
  protected $table = 'permisos';

  protected $fillable = ['nombre_permiso'];

  
}
