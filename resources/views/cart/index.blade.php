@extends('layouts.cart')

@section('breadcrumb')
| Cart
@endsection

@section('content')
<div class="container">
@if (Cart::count() > 0)
	<div class="row">
		<div class="col-md-12">
			<a href="{{ url('products') }}">Continue Shopping</a>
			<a href="{{ url('cart/store') }}" class="pull-right">&nbspCheckout</a>
			<a href="{{ url('cart/empty') }}" class="pull-right">Empty Cart&nbsp&nbsp&nbsp|&nbsp&nbsp</a>
		</div>
	</div>
	<hr>
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
							<td><a href="{{ url('products/'.$row->id) }}">{{ $row->name }} - {{ $row->options['color'] }}</a></td>
							<td class="text-center">
								<a href="{{ url('cart/'.$row->rowId.'/remove') }}">- </a>| {{ $row->qty }} | <a href="{{ url('cart/'.$row->rowId.'/add') }}">+</a></td>
							<td class="text-center">RM{{ $row->total }}</td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
				        <tr class="active">
				            <td class="text-right">Voucher Code&nbsp&nbsp&nbsp<input type="text" name="discount_code"></td>
				            <td class="text-center">Total</td>
				            <td class="text-center">RM<?php echo Cart::total(); ?></td>
				        </tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<hr/>
	<div class="row">
		<div class="col-md-12">
			<a href="{{ url('products') }}">Continue Shopping</a>
			<a href="{{ url('cart/store') }}" class="pull-right">&nbspCheckout</a>
			<a href="{{ url('cart/empty') }}" class="pull-right">Empty Cart&nbsp&nbsp&nbsp|&nbsp&nbsp</a>
		</div>
	</div>
@else
	<div class="row">
		<div class="col-md-12">
			<h2>Your cart is empty</h2> 
			<a href="{{ url('products') }}">Continue shopping</a>
			<br><br><br><br><hr>
		</div>
	</div>
@endif
</div>
@endsection