@extends('layouts.product')

@section('content')
<div id="article" class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>{{ $title }}</h1>
			@if ($image_link)
				<img src="{{ asset('img/'.$image_link) }}" alt="">
			@endif
			<p>{!! $text !!}</p>
			<small>By {{ $author }}</small>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 top-margin-sm">
			<a href="{{ url('articles') }}" class="btn btn-link">Back</a>
		</div>
	</div>
</div>
@endsection