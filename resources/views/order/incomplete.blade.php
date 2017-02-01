@extends('layouts.order')

@section('breadcrumb')
| Order Unsuccesful
@endsection

@section('content')
<h2>Your order was unsuccesful</h2>
<a class="btn btn-link" href="{{ url('cart') }}">Go to cart</a>
<a class="btn btn-link" href="{{ url('products') }}">Continue Shopping</a>
@endsection