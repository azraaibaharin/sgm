@extends('layouts.admin')

@section('breadcrumb')
| Edit Coupon
@endsection

@section('content')
<form class="form-horizontal bottom-margin-sm" role="form" method="POST" action="{{ url('coupons/'.$id) }}" enctype="multipart/form-data">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
    <div class="container">
        <div class="row">
        	<div class="col-md-8 col-md-offset-2">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success" role="alert">{{ $message }}</div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">Edit</div>
                    <div class="panel-body">

                    	<div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                            <label for="code" class="col-md-2 control-label">Code</label>
                            <div class="col-md-9">
                                <input id="code" class="form-control" name="code" value="{{ old('code') ?: $code }}" placeholder="babykid" required />

                                @if ($errors->has('code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- <div class="form-group{{ $errors->has('discount') ? ' has-error' : '' }}">
                            <label for="discount" class="col-md-2 control-label">Discount</label>
                            <div class="col-md-9">
                                <input id="discount" class="form-control" name="discount" value="{{ old('discount') ?: $discount }}" placeholder="10" />

                                @if ($errors->has('discount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('discount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> --}}

                        <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
                            <label for="value" class="col-md-2 control-label">Value</label>
                            <div class="col-md-9">
                                <input id="value" class="form-control" name="value" value="{{ old('value') ?: $value }}" placeholder="123.00" />

                                @if ($errors->has('value'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('value') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('date_of_issue') ? ' has-error' : '' }}">
                            <label for="date_of_issue" class="col-md-2 control-label">Issue date</label>
                            <div class="col-md-9">
                                <input id="date_of_issue" class="form-control" name="date_of_issue" value="{{ old('date_of_issue') ?: $date_of_issue }}" placeholder="YYYY-MM-dd. E.g. 2016-06-02." required />

                                @if ($errors->has('date_of_issue'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date_of_issue') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('date_of_expiration') ? ' has-error' : '' }}">
                            <label for="date_of_expiration" class="col-md-2 control-label">Expiry date</label>
                            <div class="col-md-9">
                                <input id="date_of_expiration" class="form-control" name="date_of_expiration" value="{{ old('date_of_expiration') ?: $date_of_expiration }}" placeholder="YYYY-MM-dd. E.g. 2017-06-02." required />

                                @if ($errors->has('date_of_expiration'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date_of_expiration') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <a href="{{ url('coupons/'.$id) }}" class="btn btn-link pull-left">Back</a>
                    <button type="submit" class="btn btn-default pull-right">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection