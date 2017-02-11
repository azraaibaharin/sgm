@extends('layouts.admin')

@section('breadcrumb')
| Edit Testimonial
@endsection

@section('content')
<form class="form-horizontal bottom-margin-sm" role="form" method="POST" action="{{ url('testimonials/'.$id.'/edit') }}" enctype="multipart/form-data">
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

                        <div class="form-group{{ $errors->has('product_id') ? ' has-error' : '' }}">
                            <label for="product_id" class="col-md-2 control-label">Brand</label>
                            <div class="col-md-9">
                                <select id="product_id" class="form-control" name="product_id">
                                @foreach ($products as $product)
                                    @if (old('product_id') == $product->id || $product_id == $product->id)
                                        <option value="{{ $product->id }}" selected>{{ ucfirst($product->brand) }} {{ $product->model }}</option>
                                    @else
                                        <option value="{{ $product->id }}">{{ ucfirst($product->brand) }} {{ $product->model }}</option>
                                    @endif
                                @endforeach
                                </select>

                                @if ($errors->has('product_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('product_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    	<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-2 control-label">Title</label>
                            <div class="col-md-9">
                                <input id="title" class="form-control" name="title" value="{{ old('title') ? old('title') : $title }}" required />

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                            <label for="text" class="col-md-2 control-label">Text</label>
                            <div class="col-md-9">
                                <textarea id="text" class="form-control" name="text" rows="5">{{ old('text') ? old('text') : $text }}</textarea>

                                @if ($errors->has('text'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('text') }}</strong>
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
                <a href="{{ url('testimonials/'.$id) }}" class="btn btn-link pull-left">Back</a>
                <button type="submit" class="btn btn-default pull-right">Submit</button>
            </div>
        </div>
    </div>
</form>
@endsection

