@extends('layouts.testimonial')

@section('breadcrumb')
| Testimonial Details
@endsection

@section('content')
<div id="testimonial" class="container">
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li><a href="{{ url('testimonials') }}">Testimonials</a></li>
				<li class="active">{{ $testimonial->product->brand }} {{ $testimonial->product->model }}</li>
			</ol>	
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h1>{{ $testimonial->title }}</h1>
			<small>about <a href="{{ url('products/'.$testimonial->product->id) }}">{{ ucfirst($testimonial->product->brand) }} {{ $testimonial->product->model }}</a></small>
			<p>{!! $testimonial->text !!}</p>
		</div>
	</div>
	@if (!Auth::guest())
		<hr/>
		<div class="row">
			<div class="col-md-12">
				<a href="{{ url('testimonials') }}" class="btn btn-link">Back</a>
				<a href="{{ url('testimonials/'.$testimonial->id.'/edit') }}"" class="btn btn-link">Edit</a>		
				<form class="form-inline" method="POST" action="{{ url('testimonials/delete') }}">
					{{ csrf_field() }}
					<input type="hidden" name="testimonial_id" value="{{ $testimonial->id }}">
					<button type="submit" class="btn btn-link">Remove</button>		
				</form>	
			</div>
		</div>
	@endif
</div>
@endsection