@extends('layouts.cart')

@section('breadcrumb')
| Cart
@endsection

@section('content')
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

@if ($success = session('success'))
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-success" role="alert">{{ $success }}</div>		
			{{ session()->forget('success') }}
		</div>
	</div>
</div>
@endif

@if ($error = session('error'))
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-danger" role="alert">{{ $error }}</div>		
			{{ session()->forget('error') }}
		</div>
	</div>
</div>
@endif

<div class="container">
@if (Cart::count() > 0)
	<div class="row">
		<div class="col-md-12">
			<a class="btn btn-link" href="{{ url('products') }}">Continue Shopping</a>
			<a class="btn btn-link" href="{{ url('cart/empty') }}">Empty Cart</a>
			<form class="pull-right form-inline" action="{{ url('order/create') }}" method="POST">
				{{ csrf_field() }}
				<input type="hidden" name="coupon_total_value" value="{{ $couponTotalValue }}">
				<input class="btn btn-default" type="submit" value="Checkout">
			</form>
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
				            <td class="text-center" style="vertical-align:middle;">RM{{ Cart::total() }}</td>
				        </tr>
				        @if($couponTotalValue > 0)
							<tr>
								<td>&nbsp</td>
								<td class="text-center">Discounted</td>
								<td class="text-center">-RM{{ $couponTotalValue }}</td>
							</tr>
						@endif
						<tr class="active">
				            <td>&nbsp</td>
				            <td class="text-center" style="vertical-align:middle;">Final Price</td>
				            <td class="text-center" style="vertical-align:middle;">RM{{ Cart::total() - $couponTotalValue > 0 ? Cart::total() - $couponTotalValue : '0.00'}}</td>
				        </tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<hr/>
	<div class="row">
		<div class="col-md-12">
			<a class="btn btn-link" href="{{ url('products') }}">Continue Shopping</a>
			<a class="btn btn-link" href="{{ url('cart/empty') }}">Empty Cart</a>
			<form class="pull-right form-inline" action="{{ url('order/create') }}" method="POST">
				{{ csrf_field() }}
				<input type="hidden" name="coupon_total_value" value="{{ $couponTotalValue }}">
				<input class="btn btn-default" type="submit" value="Checkout">
			</form>
		</div>
	</div>
@else
	<div class="row">
		<div class="col-md-12">
			<h2>Your cart is empty</h2> 
			<a class="btn btn-link" href="{{ url('products') }}">Continue shopping</a>
			<br><br><br><br><hr>
		</div>
	</div>
@endif
</div>
@endsection