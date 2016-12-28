@extends('layouts.admin')

@section('breadcrumb')
| Edit Article
@endsection

@section('content')
<form class="form-horizontal" role="form" method="POST" action="{{ url('warranties/'.$id.'/edit') }}" enctype="multipart/form-data">
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

                    	<div class="form-group{{ $errors->has('full_name') ? ' has-error' : '' }}">
                            <label for="full_name" class="col-md-2 control-label">Full name</label>
                            <div class="col-md-9">
                                <input id="full_name" class="form-control" name="full_name" value="{{ old('full_name') ? old('full_name') : $full_name }}" required />

                                @if ($errors->has('full_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('full_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-2 control-label">Email</label>
                            <div class="col-md-9">
                                <input id="email" class="form-control" name="email" value="{{ old('email') ? old('email') : $email }}" required />

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                            <label for="phone_number" class="col-md-2 control-label">Phone</label>
                            <div class="col-md-9">
                                <input id="phone_number" class="form-control" name="phone_number" value="{{ old('phone_number') ? old('phone_number') : $phone_number }}" required />

                                @if ($errors->has('phone_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="address" class="col-md-2 control-label">Address</label>
                            <div class="col-md-9">
                                <input id="address" class="form-control" name="address" value="{{ old('address') ? old('address') : $address }}" required />

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('product_model_name') ? ' has-error' : '' }}">
                            <label for="product_model_name" class="col-md-2 control-label">Model name</label>
                            <div class="col-md-9">
                                <input id="product_model_name" class="form-control" name="product_model_name" value="{{ old('product_model_name') ? old('product_model_name') : $product_model_name }}" required />

                                @if ($errors->has('product_model_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('product_model_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('product_serial_number') ? ' has-error' : '' }}">
                            <label for="product_serial_number" class="col-md-2 control-label">Serial no.</label>
                            <div class="col-md-9">
                                <input id="product_serial_number" class="form-control" name="product_serial_number" value="{{ old('product_serial_number') ? old('product_serial_number') : $product_serial_number }}" required />

                                @if ($errors->has('product_serial_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('product_serial_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('date_of_manufacture') ? ' has-error' : '' }}">
                            <label for="date_of_manufacture" class="col-md-2 control-label">Manufacture date</label>
                            <div class="col-md-9">
                                <input id="date_of_manufacture" class="form-control" name="date_of_manufacture" value="{{ old('date_of_manufacture') ? old('date_of_manufacture') : $date_of_manufacture }}" required />

                                @if ($errors->has('date_of_manufacture'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date_of_manufacture') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('date_of_purchase') ? ' has-error' : '' }}">
                            <label for="date_of_purchase" class="col-md-2 control-label">Purchase date</label>
                            <div class="col-md-9">
                                <input id="date_of_purchase" class="form-control" name="date_of_purchase" value="{{ old('date_of_purchase') ? old('date_of_purchase') : $date_of_purchase }}" required />

                                @if ($errors->has('date_of_purchase'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date_of_purchase') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <a href="{{ url('warranties/'.$id) }}" class="btn btn-link pull-left">Back</a>
                    <button type="submit" class="btn btn-default pull-right">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

