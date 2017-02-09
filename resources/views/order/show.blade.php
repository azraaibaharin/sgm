@extends('layouts.order')

@section('breadcrumb')
| Order Details
@endsection

@section('content')
<div class="container bottom-padding-sm">
	<div class="row">
		<div class="col-md-12">
			{{ $shoppingCartId }}	
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<a class="btn btn-link" href="{{ url('order') }}">Back</a>
		</div>
	</div>
</div>
@endsection