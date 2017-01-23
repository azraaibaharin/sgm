<form action="https://www.mobile88.com/epayment/entry.asp" method="post">
	<input type="hidden" name="MerchantCode" value="{{ $merchantCode }}" />
	<input type="hidden" name="PaymentId" value="" />
	<input type="hidden" name="RefNo" value="{{ $refNo }}" />
	<input type="hidden" name="Amount" value="{{ $amount }}" />
	<input type="hidden" name="Currency" value="{{ $currency }}" />
	<input type="hidden" name="ProdDesc" value="Baby product" />
	<input type="hidden" name="UserName" value="John Doe" />
	<input type="hidden" name="UserEmail" value="dominoseffect@gmai.com" />
	<input type="hidden" name="UserContact" value="0123456789" />
	<input type="hidden" name="Remark" value="" />
	<input type="hidden" name="Lang" value="UTF-8" />
	<input type="hidden" name="Signature" value="{{ $sha }}" />
	<input type="hidden" name="ResponseURL" value="http://www.supremeglobal.com.my/payment/response" />
	<input type="hidden" name="BackendURL" value="http://www.supremeglobal.com.my/payment/responseBE" />
	<button type="submit">Test</button>
</form>