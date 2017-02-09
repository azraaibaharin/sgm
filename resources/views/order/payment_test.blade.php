@extends('layouts.order')

@section('breadcrumb')
| Test Payment
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>Test Payment</h1>
			<p>Response URL: {{ url('payment/response') }}</p>
			<p>Response Back End URL: {{ url('payment/responseBE') }}</p>
			<form class="form-inline" action="https://www.mobile88.com/epayment/entry.asp" method="post">
				{{ csrf_field() }}
				<input type="hidden" name="MerchantCode" value="{{ $merchantCode }}" />
				<input type="hidden" name="PaymentId" value="" />
				<input type="hidden" name="RefNo" value="{{ $refNo }}" />
				<input type="hidden" name="Amount" value="{{ $amount }}" />
				<input type="hidden" name="Currency" value="{{ $currency }}" />
				<input type="hidden" name="ProdDesc" value="Baby product" />
				<input type="hidden" name="UserName" value="test" />
				<input type="hidden" name="UserEmail" value="test@email.com" />
				<input type="hidden" name="UserContact" value="0123456789" />
				<input type="hidden" name="Remark" value="None" />
				<input type="hidden" name="Lang" value="UTF-8" />
				<input type="hidden" name="Signature" value="{{ $sha }}" />
				<input type="hidden" name="ResponseURL" value="{{ url('payment/response') }}" />
				<input type="hidden" name="BackendURL" value="{{ url('payment/responseBE') }}" />
				<input class="btn btn-default" type="submit" value="Test Payment">
			</form>
			{{-- <a class="btn btn-link" href="{{ url('cart') }}">Cancel</a> --}}
		</div>
	</div>
</div>
@endsection