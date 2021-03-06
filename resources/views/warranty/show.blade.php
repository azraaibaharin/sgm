@extends('layouts.warranty')

@section('breadcrumb')
| Warranty Details
@endsection

@section('content')
@include('shared.message')
<div id="warranty" class="container bottom-padding-sm">
	<div class="row">
		<div class="col-md-12">
			<h1>{{ $full_name }}</h1>
			<p><label>Email:</label> {{ $email }}</p>
			<p><label>Phone:</label> {{ $phone_number }}</p>
			<p><label>Address:</label> {{ $address }}</p>
			<p><label>Model name:</label> {{ $product_model_name }}</p>
			<p><label>Model number:</label> {{ $product_model_number }}</p>
			<p><label>Serial no.:</label> {{ $product_serial_number }}</p>
			<p><label>Purchase date:</label> {{ $date_of_purchase }}</p>
			<p><label>Submitted date:</label> {{ date('Y-m-d', strtotime($created_at)) }}</p>
		</div>
	</div>
	<hr/>
	<div class="row">
		<div class="col-md-12">
			@if (!Auth::guest())
				<form method="POST" action="{{ url('warranties/delete') }}">
					{{ csrf_field() }}
					<input type="hidden" name="warranty_id" value="{{ $id }}">
					<a href="{{ url('warranties') }}" class="btn btn-link">Back</a>
					<a href="{{ url('warranties/'.$id.'/edit') }}"" class="btn btn-link">Edit</a>		
					<button type="submit" class="btn btn-link">Delete</button>
				</form>	
			@else
				<a href="{{ url('home') }}" class="btn btn-link">Back</a>
			@endif
		</div>	
	</div>
</div>
@endsection