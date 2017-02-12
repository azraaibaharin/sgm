@extends('layouts.order')

@section('breadcrumb')
| Complete
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4>{{ $message }}</h4>
			<h5>Your order reference number is: {{ $referenceNumber }}</h5>
			<br>
			<a href="{{ url('products') }}">Return to Products</a>
		</div>
	</div>
</div>
@endsection