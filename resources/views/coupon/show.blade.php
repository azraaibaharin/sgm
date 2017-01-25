@extends('layouts.coupon')

@section('breadcrumb')
| Coupon Details
@endsection

@section('content')
<div id="warranty" class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>{{ $code }}</h1>
			{{-- <p><label>Discount:</label> {{ $discount }}</p> --}}
			<p><label>Value:</label> {{ $value }}</p>
			<p><label>Date of Issue:</label> {{ $date_of_issue }}</p>
			<p><label>Date of Expiry:</label> {{ $date_of_expiration }}</p>
		</div>
	</div>
	<hr/>
	<div class="row">
		<div class="col-md-12 top-bottom-margin-sm">
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