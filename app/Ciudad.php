<?php

namespace Tecnovitalmedica;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $table = 'ciudads';
    
    protected $fillable = ['id', 'nombre_ciudad'];
}
