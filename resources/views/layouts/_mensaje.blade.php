
@if (Session::has('info'))
	<div class="alert alert-success alert-dismissable alert-style-1">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<i class="zmdi zmdi-check"></i>{{ session::get('info') }} 
	</div>
	<br>
@endif

@if(count($errors))

	<div class="alert alert-danger alert-dismissable alert-style-1">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<ul>
				@foreach($errors->all() as $error)
					<li><i class="zmdi zmdi-block"></i>{{ $error }}</li>
				@endforeach 
			</ul>
	</div>
	<br>

@endif