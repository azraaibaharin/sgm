@extends('layouts.order')

@section('breadcrumb')
| Checkout
@endsection

@section('content')
<div id="checkout" class="container">
	<form class="form-horizontal" role="form" method="POST" action="{{ url('order/store') }}">
		{{ csrf_field() }}
		<div class="row">
			<div class="col-md-offset-3 col-md-6">
				<h3>Personal Details</h3>
				<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
					<input class="form-control" type="text" name="name" placeholder="Name" required>
				</div>
				<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
					<input class="form-control" type="text" name="email" placeholder="Email" required>
				</div>
				<div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
					<input class="form-control" type="text" name="phone_number" placeholder="Phone Number">
				</div>
				<hr>
				<h3>Delivery Address</h3>
				<div class="form-group{{ $errors->has('property_no') ? ' has-error' : '' }}">
					<input class="form-control" type="text" name="property_no" placeholder="Property No" required>
				</div>
				<div class="form-group{{ $errors->has('street_address') ? ' has-error' : '' }}">
					<input class="form-control" type="text" name="street_address" placeholder="Street" required>
				</div>
				<div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
					<input class="form-control" type="text" name="city" placeholder="Town/City" required>
				</div>
				<div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
					<input class="form-control" type="text" name="country" placeholder="Country" required>
				</div>
				<div class="form-group{{ $errors->has('postcode') ? ' has-error' : '' }}">
					<input class="form-control" type="text" name="postcode" placeholder="Zip/Postcode" required>
				</div>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-12">
				<a class="pull-left btn btn-link" href="{{ url('cart') }}">Go back</a>		
				<input class="pull-right btn btn-default" type="submit" value="Proceed to Review Order">
			</div>
		</div>
	</form>
</div>
@endsection