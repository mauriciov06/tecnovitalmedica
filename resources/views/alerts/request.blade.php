@if(count($errors) > 0)
<div class="alert alert-danger alert-dismissible fade in" role="alert" style="margin: 25px 40px 25px 25px;"> 
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	<span aria-hidden="true">×</span></button> 
	<ul>
		@foreach($errors->all() as $error)
		<li>{!!$error!!}</li>
		@endforeach
	</ul>
</div>
@endif