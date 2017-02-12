@extends('layouts.order')

@section('breadcrumb')
| Order Details
@endsection

@section('content')
@include('shared.message')
<div id="order" class="container bottom-padding-sm">
	<div class="row">
		<div class="col-md-12">
			<h1>{{ $order->id }}</h1>
			<p><label>Reference no:</label> {{ $order->reference_number }}</p>
			<p><label>Name:</label> {{ $order->name }}</p>
			<p><label>Email:</label> {{ $order->email }}</p>
			<p><label>Phone number:</label> {{ $order->phone_number }}</p>
			<p><label>Status:</label> {{ $order->status }}</p>
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