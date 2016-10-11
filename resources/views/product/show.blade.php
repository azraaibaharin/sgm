@extends('layouts.product')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<ul class="nav nav-pills nav-stacked">
			 	<li>About</li>
			 	<li>Specifications</li>
			 	<li>Awards</li>
			</ul>
		</div>
		<div class="col-md-9">
			@foreach ($images as $image)
				@if (!empty($image))
					<img src="{{ asset('img/'.$image) }}" alt="{{ $model }}"" class="img-responsive">
				@endif
			@endforeach
			<h1>{{ $brand }} {{ $model }}</h1>
			<p>{{ $description }}</p>
			<br><label>Category:</label> {{ $category_id }}
			<br><label>Videos:</label> {{ $video_links }}
			<br><label>Color:</label> {{ $color }}
			<br><label>Downloads:</label> {{ $download_links }}
			<h2>Specifications</h2>
			<br><label>Weight:</label> {{ $weight }}
			<br><label>Dimension:</label> {{ $dimension }}
			<br><label>Weight capacity</label> {{ $weight_capacity }}
			<br><label>Age equirement:</label> {{ $age_requirement }}
			<h2>Awards</h2>
			<p>{{ $awards }}</p>
			<p>
				<a href="{{ url('products/'.$id.'/edit') }}"" class="btn btn-primary">Edit</a>		
				<a href="{{ url('products') }}" class="btn btn-link">Back</a>
			</p>
		</div>
	</div>
</div>
@endsection