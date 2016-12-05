@extends('layouts.testimonial')

@section('content')
<div class="container">
	<div id="testimonials-search" class="row">
		<form class="form-horizontal" role="form" method="POST" action="{{ url('testimonials') }}" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="col-md-4">
				<div class="form-group{{ $errors->has('brand') ? ' has-error' : '' }}">
                    <label for="brand" class="col-md-2 control-label">Brand</label>
                    <div class="col-md-10">
                        <select id="brand" class="form-control" name="brand">
                        @foreach ($brands as $b)
                            @if ($brand == $b)
                                <option value="{{ $b }}" selected>{{ ucfirst($b) }}</option>
                            @else
                                <option value="{{ $b }}">{{ ucfirst($b) }}</option>
                            @endif
                        @endforeach
                        </select>
                        @if ($errors->has('brand'))
                            <span class="help-block">
                                <strong>{{ $errors->first('brand') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
			</div>
			<div class="col-md-2">
				<button type="submit" class="center-block btn btn-default">Search</button>
			</div>
		</form>
	</div>
</div>

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

<div id="testimonials" class="container">
	<div class="row">
	@if (sizeof($testimonials) > 0)
		<div class="col-md-12 bottom-margin-sm">
			<small>{{ count($testimonials) }} result(s)</small>
		</div>
		@foreach($testimonials as $t)
		<div class="col-md-4 article">
			<h2>{{ $t->title }}</h2>
			<small>about {{ ucfirst($t->product->brand) }} {{ $t->product->model }}</small>
			<p>{!! $t->text !!}</p>
			<a href="{{ url('testimonials/'.$t->id) }}">Show</a>
		</div>
		@endforeach
	@else
		<div class="col-md-12 text-center">
			<small>No testimonials available. Click <a href="{{ url('testimonials/create') }}">here</a> to add.</small>
		</div>
	@endif		
	</div>
</div>
@endsection