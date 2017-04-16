@extends('layouts.coupon')

@section('breadcrumb')
| Coupons
@endsection

@section('content')
@include('shared.message')
<div id="coupons" class="container">
	<div class="row">
		@if (sizeof($coupons) > 0)
			<div class="col-md-12 bottom-padding-sm">
				<small>{{ count($coupons) }} result(s)</small>
			</div>
			<div class="col-md-12 bottom-padding-sm">
				<div class="table-responsive">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Code</th>
								<th>Percentage (%)</th>
								<th>Value (MYR)</th>
								<th>Applied Products</th>
								<th>Issue Date</th>
								<th>Expiry Date</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						@foreach($coupons as $c)
							<tr>
								<td>{{ $c->code }}</td>
								<td>{{ $c->percentage == '' ? 0 : $c->percentage }}</td>
								<td>{{ $c->value == '' ? 0 : $c->value }}</td>
								@if ($c->selected_product_ids != '')
									<td>{{ count(explode(",", $c->selected_product_ids)) }}</td>
								@else 
									<td>0</td>
								@endif
								<td>{{ $c->date_of_issue }}</td>
								<td>{{ $c->date_of_expiration }}</td>
								<td><a href="{{ url('coupons/'.$c->id) }}">Show</a></td>
							</tr>				
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		@else
			<div class="col-md-12 text-center">
				<small>No coupons available. Click <a href="{{ url('coupons/create') }}">here</a> to add.</small>
			</div>
		@endif		
	</div>
</div>
<a id="scrollTop" href="#top">Scroll to top</a>
@endsection