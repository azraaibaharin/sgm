@extends('layouts.admin')

@section('breadcrumb')
| Add Article
@endsection

@section('content')
<form class="form-horizontal" role="form" method="POST" action="{{ url('articles/create') }}" enctype="multipart/form-data">
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

                    	<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-2 control-label">Title</label>
                            <div class="col-md-9">
                                <input id="title" class="form-control" name="title" value="{{ old('title') }}" required />

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- <div class="form-group{{ $errors->has('image_link') ? ' has-error' : '' }}">
                            <label for="image_link" class="col-md-2 control-label">Image</label>

                            <div class="col-md-9">
                                <input id="image_link" type="file" class="form-control" name="image_link">
        
                                @if ($errors->has('image_link'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image_link') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div> --}}

                        <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                            <label for="text" class="col-md-2 control-label">Text</label>
                            <div class="col-md-9">
                                <textarea id="text" class="form-control" name="text" rows="5">{{ old('text') }}</textarea>

                                @if ($errors->has('text'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('text') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('link') ? ' has-error' : '' }}">
                            <label for="link" class="col-md-2 control-label">URL</label>
                            <div class="col-md-9">
                                <input id="link" class="form-control" name="link" value="{{ old('link') }}" />

                                @if ($errors->has('link'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('link') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('author') ? ' has-error' : '' }}">
                            <label for="author" class="col-md-2 control-label">Author</label>
                            <div class="col-md-9">
                                <input id="author" class="form-control" name="author" value="{{ old('author') }}" required />

                                @if ($errors->has('author'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('author') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <a href="{{ url('articles') }}" class="btn btn-link pull-left">Back</a>
                    <button type="submit" class="btn btn-default pull-right">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

