@if ($message = session('message'))
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-info alert-dismissable fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				  	<span aria-hidden="true">&times;</span>
				</button>
				<p>{{ $message }}</p>
			</div>		
			{{ session()->forget('message') }}
		</div>
	</div>
</div>
@endif