@extends('layouts.product')

@section('breadcrumb')
| Product Details
@endsection

@section('css')
    @parent
    <link type="text/css" rel="stylesheet" href="/magiczoomplus/magiczoomplus.css"/>
@endsection

@section('content')
@include('shared.message')
<div id="product" class="container bottom-padding-sm">
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
						@if (!empty($brand))<li><a href="{{ url('products/b/'.$brand) }}">{{ ucfirst($brand) }}</a></li>@endif
						@if (!empty($category))<li><a href="{{ url('products/b/'.$brand.'/c/'.$category) }}">{{ ucfirst($category) }}</a></li>@endif
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
					@if (!Auth::guest())
						<p class="text-center bg-no-img"><a href="{{ url('products/'.$id.'/edit') }}"" class="btn btn-link">Add image</a></p>
					@else
						<p class="text-center bg-no-img">No image available</p>
					@endif
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
			<hr/>
			<div id="product-spec" class="row">
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-12"><label>Weight:</label> {{ $weight == '' ? 'Not set' : $weight.'kg' }}</div>
						<div class="col-md-12"><label>Dimension:</label> {{ $dimension == '' ? 'Not set' : $dimension }}</div>
						<div class="col-md-12"><label>Weight Capacity:</label> {{ $weight_capacity == '' ? 'Not set' : $weight_capacity.'kg' }}</div>
						<div class="col-md-12"><label>Age Requirement:</label> {{ $age_requirement == '' ? 'Not set' : $age_requirement }}</div>
						@if ($awards != '')  <div class="col-md-12"><label>Awards:</label> {{ $awards }}</div>@endif
						{{-- <div class="col-md-12"><label>Manual:</label> @if ($download_links == '') Not set @else <a href="{{ $download_links }}">Click here to download</a>@endif</div> --}}
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-12">
							<p style="font-size: 24px;">{{ $price == '' || $status == 'Out of Stock' ? 'Out of Stock' : 'RM'.$price }}</p>
							@if ($price != '' && $status != 'Out of Stock') {{-- Only show 'Add to cart' if price is set --}}
								<label>Select color</label>
								<form action="{{ url('cart') }}" method="POST">
								  	{!! csrf_field() !!}
								  	<input type="hidden" name="id" value="{{ $id }}">
								  	<input type="hidden" name="name" value="{{ ucfirst($brand) }} {{ ucfirst($model) }}">
								  	<input type="hidden" name="price" value="{{ $price }}">
								  	<input type="hidden" name="delivery_weight" value="{{ $delivery_weight }}">
								  	<select id="color_select" name="color" onchange="">
								  		{{-- <option value="nocolor">Select preferred color</option> --}}
								  		@foreach($colorsWithSku as $c)
											<option value="{{ trim($c) }}">{{ trim(preg_replace("#\(.*\)#", "", $c)) }}</option>
								  		@endforeach
								  	</select>
								  	<br><br>
								  	<input id="add_to_cart_button" type="submit" class="btn btn-default" value="Add to Cart">
								  	<small id="color_oos_label">* This color is out of stock</small>
								</form>
							@endif
						</div>
					</div>
				</div>
			</div>
			<hr/>
			@include('product.suggestions', ['suggestions' => $suggestions])
			<div class="row">	
				<div class="col-md-12">
					<a href="{{ url('products') }}"" class="btn btn-link">Back</a>
					@if (!Auth::guest())
						<a href="{{ url('products/'.$id.'/edit') }}"" class="btn btn-link">Edit</a>		
						<form class="form-inline" method="POST" action="{{ url('products/delete') }}">
							{{ csrf_field() }}
							<input type="hidden" name="product_id" value="{{ $id }}">
							<button type="submit" class="btn btn-link">Delete</button>
						</form>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('/magiczoomplus/magiczoomplus.js') }}"></script>
    <script type="text/javascript">
    	window.onload = function() {
    		var colorSelect = document.getElementById('color_select');
    		var colorOosLabel = document.getElementById('color_oos_label');
    		var cartBtn = document.getElementById('add_to_cart_button');

    		var colorSelected = colorSelect.value;
			// console.log('Initial selected color: ' + colorSelected);
    		var isColorOutOfStock = colorSelected.toLowerCase().includes('out of stock');
			colorOosLabel.style.display = isColorOutOfStock ? 'block' : 'none';
    		cartBtn.disabled = isColorOutOfStock;

    		colorSelect.onchange = function() {
    			colorSelected = colorSelect.value;
    			// console.log('Selected color: ' + colorSelected);
    			isColorOutOfStock = colorSelected.toLowerCase().includes('out of stock');
    			cartBtn.disabled = isColorOutOfStock;
    			colorOosLabel.style.display = isColorOutOfStock ? 'block' : 'none';
    		}

    		var checkColorStock = function() {

    		}
    	}
    </script>
@endsection