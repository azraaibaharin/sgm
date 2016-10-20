@extends('layouts.article')

@section('content')
<div id="articles" class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>Articles</h1>
		</div>
	</div>
	<div class="row">
	@if (sizeof($articles) > 0)
		@foreach($articles as $a)
		<div class="col-md-6">
			<a href="{{ !empty($a->link) ? $a->link : url('articles/'.$a->id) }}">
				<h2>{{ $a->title }}</h2>
				<p>{{ $a->text }}</p>
				<br><small>{{ $a->author }}</small>
			</a>
			<br><br><a href="{{ url('articles/'.$a->id) }}">Show</a>
		</div>
		@endforeach
	@else
		<div class="col-md-12">
			<small class="text-center">No articles available. Add article <a href="{{ url('articles/create') }}">here</a>.</small>
		</div>
	@endif		
	</div>
</div>
@endsection