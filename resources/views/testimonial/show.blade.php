@extends('layouts.product')

@section('content')
<div id="testimonial" class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>{{ $testimonial->title }}</h1>
			<small>about {{ ucfirst($product->brand) }} {{ $product->model }}</small>
			<p>{!! $testimonial->text !!}</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 top-margin-sm">
		<form method="POST" action="{{ url('testimonials/delete') }}">
			{{ csrf_field() }}
			<input type="hidden" name="testimonial_id" value="{{ $testimonial->id }}">
			<a href="{{ url('testimonials') }}" class="btn btn-link">Back</a>
			<a href="{{ url('testimonials/'.$testimonial->id.'/edit') }}"" class="btn btn-link">Edit</a>		
			<button type="submit" class="btn btn-link">Remove</button>		
		</form>	
		</div>
	</div>
</div>
@endsection