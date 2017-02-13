@extends('layouts.cart')

@section('breadcrumb')
| Cart
@endsection

@section('content')
@include('shared.message')
@include('shared.success')
@include('shared.error')
<div class="container">
@if (Cart::count() > 0)
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-hover table-bordered">
					<thead>
						<tr class="active">
							<td>Product</td>
							<td class="text-center">Quantity</td>
							<td class="text-center">Price</td>
						</tr>
					</thead>
					<tbody>
						@foreach(Cart::content() as $row) 
							<tr>
								<td>
									<a href="{{ url('products/'.$row->id) }}">{{ $row->name }} - <small>{{ $row->options['color'] }}</small></a>
								</td>
								<td class="text-center">
									<a href="{{ url('cart/'.$row->rowId.'/remove') }}">- </a>| {{ $row->qty }} | <a href="{{ url('cart/'.$row->rowId.'/add') }}">+</a></td>
								<td class="text-center">RM{{ $row->total }}</td>
							</tr>
						@endforeach
					</tbody>
					<tfoot>
				        <tr class="active">
				            <td class="text-right">
								<form class="form-inline" action="{{ url('cart/coupon') }}" method="POST">
									{{ csrf_field() }}
					            	Coupon Code
					            	&nbsp&nbsp&nbsp
					            	<input type="text" name="coupon_code">
					            	&nbsp&nbsp&nbsp
					            	<input class="btn btn-link no-padding" type="submit" value="Apply">
					            	&nbsp&nbsp&nbsp
					            </form>
				            </td>
				            <td class="text-center" style="vertical-align:middle;">Total</td>
				            <td class="text-center" style="vertical-align:middle;">RM{{ Cart::total(2, '.', '') }}</td>
				        </tr>
				        @if(session('coupon_total_value') > 0)
							<tr class="active">
								<td>&nbsp</td>
								<td class="text-center">Discount</td>
								<td class="text-center">-RM{{ session('coupon_total_value') }}</td>
							</tr>
						@endif
						<tr class="active">
							<td>&nbsp</td>
							<td class="text-center">Delivery</td>
							<td class="text-center">RM{{ session('delivery_cost') }}</td>
						</tr>
						<tr class="active">
				            <td>&nbsp</td>
				            <td class="text-center" style="vertical-align:middle;">Final Price</td>
				            <td class="text-center" style="vertical-align:middle;">RM{{ session('final_price') }}</td>
				        </tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<hr/>
	<div class="row">
		<div class="col-md-3">
			<a class="btn btn-link" href="{{ url('products') }}">Continue Shopping</a>
		</div>
		<div class="col-md-3">
			<a class="btn btn-link" href="{{ url('cart/empty') }}">Empty Cart</a>
		</div>
		<div class="col-md-3">
			<a class="btn btn-default pull-right" href="{{ url('order/create') }}">Checkout</a>
		</div>
	</div>
@else
	<div class="row">
		<div class="col-md-12">
			<h2>Your cart is empty</h2><br>
			<a href="{{ url('products') }}">Continue to products</a>
		</div>
	</div>
@endif
</div>
@endsection