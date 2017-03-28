@extends('layouts.base')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="error-page top-bottom-margin-lg">
				<h1>We can't find what you are looking for.</h1>
				<p>Try to search <a href="{{ url('') }}">here</a></p>
			</div>
		</div>
	</div>
</div>
@endsection