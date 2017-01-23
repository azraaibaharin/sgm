@extends('layouts.product')

@section('breadcrumb')
| Cart
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<td>Product</td>
							<td>Quantity</td>
							<td>Price</td>
							<td>Subtotal</td>
						</tr>
					</thead>
					<tbody>
						@foreach(Cart::content() as $row)
						<tr>
							<td><a href="{{ url('products/'.$row->id) }}">{{ $row->name }}</a></td>
							<td class="text-center">
								<a href="{{ url('cart/'.$row->rowId.'/remove') }}">- </a>| {{ $row->qty }} | <a href="{{ url('cart/'.$row->rowId.'/add') }}">+</a></td>
							<td>{{ $row->price }}</td>
							<td>{{ $row->total }}</td>
							{{-- <td>
								<form action="{{ url('cart/'.$row->rowId) }}" method="POST">
								  	{!! csrf_field() !!}
								  	<input type="hidden" name="_method" value="DELETE">
								  	<input type="submit" class="pull-left btn btn-link" value="R">
								</form>
							</td> --}}
						</tr>
						@endforeach
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
					</tfoot>
				</table>
				<a href="{{ url('products') }}">Continue shopping</a>
				<a href="{{ url('cart/store') }}" class="pull-right">&nbspCheckout</a>
				<a href="{{ url('cart/empty') }}" class="pull-right">Empty Cart&nbsp&nbsp&nbsp|&nbsp&nbsp</a>
			</div>
		</div>
	</div>
</div>
@endsection