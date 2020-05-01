{!!Form::text('nombre_usuario',null,['id'=>'nombre_usu', 'class'=>'form-control', 'placeholder'=>"Nombre del usuario"])!!}
{!!Form::text('correo_usuario',null,['id'=>'correo_usu', 'class'=>'form-control', 'placeholder'=>"Correo del usuario"])!!}
{!!Form::select('ciudad_usuario',$ciudades, null, ['id'=>'ciudad_usuario', 'class'=>'form-control', 'placeholder'=>"Seleccionar ciudad"])!!}