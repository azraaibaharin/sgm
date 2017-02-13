@extends('layouts.article')

@section('breadcrumb')
| Article Details
@endsection

@section('content')
@include('shared.message')
<div id="article" class="container bottom-padding-sm">
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
			@if (!empty($link))<small>From <a href="{{ $link }}" target="_blank">{{ $link }}</a></small>@endif
			<br>
			<small>By {{ $author }}</small>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<a href="{{ url('articles') }}" class="btn btn-link">Back</a>
			@if (!Auth::guest())
				<a href="{{ url('articles/'.$id.'/edit') }}"" class="btn btn-link">Edit</a>
				<form class="form-inline" method="POST" action="{{ url('articles/delete') }}">
					{{ csrf_field() }}
					<input type="hidden" name="article_id" value="{{ $id }}">
					<button type="submit" class="btn btn-link">Remove</button>		
				</form>	
			@endif
		</div>
	</div>
</div>
@endsection