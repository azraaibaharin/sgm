@if ($error = session('error'))
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-danger alert-dismissable fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				  	<span aria-hidden="true">&times;</span>
				</button>
				<p>{{ $error }}</p>
			</div>		
			{{ session()->forget('error') }}
		</div>
	</div>
</div>
@endif