<?php

namespace Tecnovitalmedica;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class File_manager extends Model
{
    protected $table = 'file_managers';

    protected $fillable = ['id_instituciones', 'id_equipo_medico', 'tipo_archivo' ,'nombre_archivo', 'url_archivo'];

    public function setUrlArchivoAttribute($avatar){
	    if(!empty($avatar)){
	      $name = $this->attributes['nombre_archivo'].'.pdf';
	      $this->attributes['url_archivo'] = $name;
	      \Storage::disk('local')->put($name, \File::get($avatar));
	    }
	}
}
