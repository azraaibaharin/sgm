@extends('layouts.order')

@section('breadcrumb')
| Order Completed
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>Your order has been sent for processing</h2>
			<a class="btn btn-link" href="{{ url('products') }}">Continue Shopping</a>
		</div>
	</div>
</div>
@endsection