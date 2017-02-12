@extends('layouts.admin')

@section('breadcrumb')
| Edit Order
@endsection

@section('content')
<form class="form-horizontal bottom-padding-sm" role="form" method="POST" action="{{ url('orders/'.session('id')) }}" enctype="multipart/form-data">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
	<div class="container">
        <div class="row">
        	<div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit</div>
                    <div class="panel-body">
                        @include('shared.form.textfield', ['name' => 'name', 'text' => 'Name', 'placeholder' => ''])
                        @include('shared.form.textfield', ['name' => 'email', 'text' => 'Email', 'placeholder' => ''])
                        @include('shared.form.textfield', ['name' => 'phone_number', 'text' => 'Phone number', 'placeholder' => ''])
                        @include('shared.form.textfield', ['name' => 'address', 'text' => 'Address', 'placeholder' => ''])
                        @include('shared.form.select', ['name' => 'status', 'text' => 'Status', 'options' => $statuses])
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if (Auth::guest())
                    @include('shared.form.back', ['link' => 'home'])
                @else
                    @include('shared.form.back', ['link' => 'coupons/'.session('id')])
                @endif
                @include('shared.form.submit')
            </div>
        </div>
    </div>
</form>
@endsection