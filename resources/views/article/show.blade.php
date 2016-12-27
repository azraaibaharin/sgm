@extends('layouts.article')

@section('breadcrumb')
| Article Details
@endsection

@section('content')
<div id="article" class="container">
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li><a href="{{ url('articles') }}">Articles</a></li>
				<li class="active">{{ $title }}</li>
			</ol>	
		</div>
	</div>
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
</div>
@endsection