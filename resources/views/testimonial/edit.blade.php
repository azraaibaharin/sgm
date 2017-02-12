@extends('layouts.admin')

@section('breadcrumb')
| Edit Testimonial
@endsection

@section('content')
<form class="form-horizontal bottom-padding-sm" role="form" method="POST" action="{{ url('testimonials/'.session('id').'/edit') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="container">
        <div class="row">
        	<div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit</div>
                    <div class="panel-body">
                        <div class="form-group{{ $errors->has('product_id') ? ' has-error' : '' }}">
                            <label for="product_id" class="col-md-2 control-label">Brand</label>
                            <div class="col-md-9">
                                <select id="product_id" class="form-control" name="product_id">
                                @foreach ($products as $product)
                                    @if (old('product_id') == $product->id || session('product_id') == $product->id)
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
                        @include('shared.form.textfield', ['name' => 'title', 'text' => 'Title', 'placeholder' => ''])
                        @include('shared.form.textarea', ['name' => 'text', 'text' => 'Text', 'placeholder' => ''])
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('shared.form.back', ['link' => 'testimonials/'.session('id')])
                @include('shared.form.submit')
            </div>
        </div>
    </div>
</form>
@endsection

