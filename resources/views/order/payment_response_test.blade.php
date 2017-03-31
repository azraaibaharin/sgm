@extends('layouts.order')

@section('breadcrumb')
| Test Payment Response
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>Test Payment Response</h1>
			<form class="form-inline" action="{{ url('payment/response') }}" method="post">
				<input type="hidden" name="Status" value="{{ $status }}" />
				<input type="hidden" name="Signature" value="{{ $signature }}" />
				<input type="hidden" name="MerchantCode" value="{{ $merchantCode }}" />
				<input type="hidden" name="PaymentId" value="{{ $paymentId }}" />
				<input type="hidden" name="RefNo" value="{{ $refNo }}" />
				<input type="hidden" name="Amount" value="{{ $amount }}" />
				<input type="hidden" name="Currency" value="{{ $currency }}" />
				<input class="btn btn-default" type="submit" value="Test Payment Response">
			</form>
		</div>
	</div>
</div>
@endsection