@extends('layouts.admin')

@section('breadcrumb')
| Edit Product
@endsection

@section('content')
<form class="form-horizontal bottom-margin-sm" role="form" method="POST" action="{{ url('products/'.$id.'/edit') }}" enctype="multipart/form-data">
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

                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price" class="col-md-2 control-label">Price</label>
                            <div class="col-md-9">
                                <input id="price" class="form-control" name="price" value="{{ old('price') ? old('price') : $price }}" required />

                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

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

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-2 control-label">Description</label>
                            <div class="col-md-9">
                                <textarea id="description" class="form-control" name="description" rows="8">{{ old('description') ? old('description') : $description }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label for="status" class="col-md-2 control-label">Status</label>
                            <div class="col-md-9">
                                <select id="status" class="form-control" name="status">
                                @foreach ($statuses as $s)
                                    @if ($status == $s)
                                        <option value="{{ $s }}" selected>{{ $s }}</option>
                                    @else
                                        <option value="{{ $s }}">{{ $s }}</option>
                                    @endif
                                @endforeach
                                </select>

                                @if ($errors->has('status'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('color') ? ' has-error' : '' }}">
                            <label for="color" class="col-md-2 control-label">Color</label>
                            <div class="col-md-9">
                                <input id="color" class="form-control" name="color" value="{{ old('color') ? old('color') : $color }}" />
                                <small>* Comma separated values with SKU in brackets, e.g. blue(222),green(333),yellow(555)</small>

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
                                <input id="weight" class="form-control" name="weight" value="{{ old('weight') ? old('weight') : $weight }}" />

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
                                <input id="dimension" class="form-control" name="dimension" value="{{ old('dimension') ? old('dimension') : $dimension }}" />

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
                                <input id="weight_capacity" class="form-control" name="weight_capacity" value="{{ old('weight_capacity') ? old('weight_capacity') : $weight_capacity }}" />

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
                                <input id="age_requirement" class="form-control" name="age_requirement" value="{{ old('age_requirement') ? old('age_requirement') : $age_requirement }}" />

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
                                <input id="awards" class="form-control" name="awards" value="{{ old('awards') ? old('awards') : $awards }}"  />

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
                                <input id="video_links" class="form-control" name="video_links" value="{{ old('video_links') ? old('video_links') : $video_links }}" />

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
                                <input id="download_links" class="form-control" name="download_links" value="{{ old('download_links') ? old('download_links') : $download_links }}" />

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

                                <input id="image_first" type="file" class="form-control" name="image_first">
        
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

                                <input id="image_second" type="file" class="form-control" name="image_second">
        
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

                                <input id="image_third" type="file" class="form-control" name="image_third">
        
                                @if ($errors->has('image_third'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image_third') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('image_fourth') ? ' has-error' : '' }}">
                            <label for="image_fourth" class="col-md-2 control-label">Image 4</label>

                            <div class="col-md-9">
                                @if ($image_fourth)
                                    <img src="{{ asset('img/'.$image_fourth) }}" class="img-thumbnail" alt="">
                                @endif

                                <input id="image_fourth" type="file" class="form-control" name="image_fourth">
        
                                @if ($errors->has('image_fourth'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image_fourth') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('image_fifth') ? ' has-error' : '' }}">
                            <label for="image_fifth" class="col-md-2 control-label">Image 5</label>

                            <div class="col-md-9">
                                @if ($image_fifth)
                                    <img src="{{ asset('img/'.$image_fifth) }}" class="img-thumbnail" alt="">
                                @endif
                                
                                <input id="image_fifth" type="file" class="form-control" name="image_fifth">
        
                                @if ($errors->has('image_fifth'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image_fifth') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <a href="{{ url('products/'.$id) }}" class="btn btn-link pull-left">Back</a>
                <button type="submit" class="btn btn-default pull-right">Update</button>
            </div>
        </div>
    </div>
</form>
@endsection