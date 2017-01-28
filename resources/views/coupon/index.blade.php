@extends('layouts.coupon')

@section('breadcrumb')
| Coupons
@endsection

@section('content')
@if (isset($message))
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-info" role="alert">{{ $message }}</div>		
		</div>
	</div>
</div>
@endif

@if ($message = session('message'))
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-info" role="alert">{{ $message }}</div>		
			{{ session()->forget('message') }}
		</div>
	</div>
</div>
@endif

<div id="coupons" class="container">
	<div class="row">
	@if (sizeof($coupons) > 0)
		<div class="col-md-12 bottom-margin-sm">
			<small>{{ count($coupons) }} result(s)</small>
		</div>
		<div class="col-md-12 bottom-margin-sm">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Code</th>
						{{-- <th>Discount</th> --}}
						<th>Value</th>
						<th>Issue Date</th>
						<th>Expiry Date</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				@foreach($coupons as $c)
					<tr>
						<td>{{ $c->code }}</td>
						{{-- <td>{{ $c->discount }}</td> --}}
						<td>{{ $c->value }}</td>
						<td>{{ $c->date_of_issue }}</td>
						<td>{{ $c->date_of_expiration }}</td>
						<td><a href="{{ url('coupons/'.$c->id) }}">Show</a></td>
					</tr>				
				@endforeach
				</tbody>
			</table>
		</div>
	@else
		<div class="col-md-12 text-center">
			<small>No coupons available. Click <a href="{{ url('coupons/create') }}">here</a> to add.</small>
		</div>
	@endif		
	</div>
</div>
@endsection