@extends('layouts.admin')

@section('breadcrumb')
| Edit Coupon
@endsection

@section('content')
<form class="form-horizontal bottom-padding-sm" role="form" method="POST" action="{{ url('coupons/'.session('id')) }}" enctype="multipart/form-data">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
    <div class="container">
        <div class="row">
        	<div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit</div>
                    <div class="panel-body">
                        @include('shared.form/textfield', ['name' => 'code', 'text' => 'Code', 'placeholder' => 'supremeglobal25'])
                        {{-- @include('shared.form/textfield', ['name' => 'discount', 'text' => 'Discount', 'placeholder' => '10', 'help' => '* % of reduction']) --}}
                        @include('shared.form/textfield', ['name' => 'value', 'text' => 'Value', 'placeholder' => '100.00', 'help' => '* value of deduction'])
                        @include('shared.form/textfield', ['name' => 'date_of_issue', 'text' => 'Issue date', 'placeholder' => 'YYYY-MM-dd. E.g. 2016-06-02'])
                        @include('shared.form/textfield', ['name' => 'date_of_expiration', 'text' => 'Expiry date', 'placeholder' => 'YYYY-MM-dd. E.g. 2016-06-02'])
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