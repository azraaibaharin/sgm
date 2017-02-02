@extends('layouts.article')

@section('breadcrumb')
| Articles
@endsection

@section('content')
@include('shared.message')
<div id="articles" class="container">
	<div class="row">
	@if (sizeof($articles) > 0)
		<div class="col-md-12 bottom-margin-sm">
			<small>{{ count($articles) }} result(s)</small>
		</div>
		@foreach($articles as $a)
		<div class="col-md-6 article">
			<h2>{{ $a->title }}</h2>
			<p>{!! $a->text !!}</p>
			<small>By {{ $a->author }}</small>
			<hr/>
			<a class="btn btn-link" href="{{ url('articles/'.$a->id) }}">Read</a>
		</div>
		@endforeach
	@else
		<div class="col-md-12">
			<p class="text-center top-margin-md">
				<small>No articles available. @if (!Auth::guest()) Click <a href="{{ url('articles/create') }}">here</a> to add.@endif</small>
			</p>
		</div>
	@endif		
	</div>
</div>
@endsection