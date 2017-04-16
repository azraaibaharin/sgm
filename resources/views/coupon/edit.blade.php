@extends('layouts.admin')

@section('breadcrumb')
| Edit Coupon
@endsection

@section('css')
@parent
<link href="{{ asset('multiselect/multi-select.dist.css') }}" rel="stylesheet">
@endsection

@section('content')
<form id="coupon" class="form-horizontal bottom-padding-sm" role="form" method="POST" action="{{ url('coupons/'.session('id')) }}" enctype="multipart/form-data">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
    <div class="container">
        <div class="row">
        	<div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit</div>
                    <div class="panel-body">
                        @include('shared.form.textfield', ['name' => 'code', 'text' => 'Code', 'placeholder' => 'supremeglobal25'])
                        @include('shared.form/textfield', ['name' => 'percentage', 'text' => 'Percentage', 'placeholder' => '10', 'help' => '* % of reduction'])
                        @include('shared.form.textfield', ['name' => 'value', 'text' => 'Value', 'placeholder' => '100.00', 'help' => '* value of deduction'])
                        <div class="form-group{{ $errors->has('coupon-products') ? ' has-error' : '' }}">
                            <label for="coupon-products" class="col-md-2 control-label">Products applied</label>
                            <div class="col-md-9">
                                <select id='coupon-products' class="form-control" multiple='multiple' name="coupon-products[]">
                                    @foreach(session('products') as $product) 
                                        @if (in_array($product->id, explode(",", session('selected_product_ids'))))
                                            <option value='{{ $product->id }}' selected>{{ ucfirst($product->brand) }} {{ $product->model }}</option>
                                        @else
                                            <option value='{{ $product->id }}'>{{ ucfirst($product->brand) }} {{ $product->model }}</option>
                                        @endif
                                    @endforeach   
                                </select>
                                <input type="hidden" name="selected_product_ids" value="{{ session('selected_product_ids') }}">
                                <small>* multiple select from {{ count(session('products')) }} products</small>
                            </div>
                        </div>
                        @include('shared.form.datepicker', ['name' => 'date_of_issue', 'text' => 'Issue date', 'help' => '* the following date format YYYY-MM-dd is used', 'placeholder' => 'YYYY-MM-dd. E.g. 2016-06-05.'])
                        @include('shared.form.datepicker', ['name' => 'date_of_expiration', 'text' => 'Expiry date', 'help' => '* the following date format YYYY-MM-dd is used', 'placeholder' => 'YYYY-MM-dd. E.g. 2016-06-05.'])
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

@section('js')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="{{ asset('multiselect/jquery.multi-select.js') }}"></script>
<script type="text/javascript">
    $('#coupon-products').multiSelect({
        keepOrder: true,
        selectableHeader: "<div class='multiselect-header'>Select</div>",
        selectionHeader: "<div class='multiselect-header'>Selected</div>",
        afterSelect: function(values){
            console.log("selected values: "+values);
            var selectedProductIds = $("[name='selected_product_ids']").val();
            console.log("selectedProductIds: "+selectedProductIds);

            if (selectedProductIds === "undefined" || selectedProductIds === "") { 
                selectedProductIds = values;
            } else {
                selectedProductIds = selectedProductIds + "," + values;
            }
            
            $("[name='selected_product_ids']").val(selectedProductIds);
            selectedProductIds = $("[name='selected_product_ids']").val();
            console.log("selectedProductIds after: "+selectedProductIds);
        },
        afterDeselect: function(values){
            console.log("selected values: "+values);
            var selectedProductIds = $("[name='selected_product_ids']").val();
            console.log("selectedProductIds: "+selectedProductIds);

            if (selectedProductIds.includes(",")) {
                selectedProductIds = selectedProductIds.replace(","+values, "");                
            } else {
                selectedProductIds = selectedProductIds.replace(values, "");                
            }

            $("[name='selected_product_ids']").val(selectedProductIds);
            selectedProductIds = $("[name='selected_product_ids']").val();
            console.log("selectedProductIds after: "+selectedProductIds);
        }
    });
</script>
@endsection