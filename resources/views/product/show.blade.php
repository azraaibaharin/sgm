@extends('layouts.product')

@section('css')
    @parent
    <link type="text/css" rel="stylesheet" href="/magiczoomplus/magiczoomplus.css"/>
@endsection

@section('content')
<div id="product" class="container bottom-margin-sm">
	<div class="row">
		<div class="col-md-3">
			<ul class="nav nav-pills nav-stacked">
			 	<li><a href="#product-about">About</a></li>
			 	<li><a href="#product-spec">Specifications</a></li>
			</ul>
		</div>
		<div class="col-md-9">
			<div class="row">
				<div class="col-md-12">
					<ol class="breadcrumb {{ $brand }}">
						<li><a href="{{ url('products') }}">Products</a></li>
						@if (!empty($category))<li>{{ $category }}</li>@endif
						<li class="active">{{ $model }}</li>
					</ol>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
				@if (!empty($displayImage))
					<div class="text-center">
						<a href="{{ asset('img/big_'.$displayImage) }}" class="MagicZoom" id="product-image" data-options="zoomMode: false"><img src="{{ asset('img/small_'.$displayImage) }}"></a>

						<div class="top-margin-sm bottom-margin-xs">
							<!-- Thumbnails -->
							@foreach (explode(',', $image_links) as $image_link)
								@if ($image_link != '')
									<a data-zoom-id="product-image" href="{{ asset('img/big_'.$image_link) }}" data-image="{{ asset('img/small_'.$image_link) }}"><img src="{{ asset('img/tiny_'.$image_link) }}"></a>
								@endif
							@endforeach
						</div>
					</div>
				@else
					<p class="text-center"><a href="{{ url('products/'.$id.'/edit') }}"" class="btn btn-link">Add image</a></p>
				@endif
				</div>
			</div>
			<div id="product-about" class="row">
				<div class="col-md-12">
					<h2>{{ $model }}</h1>
					<p>{!! $description == '' ? 'No description.' : $description !!}</p>
					@if (!empty($displayVideo))
						<br>
						<div class="embed-responsive embed-responsive-16by9">
							{!! $displayVideo !!}
						</div>
						<br>
					@endif
				</div>
			</div>
			<div id="product-spec" class="row">
				<div class="col-md-12"><label>Price:</label> {{ $price == '0.00' ? 'Not set.' : 'RM'.$price }}</div>
				<div class="col-md-12"><label>Color:</label> {{ $color == '' ? 'Not set.' : $color }}</div>
				<div class="col-md-12"><label>Weight:</label> {{ $weight == '' ? 'Not set.' : $weight }}</div>
				<div class="col-md-12"><label>Dimension:</label> {{ $dimension == '' ? 'Not set.' : $dimension }}</div>
				<div class="col-md-12"><label>Weight Capacity:</label> {{ $weight_capacity == '' ? 'Not set.' : $weight_capacity }}</div>
				<div class="col-md-12"><label>Age Requirement:</label> {{ $age_requirement == '' ? 'Not set.' : $age_requirement }}</div>
				<div class="col-md-12"><label>Availability:</label> {{ $status == '' ? 'Not set.' : $status }}</div>
				<div class="col-md-12"><label>Awards:</label> {{ $awards == '' ? 'None.' : $awards }}</div>
				<div class="col-md-12"><label>Manual:</label> @if ($download_links == '') Not set. @else <a href="{{ $download_links }}">Click here to download</a>@endif</div>
			</div>

			<div class="row">
				<div class="col-md-12 top-margin-sm">
					<form method="POST" action="{{ url('products/delete') }}">
						{{ csrf_field() }}
						<input type="hidden" name="product_id" value="{{ $id }}">
						<a href="{{ url('products') }}" class="btn btn-link">Back</a>
						<a href="{{ url('products/'.$id.'/edit') }}"" class="btn btn-link">Edit</a>		
						<button type="submit" class="btn btn-link">Delete</button>
					</form>		
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
    @parent
    <script type="text/javascript" src="/magiczoomplus/magiczoomplus.js"></script>
@endsection