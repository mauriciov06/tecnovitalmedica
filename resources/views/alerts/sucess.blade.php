@if(Session::has('message'))
<div class="alert alert-success alert-dismissible fade in" role="alert" style="margin:25px 40px 25px 25px;"> 
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button> 
	{{Session::get('message')}}
</div>
@endif