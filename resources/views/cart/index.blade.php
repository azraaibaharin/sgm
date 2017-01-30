@extends('layouts.cart')

@section('breadcrumb')
| Cart
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<div class="table-responsive">
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<td>Product</td>
								<td>Quantity</td>
								<td>Price</td>
								<td>Subtotal</td>
							</tr>
						</thead>
						<tbody>
							@if (Cart::count() > 0)
								@foreach(Cart::content() as $row) 
								<tr>
									<td><a href="{{ url('products/'.$row->id) }}">{{ $row->name }} - {{ $row->options['color'] }}</a></td>
									<td class="text-center">
										<a href="{{ url('cart/'.$row->rowId.'/remove') }}">- </a>| {{ $row->qty }} | <a href="{{ url('cart/'.$row->rowId.'/add') }}">+</a></td>
									<td>{{ $row->price }}</td>
									<td>{{ $row->total }}</td>
								</tr>
								@endforeach
							@else 
								<tr>
									<td colspan="4" class="text-center">No items</td>
								</tr>
							@endif
						</tbody>
						<tfoot>
							<tr>
					            <td colspan="2">&nbsp;</td>
					            <td>Subtotal</td>
					            <td><?php echo Cart::subtotal(); ?></td>
					        </tr>
					        <tr>
					            <td colspan="2">&nbsp;</td>
					            <td>Tax</td>
					            <td><?php echo Cart::tax(); ?></td>
					        </tr>
					        <tr>
					            <td colspan="2">&nbsp;</td>
					            <td>Total</td>
					            <td><?php echo Cart::total(); ?></td>
					        </tr>
					        @if (Cart::count() > 0)
						        <tr>
						            <td colspan="2">&nbsp;</td>
						            <td style="vertical-align:middle;">Discount Code</td>
						            <td>
					            		<input type="text" name="discount_code">
						            </td>
						        </tr>
						    @endif
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
	<hr/>
	<div class="row">
		<div class="col-md-12">
			<a href="{{ url('products') }}">Back to products</a>
			@if (Cart::count() > 0)
				<a href="{{ url('cart/store') }}" class="pull-right">&nbspCheckout</a>
				<a href="{{ url('cart/empty') }}" class="pull-right">Empty Cart&nbsp&nbsp&nbsp|&nbsp&nbsp</a>
			@endif
		</div>
	</div>
</div>
@endsection