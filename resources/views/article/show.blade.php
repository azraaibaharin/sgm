@extends('layouts.product')

@section('content')
<div id="article" class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>{{ $title }}</h1>
			<p>{{ $text }}</p>
			<small>{{ $author }}</small>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<a href="{{ url('articles') }}" class="btn btn-link">Back</a>
			<a href="{{ url('articles/'.$id.'/edit') }}"" class="btn btn-link">Update</a>		
			<a href="{{ url('articles/'.$id.'/delete') }}"" class="btn btn-link">Remove</a>		
		</div>
	</div>
</div>
@endsection