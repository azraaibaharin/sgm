@if (count($suggestions) > 0)
	<div id="product-suggestions" class="row">
		<div class="col-md-12">
			<h4>You might also like</h4>
		</div>
		@foreach ($suggestions as $suggestion)
			<div class="col-md-4 text-center">
				@if (empty($suggestion->getDisplay('image_links')))
					<p class="text-center bg-no-img">No image available</p>
				@else
					<img src="{{ asset('img/small_'.$suggestion->getDisplay('image_links')) }}">
				@endif
				<p><a href="{{ url('products/'.$suggestion->id) }}">{{ ucwords($suggestion->brand) }} {{ $suggestion->model }}</a></p>
			</div>
		@endforeach
	</div>
	<hr>
@endif