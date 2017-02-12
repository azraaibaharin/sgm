<h1>New order received!</h1>
<p>
	<label>Order id:</label> {{ $order->id }}<br>
	<label>Reference no:</label> {{ $order->reference_number }}<br>
	<label>Status:</label> {{ $order->reference_number }}<br>
	<label>Name:</label> {{ $order->name }}<br>
	<label>Email:</label> {{ $order->email }}<br>
	<label>Phone number:</label> {{ $order->phone_number }}<br>
	<label>Address:</label> {{ $order->address }}<br>
</p>
<table class="table table-hover table-bordered">
	<thead>
		<tr class="active">
			<td>Product</td>
			<td class="text-center">Quantity</td>
			<td class="text-center">Price</td>
		</tr>
	</thead>
	<tbody>
		@foreach($content as $row) 
			<tr>
				<td>{{ $row->name }} - {{ $row->options['color'] }}</td>
				<td class="text-center">{{ $row->qty }}</td>
				<td class="text-center">RM{{ $row->total }}</td>
			</tr>
		@endforeach
	</tbody>
	<tfoot>
        <tr class="active">
	        <td> </td>
            <td class="text-center" style="vertical-align:middle;">Total</td>
            <td class="text-center" style="vertical-align:middle;">RM{{ $order->total_price }}</td>
        </tr>
        @if($order->coupon_total_value > 0)
			<tr class="active">
				<td> </td>
				<td class="text-center">Discount</td>
				<td class="text-center">-RM{{ $order->coupon_total_value }}</td>
			</tr>
		@endif
		<tr class="active">
			<td> </td>
			<td class="text-center">Delivery</td>
			<td class="text-center">RM{{ $order->delivery_cost }}</td>
		</tr>
		<tr class="active">
            <td> </td>
            <td class="text-center" style="vertical-align:middle;">Final Price</td>
            <td class="text-center" style="vertical-align:middle;">RM{{ $order->final_price }}</td>
        </tr>
	</tfoot>
</table>