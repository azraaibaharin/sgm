@extends('layouts.coupon')

@section('breadcrumb')
| Coupon Details
@endsection

@section('content')
@include('shared.message')
<div id="warranty" class="container bottom-padding-sm">
	<div class="row">
		<div class="col-md-12">
			<p><label>Code:</label> {{ $code }}</p>
			<p><label>Percentage:</label> {{ $percentage == '' ? 0 : $percentage }}%</p>
			<p><label>Value:</label> MYR {{ $value == '' ? 0 : $value }}</p>
			<p>
				<label>Products applied ({{ count($products) }}):</label>
				@if (count($products) < 1)
					None
				@endif
				@foreach ($products as $product)
					<br>{{ ucfirst($product->brand) }} {{ $product->model }}
				@endforeach
			 </p>
			<p><label>Date of Issue:</label> {{ $date_of_issue }}</p>
			<p><label>Date of Expiry:</label> {{ $date_of_expiration }}</p>
		</div>
	</div>
	<hr/>
	<div class="row">
		<div class="col-md-12">
			@if (!Auth::guest())
				<a href="{{ url('coupons') }}" class="btn btn-link">Back</a>
				<a href="{{ url('coupons/'.$id.'/edit') }}"" class="btn btn-link">Edit</a>		
				<form class="form-inline" method="POST" action="{{ url('coupons/'.$id) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit" class="btn btn-link">Delete</button>
				</form>	
			@else
				<a href="{{ url('home') }}" class="btn btn-link">Back</a>
			@endif
		</div>	
	</div>
</div>
@endsection