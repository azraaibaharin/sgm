@extends('layouts.store')

@section('breadcrumb')
| Store Details
@endsection

@section('content')
@include('shared.message')
<div id="store" class="container bottom-margin-sm">
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li><a href="{{ url('stores') }}">Stores</a></li>
				<li class="active">{{ $name }}</li>
			</ol>	
		</div>
	</div>
	<div class="row">
		<div class="col-md-10">
			<div id="map"></div>
		</div>
		<div class="col-md-2">
			<b>Name</b><br/>
			{{ $name }}<br/>
			<br/>
			<b>Phone number</b><br/>
			{{ $phone_number }}<br/>
			<br/>
			<b>Address</b><br/>
			{{ $address }}<br/>
			{{ $city }}<br/>
			{{ $state }}<br/>
			<br/>
			<b>Brands</b><br/>
			@foreach (explode(",", $brands) as $brand)
				{{ ucfirst($brand) }}<br/>
			@endforeach
			<br>
			<small>* Please call store to confirm product availability</small>
		</div>
	</div>
	<hr/>
	<div class="row">
		<div class="col-md-12">
			<a href="{{ url('stores') }}" class="btn btn-link">Back</a>
			@if (!Auth::guest())
				<a href="{{ url('stores/'.$id.'/edit') }}"" class="btn btn-link">Edit</a>		
				<form class="form-inline" method="POST" action="{{ url('stores/delete') }}">
					{{ csrf_field() }}
					<input type="hidden" name="store_id" value="{{ $id }}">
					<button type="submit" class="btn btn-link">Delete</button>
				</form>		
			@endif
		</div>
	</div>
</div>
@endsection

@section('js')
<script>
function initMap() {
	var myLatLng = { lat: {{ $lat }}, lng: {{ $lng }} };

	var map = new google.maps.Map(document.getElementById('map'), {
	  	zoom: 16,
	  	center: myLatLng,
	  	zoomControl: true,
		mapTypeControl: false,
		scaleControl: false,
		streetViewControl: false,
		rotateControl: false,
		fullscreenControl: true
	});

	var marker = new google.maps.Marker({
	  	position: myLatLng,
	  	map: map,
	  	title: 'Hello World!'
	});
}
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ config('gmaps.key') }}&callback=initMap">
</script>
@endsection