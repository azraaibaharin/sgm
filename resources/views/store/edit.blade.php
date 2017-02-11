@extends('layouts.admin')

@section('breadcrumb')
| Edit Store
@endsection

@section('content')
<form class="form-horizontal bottom-margin-sm" role="form" method="POST" action="{{ url('stores/'.session('id').'/edit') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="container">
        <div class="row">
        	<div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit</div>
                    <div class="panel-body">
                        @include('shared.form.textfield', ['name' => 'name', 'text' => 'Name', 'placeholder' => 'Name'])
                        @include('shared.form.textfield', ['name' => 'phone_number', 'text' => 'Phone', 'placeholder' => 'Phone number'])
                        @include('shared.form.checkbox', ['name' => 'brands', 'text' => 'Brands', 'values' => ['nuna', 'babyhood']])
                        <div class="form-group">
                            <div class="col-md-12">
                                <input id="pac-input" class="controls" type="text" placeholder="Search Box">
                                <div id="map"></div>
                            </div>
                        </div>
                        @include('shared.form.textfield', ['name' => 'lat', 'text' => 'Lat', 'placeholder' => 'Latitude'])
                        @include('shared.form.textfield', ['name' => 'lng', 'text' => 'Lng', 'placeholder' => 'Longitude'])
                        @include('shared.form.textfield', ['name' => 'address', 'text' => 'Address', 'placeholder' => 'Address'])
                        @include('shared.form.textfield', ['name' => 'city', 'text' => 'City', 'placeholder' => 'City'])
                        @include('shared.form.textfield', ['name' => 'state', 'text' => 'State', 'placeholder' => 'State'])
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('shared.form.back', ['link' => 'stores/'.session('id')])
                @include('shared.form.submit')
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
<script>
function initMap() {
    var myLatLng = { lat: {{ old('lat') ? old('lat') : session('lat') }}, lng: {{ old('lng') ? old('lng') : session('lng') }} };

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
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
        title: 'Hello World!',
        draggable: true
    });

    marker.addListener('position_changed', function() {
        var lat = marker.getPosition().lat();
        var lng = marker.getPosition().lng();

        $("#lat").val(lat);
        $("#lng").val(lng);
    });

    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
    });

    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            if (!place.geometry) {
                console.log("Returned place contains no geometry");
                return;
            }
            
            marker.setPosition(place.geometry.location);

            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });

}
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ config('gmaps.key') }}&libraries=places&callback=initMap">
</script>
@endsection

