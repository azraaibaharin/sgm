@extends('layouts.order')

@section('breadcrumb')
| Checkout
@endsection

@section('content')
<form class="form-horizontal bottom-padding-sm" role="form" method="post" action="{{ url('order/store') }}">
	{{ csrf_field() }}
	<div id="checkout" class="container">
		<div class="row">
			<div class="col-md-6">
				<h3>Personal Details</h3>
				@include('shared.form.textfield', ['name' => 'name', 'text' => 'Name', 'placeholder' => 'Bob'])
				@include('shared.form.textfield', ['name' => 'email', 'text' => 'Email', 'placeholder' => 'bob@cool.com'])
				@include('shared.form.textfield', ['name' => 'phone_number', 'text' => 'Phone', 'placeholder' => '1487900'])
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<h3>Delivery Address</h3>
				@include('shared.form.textfield', ['name' => 'number', 'text' => 'Number', 'placeholder' => 'No. 21'])
				@include('shared.form.textfield', ['name' => 'street', 'text' => 'Street', 'placeholder' => 'Jalan 2/1J, Seksyen 8'])
				@include('shared.form.textfield', ['name' => 'city', 'text' => 'City', 'placeholder' => 'Shah Alam'])
				@include('shared.form.textfield', ['name' => 'postcode', 'text' => 'Postcode', 'placeholder' => '40000'])
				@include('shared.form.textfield', ['name' => 'country', 'text' => 'Country', 'placeholder' => 'Country'])
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-12">
				@include('shared.form.back', ['link' => 'cart'])
                @include('shared.form.submit')
			</div>
		</div>
	</div>
</form>
@endsection