{!!Form::text('nombre_equipo',null,['id'=>'nombre_equ', 'class'=>'form-control', 'placeholder'=>"Nombre del equipo"])!!}
{!!Form::text('ubicacion_equipo',null,['id'=>'modelo_equ', 'class'=>'form-control', 'placeholder'=>"Ubicación"])!!}
{!!Form::text('serie_equipo',null,['id'=>'serie_equ', 'class'=>'form-control', 'placeholder'=>"Serie"])!!}
@if(Auth::user()->tipo_cuenta == 1)
    {!!Form::select('institucion',$instituciones, null, ['id'=>'instituciones-list', 'class'=>'form-control', 'placeholder'=>"Seleccionar Insitución"])!!}
@endif

