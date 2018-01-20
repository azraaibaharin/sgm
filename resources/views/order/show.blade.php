@extends('layouts.order')

@section('breadcrumb')
| Order Details
@endsection

@section('content')
@include('shared.message')
<div id="order" class="container bottom-padding-sm">
	<div class="row">
		<div class="col-md-12">
			<p><label>Reference no:</label> {{ $order->reference_number }}</p>
			<p><label>Name:</label> {{ $order->name }}</p>
			<p><label>Email:</label> {{ $order->email }}</p>
			<p><label>Phone number:</label> {{ $order->phone_number }}</p>
			<p><label>Status:</label> {{ ucfirst($order->status) }}</p>			
			<table class="table table-hover table-bordered">
				<thead>
					<tr class="active">
						<td>Product</td>
						<td class="text-center">Quantity</td>
						<td class="text-center">Price</td>
					</tr>
				</thead>
				@if ( $contents != '')
					<tbody>
						@foreach($contents as $row) 
							<tr>
								<td>{{ $row->name }} - {{ $row->options['color'] }}</td>
								<td class="text-center">{{ $row->qty }}</td>
								<td class="text-center">RM{{ $row->total }}</td>
							</tr>
						@endforeach
					</tbody>
					<tfoot>
				        <tr class="active">
					        <td> </td>
				            <td class="text-center" style="vertical-align:middle;">Total</td>
				            <td class="text-center" style="vertical-align:middle;">RM{{ $order->total_price }}</td>
				        </tr>
				        @if($order->coupon_total_value > 0)
							<tr class="active">
								<td> </td>
								<td class="text-center">Discount</td>
								<td class="text-center">-RM{{ $order->coupon_total_value }}</td>
							</tr>
						@endif
						<tr class="active">
							<td> </td>
							<td class="text-center">Delivery</td>
							<td class="text-center">RM{{ $order->delivery_cost }}</td>
						</tr>
						<tr class="active">
				            <td> </td>
				            <td class="text-center" style="vertical-align:middle;">Final Price</td>
				            <td class="text-center" style="vertical-align:middle;">RM{{ $order->final_price }}</td>
				        </tr>
					</tfoot>
				@else
					<tbody>
						<tr>
							<td colspan="3">No order details available</td>
						</tr>
					</tbody>
					<tfoot>
				        <tr class="active">
					        <td colspan="3">&nbsp</td>
				        </tr>
					</tfoot>
				@endif
			</table>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<a class="btn btn-link" href="{{ url('order') }}">Back</a>
			@if (!Auth::guest())
				<a href="{{ url('order/'.$order->id.'/edit') }}"" class="btn btn-link">Edit</a>
				<form class="form-inline" method="POST" action="{{ url('order/'.$order->id) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<input type="hidden" name="order_id" value="{{ $order->id }}">
					<button type="submit" class="btn btn-link">Remove</button>		
				</form>	
			@endif
		</div>
	</div>
</div>
@endsection