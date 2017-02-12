@extends('layouts.order')

@section('breadcrumb')
| Complete
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>{{ $message }}</h2>
			<h3>Your order reference number is: {{ $referenceNumber }}</h3>
			<a class="btn btn-link" href="{{ url('products') }}">Return to Products</a>
		</div>
	</div>
</div>
@endsection