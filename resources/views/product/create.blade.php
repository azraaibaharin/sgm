@extends('layouts.admin')

@section('content')
<form class="form-horizontal bottom-padding-sm" role="form" method="POST" action="{{ url('products/create') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create</div>
                    <div class="panel-body">
                        @include('shared.form.select', ['name' => 'brand', 'text' => 'Brand', 'options' => session('brands')])
                        @include('shared.form.textfield', ['name' => 'model', 'text' => 'Model', 'placeholder' => 'Model'])
                        @include('shared.form.textfield', ['name' => 'price', 'text' => 'Price', 'placeholder' => 'Price'])
                        @include('shared.form.select', ['name' => 'category', 'text' => 'Category', 'options' => session('categories')])
                        @include('shared.form.textarea', ['name' => 'description', 'text' => 'Description', 'placeholder' => 'Describe this product..'])
                        @include('shared.form.select', ['name' => 'status', 'text' => 'Status', 'options' => session('statuses')])
                        @include('shared.form.select', ['name' => 'visible', 'text' => 'Visible', 'options' => session('visibility')])
                        @include('shared.form.textfield', ['name' => 'color', 'text' => 'Color', 'placeholder' => 'blue (222), green (333)', 'help' => '* Comma separated values with SKU in brackets, e.g. blue(222),green(333),yellow(555). Add \' -out of stock\' to the SKU if the color is out of stock, e.g. blue(222-out of stock).'])
                        @include('shared.form.textfield', ['name' => 'weight', 'text' => 'Weight', 'placeholder' => '112.0', 'help' => '* In kg, without word \'kg\'. E.g. 2.0.'])
                        @include('shared.form.textfield', ['name' => 'delivery_weight', 'text' => 'Delivery Weight', 'placeholder' => '121.0', 'help' => '* In kg, without word \'kg\'. E.g. 2.0.'])
                        @include('shared.form.textfield', ['name' => 'dimension', 'text' => 'Dimension', 'placeholder' => '100 x 200', 'help' => '* [width] x [height]. E.g. 200 x 250.'])
                        @include('shared.form.textfield', ['name' => 'weight_capacity', 'text' => 'Weight Capacity', 'placeholder' => '55.0', 'help' => '* In kg, without word \'kg\'. E.g. 2.0.'])
                        @include('shared.form.textfield', ['name' => 'age_requirement', 'text' => 'Age Requirement', 'placeholder' => '5'])
                        @include('shared.form.textfield', ['name' => 'awards', 'text' => 'Awards', 'placeholder' => 'Red Label', 'help' => '* comma separated. E.g. Best Brands, Red Label'])
                        @include('shared.form.textfield', ['name' => 'video_links', 'text' => 'Video Links', 'placeholder' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/JiElMKX74H8" frameborder="0" allowfullscreen></iframe>', 'help' => '* copy the \'embed\' link in youtube'])
                        @include('shared.form.textfield', ['name' => 'download_links', 'text' => 'Download Links'])
                        @include('shared.form.file', ['name' => 'image_first', 'text' => 'Image 1'])
                        @include('shared.form.file', ['name' => 'image_second', 'text' => 'Image 2'])
                        @include('shared.form.file', ['name' => 'image_third', 'text' => 'Image 3'])
                        @include('shared.form.file', ['name' => 'image_fourth', 'text' => 'Image 4'])
                        @include('shared.form.file', ['name' => 'image_fifth', 'text' => 'Image 5'])
                        @include('shared.form.textfield', ['name' => 'tag', 'text' => 'Tags', 'placeholder' => '', 'help' => '* space separated values. E.g. modular cute red'])
                        @include('shared.form.textfield', ['name' => 'sort_index', 'text' => 'Sort Index', 'placeholder' => '0', 'help' => '* higher index comes first. E.g. sort index: 99 will be displayed first in the list before sort index: 9.'])
                        @include('shared.form.select', ['name' => 'is_sale', 'text' => 'On Sale', 'options' => session('is_sale_opts')])
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('shared.form.back', ['link' => 'products'])
                @include('shared.form.submit')
            </div>
        </div>
    </div>
</form>
@endsection