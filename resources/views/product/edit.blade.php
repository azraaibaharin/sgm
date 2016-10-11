@extends('layouts.admin')

@section('content')
<form class="form-horizontal" role="form" method="POST" action="{{ url('products/'.$id.'/edit') }}" enctype="multipart/form-data">
{{ csrf_field() }}
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success" role="alert">{{ $message }}</div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">Edit</div>
                    <div class="panel-body">

                    	<div class="form-group{{ $errors->has('brand') ? ' has-error' : '' }}">
                            <label for="brand" class="col-md-2 control-label">Brand</label>
                            <div class="col-md-9">
                                <input id="brand" class="form-control" name="brand" value="{{ old('brand') ? old('brand') : $brand }}" required autofocus />

                                @if ($errors->has('brand'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('brand') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('model') ? ' has-error' : '' }}">
                            <label for="model" class="col-md-2 control-label">Model</label>
                            <div class="col-md-9">
                                <input id="model" class="form-control" name="model" value="{{ old('model') ? old('model') : $model }}" required autofocus />

                                @if ($errors->has('model'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('model') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-2 control-label">Description</label>
                            <div class="col-md-9">
                                <textarea id="description" class="form-control" name="description" rows="5" required autofocus>{{ old('description') ? old('description') : $description }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('color') ? ' has-error' : '' }}">
                            <label for="color" class="col-md-2 control-label">Color</label>
                            <div class="col-md-9">
                                <input id="color" class="form-control" name="color" value="{{ old('color') ? old('color') : $color }}" required autofocus />

                                @if ($errors->has('color'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('color') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('weight') ? ' has-error' : '' }}">
                            <label for="weight" class="col-md-2 control-label">Weight</label>
                            <div class="col-md-9">
                                <input id="weight" class="form-control" name="weight" value="{{ old('weight') ? old('weight') : $weight }}" required autofocus />

                                @if ($errors->has('weight'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('weight') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('dimension') ? ' has-error' : '' }}">
                            <label for="dimension" class="col-md-2 control-label">Dimension</label>
                            <div class="col-md-9">
                                <input id="dimension" class="form-control" name="dimension" value="{{ old('dimension') ? old('dimension') : $dimension }}" required autofocus />

                                @if ($errors->has('dimension'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dimension') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('weight_capacity') ? ' has-error' : '' }}">
                            <label for="weight_capacity" class="col-md-2 control-label">Weight Capacity</label>
                            <div class="col-md-9">
                                <input id="weight_capacity" class="form-control" name="weight_capacity" value="{{ old('weight_capacity') ? old('weight_capacity') : $weight_capacity }}" required autofocus />

                                @if ($errors->has('weight_capacity'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('weight_capacity') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('age_requirement') ? ' has-error' : '' }}">
                            <label for="age_requirement" class="col-md-2 control-label">Age Requirement</label>
                            <div class="col-md-9">
                                <input id="age_requirement" class="form-control" name="age_requirement" value="{{ old('age_requirement') ? old('age_requirement') : $age_requirement }}" required autofocus />

                                @if ($errors->has('age_requirement'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('age_requirement') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('awards') ? ' has-error' : '' }}">
                            <label for="awards" class="col-md-2 control-label">Awards</label>
                            <div class="col-md-9">
                                <input id="awards" class="form-control" name="awards" value="{{ old('awards') ? old('awards') : $awards }}" required autofocus />

                                @if ($errors->has('awards'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('awards') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('video_links') ? ' has-error' : '' }}">
                            <label for="video_links" class="col-md-2 control-label">Video Links</label>
                            <div class="col-md-9">
                                <input id="video_links" class="form-control" name="video_links" value="{{ old('video_links') ? old('video_links') : $video_links }}" required autofocus />

                                @if ($errors->has('video_links'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('video_links') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('download_links') ? ' has-error' : '' }}">
                            <label for="download_links" class="col-md-2 control-label">Download Links</label>
                            <div class="col-md-9">
                                <input id="download_links" class="form-control" name="download_links" value="{{ old('download_links') ? old('download_links') : $download_links }}" required autofocus />

                                @if ($errors->has('download_links'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('download_links') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('image_first') ? ' has-error' : '' }}">
                            <label for="image_first" class="col-md-2 control-label">Image 1</label>

                            <div class="col-md-9">
                                @if ($image_first)
                                    <img src="{{ asset('img/'.$image_first) }}" class="img-thumbnail" alt="">
                                @endif

                                <input id="image_first" type="file" class="form-control" name="image_first" autofocus>
        
                                @if ($errors->has('image_first'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image_first') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('image_second') ? ' has-error' : '' }}">
                            <label for="image_second" class="col-md-2 control-label">Image 2</label>

                            <div class="col-md-9">
                                @if ($image_second)
                                    <img src="{{ asset('img/'.$image_second) }}" class="img-thumbnail" alt="">
                                @endif

                                <input id="image_second" type="file" class="form-control" name="image_second" autofocus>
        
                                @if ($errors->has('image_second'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image_second') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('image_third') ? ' has-error' : '' }}">
                            <label for="image_third" class="col-md-2 control-label">Image 3</label>

                            <div class="col-md-9">
                                @if ($image_third)
                                    <img src="{{ asset('img/'.$image_third) }}" class="img-thumbnail" alt="">
                                @endif

                                <input id="image_third" type="file" class="form-control" name="image_third" autofocus>
        
                                @if ($errors->has('image_third'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image_third') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
            	<a href="{{ url('products/'.$id) }}">Back</a>
                <button type="submit" class="center-block btn btn-default">
                    Submit
                </button>
            </div>
        </div>
    </div>
</form>
@endsection