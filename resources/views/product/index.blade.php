@extends('layouts.product')

@section('breadcrumb')
| Products
@endsection

@section('content')
<div class="container">
	<div id="products-search" class="row">
		<form class="form-horizontal" role="form" method="POST" action="{{ url('products') }}" enctype="multipart/form-data">
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
			<div class="col-md-6">
				<div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                    <label for="category" class="col-md-2 control-label">Category</label>
                    <div class="col-md-9">
                        <select id="category" class="form-control" name="category">
                        @foreach ($categories as $c)
                            @if ($category == $c)
                                <option value="{{ $c }}" selected>{{ ucfirst($c) }}</option>
                            @else
                                <option value="{{ $c }}">{{ ucfirst($c) }}</option>
                            @endif
                        @endforeach
                        </select>
                        @if ($errors->has('category'))
                            <span class="help-block">
                                <strong>{{ $errors->first('category') }}</strong>
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

@include('shared.message')

<div id="products" class="container">
	<div class="row">
		@if (sizeof($products) > 0)
			<div class="col-md-12 bottom-padding-sm">
				<small>{{ count($products) }} item(s)</small>
			</div>
			@foreach ($products as $p)
			<div class="col-md-4 {{ $p->brand }} bottom-padding-sm">
				<div class="row">
					<div class="col-md-6 img-box text-center">
						@if (empty($p->getDisplay('image_links')))
							<p><small>No image available</small></p>
						@else
							<img src="{{ asset('img/'.$p->getDisplay('image_links')) }}" alt="{{ $p->brand }} {{ $p->brand }}" class="img-responsive">
						@endif
					</div>
					<div class="col-md-6 desc-box">
						<h2>{{ $p->model }}</h2>
						<a href="{{ url('products/'.$p->id) }}">View item</a>
					</div>
				</div>
			</div>
			@endforeach
			<div class="col-md-12 bottom-margin-sm">
				<small>{{ count($products) }} item(s)</small>
				<hr>
			</div>
		@else
			<div class="col-md-12 text-center">
				<small>No products available. Click <a href="{{ url('products/create') }}">here</a> to add.</small>
			</div>
		@endif
	</div>
</div>

<a id="scrollTop" href="#top">Scroll to top</a>
@endsection