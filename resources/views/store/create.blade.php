@extends('layouts.admin')

@section('breadcrumb')
| Add Store
@endsection

@section('content')
<form class="form-horizontal" role="form" method="POST" action="{{ url('stores/create') }}" enctype="multipart/form-data">
{{ csrf_field() }}
    <div class="container">
        <div class="row">
        	<div class="col-md-8 col-md-offset-2">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success" role="alert">{{ $message }}</div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">Create</div>
                    <div class="panel-body">

                    	<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-2 control-label">Name</label>
                            <div class="col-md-9">
                                <input id="name" class="form-control" name="name" value="{{ old('name') }}" required />

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                            <label for="phone_number" class="col-md-2 control-label">Phone</label>
                            <div class="col-md-9">
                                <input id="phone_number" class="form-control" name="phone_number" value="{{ old('phone_number') }}" required />

                                @if ($errors->has('phone_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Brands</label>
                            <div class="col-md-9">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="brands[]" value="babyhood" {{ array_has(old('brands'), 'babyhood') ? 'checked' : '' }}> Babyhood
                                    </label>
                                    <label>
                                        <input type="checkbox" name="brands[]" value="nuna" {{ array_has(old('brands'), 'nuna') ? 'checked' : '' }}> Nuna
                                    </label>
                                  </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <input id="pac-input" class="controls" type="text" placeholder="Search Box">
                                <div id="map"></div>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('lat') ? ' has-error' : '' }}">
                            <label for="lat" class="col-md-2 control-label">Lat</label>
                            <div class="col-md-9">
                                <input id="lat" class="form-control" name="lat" value="{{ old('lat') }}" />

                                @if ($errors->has('lat'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lat') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('lng') ? ' has-error' : '' }}">
                            <label for="lng" class="col-md-2 control-label">Lng</label>
                            <div class="col-md-9">
                                <input id="lng" class="form-control" name="lng" value="{{ old('lng') }}" />

                                @if ($errors->has('lng'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lng') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="address" class="col-md-2 control-label">Address</label>
                            <div class="col-md-9">
                                <input id="address" class="form-control" name="address" value="{{ old('address') }}" required/>

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            <label for="city" class="col-md-2 control-label">City</label>
                            <div class="col-md-9">
                                <input id="city" class="form-control" name="city" value="{{ old('city') }}" required/>

                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                            <label for="state" class="col-md-2 control-label">State</label>
                            <div class="col-md-9">
                                <select id="state" class="form-control" name="state">
                                @foreach ($states as $s)
                                    @if (old('state') == $s)
                                        <option value="{{ $s }}" selected>{{ $s }}</option>
                                    @else
                                        <option value="{{ $s }}">{{ $s }}</option>
                                    @endif
                                @endforeach
                                </select>

                                @if ($errors->has('state'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <a href="{{ url('stores') }}" class="btn btn-link pull-left">Back</a>
                    <button type="submit" class="btn btn-default pull-right">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
<script>
function initMap() {
    var myLatLng = {lat: 3.026669, lng: 101.692159};

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

            // var icon = {
            //     url: place.icon,
            //     size: new google.maps.Size(71, 71),
            //     origin: new google.maps.Point(0, 0),
            //     anchor: new google.maps.Point(17, 34),
            //     scaledSize: new google.maps.Size(25, 25)
            // };

            // Create a marker for each place.
            // markers.push(new google.maps.Marker({
            //     map: map,
            //     // icon: icon,
            //     // title: place.name,
            //     position: place.geometry.location,
            //     draggable: true
            // }));
            
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

