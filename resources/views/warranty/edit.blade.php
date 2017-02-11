@extends('layouts.admin')

@section('breadcrumb')
| Edit Warranty
@endsection

@section('content')
<form class="form-horizontal bottom-padding-sm" role="form" method="POST" action="{{ url('warranties/'.session('id').'/edit') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="container">
        <div class="row">
        	<div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit</div>
                    <div class="panel-body">
                        @include('shared.form.textfield', ['name' => 'full_name', 'text' => 'Full name', 'placeholder' => 'Full name'])
                    	@include('shared.form.textfield', ['name' => 'email', 'text' => 'Email', 'placeholder' => 'Email'])
                        @include('shared.form.textfield', ['name' => 'phone_number', 'text' => 'Phone', 'placeholder' => 'Phone number'])
                        @include('shared.form.textfield', ['name' => 'address', 'text' => 'Address', 'placeholder' => 'Address'])
                        @include('shared.form.textfield', ['name' => 'product_model_name', 'text' => 'Model name', 'placeholder' => 'Model name'])
                        @include('shared.form.textfield', ['name' => 'product_serial_number', 'text' => 'Serial no.', 'placeholder' => 'Serial number'])
                        @include('shared.form.textfield', ['name' => 'date_of_manufacture', 'text' => 'Manufacture date', 'placeholder' => 'YYYY-MM-dd. E.g. 2016-06-05.'])
                        @include('shared.form.textfield', ['name' => 'date_of_purchase', 'text' => 'Purchase date', 'placeholder' => 'YYYY-MM-dd. E.g. 2016-06-05.'])
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('shared.form.back', ['link' => 'warranties/'.session('id')])
                @include('shared.form.submit')
            </div>
        </div>
    </div>
</form>
@endsection

