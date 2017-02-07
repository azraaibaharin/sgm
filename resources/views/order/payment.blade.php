@extends('layouts.order')

@section('breadcrumb')
| Test Payment
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
								<td class="text-center">{{ $row->qty }}</td>
								<td class="text-center">RM{{ $row->total }}</td>
							</tr>
						@endforeach
					</tbody>
					<tfoot>
				        <tr class="active">
				            <td>&nbsp</td>
				            <td class="text-center" style="vertical-align:middle;">Total</td>
				            <td class="text-center" style="vertical-align:middle;">RM{{ Cart::total() }}</td>
				        </tr>
				        @if($order->coupon_total_value > 0)
							<tr>
								<td>&nbsp</td>
								<td class="text-center">Discounted</td>
								<td class="text-center">-RM{{ $order->coupon_total_value }}</td>
							</tr>
						@endif
						<tr class="active">
				            <td>&nbsp</td>
				            <td class="text-center" style="vertical-align:middle;">Final Price</td>
				            <td class="text-center" style="vertical-align:middle;">RM{{ Cart::total() - $order->coupon_total_value > 0 ? Cart::total() - $order->coupon_total_value : '0.00'}}</td>
				        </tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-hover table-bordered">
					<tr>
						<td class="active">Name</td>
						<td class="text-center">{{ $order->name }}</td>
					</tr>
					<tr>
						<td class="active">Email</td>
						<td class="text-center">{{ $order->email }}</td>
					</tr>
					<tr>
						<td class="active">Phone Number</td>
						<td class="text-center">{{ $order->phone_number }}</td>
					</tr>
					<tr>
						<td class="active">Address</td>
						<td class="text-center">{{ $order->address}}</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
@else
	<div class="row">
		<div class="col-md-12">
			<h2>Your order is empty</h2> 
			<a class="btn btn-link" href="{{ url('products') }}">Continue shopping</a>
			<br><br><br><br><hr>
		</div>
	</div>
@endif
	<hr>
	<div class="row">
		<div class="col-md-12">
			<a class="btn btn-link pull-left" href="{{ url('cart') }}">Cancel</a>
			<form class="form-inline pull-right" action="https://www.mobile88.com/epayment/entry.asp" method="post">
				<input type="hidden" name="MerchantCode" value="{{ $merchantCode }}" />
				<input type="hidden" name="PaymentId" value="{{ $order->id }}" />
				<input type="hidden" name="RefNo" value="{{ $refNo }}" />
				<input type="hidden" name="Amount" value="{{ $amount }}" />
				<input type="hidden" name="Currency" value="{{ $currency }}" />
				<input type="hidden" name="ProdDesc" value="Baby product" />
				<input type="hidden" name="UserName" value="{{ $order->name }}" />
				<input type="hidden" name="UserEmail" value="{{ $order->email }}" />
				<input type="hidden" name="UserContact" value="{{ $order->phone_number }}" />
				<input type="hidden" name="Remark" value="" />
				<input type="hidden" name="Lang" value="UTF-8" />
				<input type="hidden" name="Signature" value="{{ $sha }}" />
				<input type="hidden" name="ResponseURL" value="http://www.supremeglobal.com.my/payment/response" />
				<input type="hidden" name="BackendURL" value="http://www.supremeglobal.com.my/payment/responseBE" />
				<input class="btn btn-default" type="submit" value="Proceed to Payment">
			</form>
		</div>
	</div>
</div>
@endsection