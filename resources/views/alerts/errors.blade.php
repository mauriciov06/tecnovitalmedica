@if(Session::has('message-error'))
<div class="alert alert-danger alert-dismissible fade in" role="alert" style="margin:25px 40px 25px 25px;"> 
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button> 
	{{Session::get('message-error')}}
</div>
@endif