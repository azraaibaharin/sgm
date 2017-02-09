@if ($success = session('success'))
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-success alert-dismissable fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				  	<span aria-hidden="true">&times;</span>
				</button>
				<p>{{ $success }}</p>
			</div>		
			{{ session()->forget('success') }}
		</div>
	</div>
</div>
@endif