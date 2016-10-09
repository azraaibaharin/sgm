@extends('layouts.product')

@section('content')
<h1>Products</h1>
@foreach ($products as $product)
    <p><a href="{{ url('products/'.$product->id) }}">{{$product->brand }} {{ $product->model }}</a></p>
@endforeach
<a href="{{ url('products/create') }}">Add</a>
@endsection