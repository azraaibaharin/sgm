@extends('layouts.testimonial')

@section('breadcrumb')
| Testimonials
@endsection

@section('content')
<div class="container">
	<div id="testimonials-search" class="row">
		@include('shared.search', ['link' => 'testimonials', 'name' => 'brand', 'text' => 'Brand', 'options' => $brands])
	</div>
</div>

@include('shared.message')

<div id="testimonials" class="container">
	<div class="row">
		@if (sizeof($testimonials) > 0)
			<div class="col-md-12 bottom-margin-sm">
				<small>{{ count($testimonials) }} result(s)</small>
			</div>
			@foreach($testimonials as $t)
			<div class="col-md-4 {{ $t->brand }}">
				<h2>{{ $t->title }}</h2>
				<small>about {{ ucfirst($t->brand) }} {{ $t->model }}</small>
				<p>{!! $t->text !!}</p>
				<a href="{{ url('testimonials/'.$t->id) }}">Read</a>
			</div>
			@endforeach
		@else
			<div class="col-md-12 text-center">
				<small>No testimonials available. @if (!Auth::guest()) Click <a href="{{ url('testimonials/create') }}">here</a> to add.@endif</small>
			</div>
		@endif		
	</div>
</div>
<a id="scrollTop" href="#top">Scroll to top</a>
@endsection