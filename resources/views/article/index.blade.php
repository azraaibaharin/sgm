@extends('layouts.article')

@section('content')
@if ($message = session('message'))
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-info" role="alert">{{ $message }}</div>		
			{{ session()->flush() }}
		</div>
	</div>
</div>
@endif
<div id="articles" class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>Articles</h1>
		</div>
	</div>
	<div class="row">
	@if (sizeof($articles) > 0)
		@foreach($articles as $a)
		<div class="col-md-6 article">
			<a href="{{ !empty($a->link) ? $a->link : url('articles/'.$a->id) }}" target="_blank">
				<h2>{{ $a->title }}</h2>
				<p>{!! $a->text !!}</p>
				<small>By {{ $a->author }}</small>
			</a>
			<form method="POST" action="{{ url('articles/delete') }}">
				{{ csrf_field() }}
				<input type="hidden" name="article_id" value="{{ $a->id }}">
				<a href="{{ url('articles/'.$a->id.'/edit') }}"" class="btn btn-link">Edit</a>		
				<button type="submit" class="btn btn-link">Remove</button>		
			</form>	
		</div>
		@endforeach
	@else
		<div class="col-md-12">
			<small class="text-center">No articles available. Click <a href="{{ url('articles/create') }}">here</a> to add.</small>
		</div>
	@endif		
	</div>
</div>
@endsection