@extends('layouts.admin')

@section('content')
	<div class="content-section-modulo">
		<div class="sub-nav-item">
			<h4 class="pull-left">Agregar Instituciones</h4>
			@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 6))
			    <a href="/instituciones" class="btn-listar">Listar institución</a>
			@endif
		</div>
		<div id="conten-form">	
			{!!Form::open(['route'=>'instituciones.store', 'method'=>'POST', 'files'=>true])!!}
				<div class="row">
					@include('instituciones.forms.inst')
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						{!!Form::submit('Agregar Institución',['class'=>'btn btn-accion'])!!}
					</div>
				</div>
			{!!Form::close()!!}
		</div>
	</div>
@stop

@section('scripts')
	{!!Html::script('js/custom-file-input.js')!!}
@endsection