@extends('layouts.admin')

@section('breadcrumb')
| Edit Home
@endsection

@section('content')
@include('shared.form.error')
@include('shared.message')
<form class="form-horizontal bottom-padding-sm" role="form" method="POST" action="{{ url('/home/edit') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="container">
        <div class="row">
            {{-- Nuna --}}
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Nuna</div>
                    <div class="panel-body">
                        @include('shared.form.textarea', ['name' => 'nuna_text', 'text' => 'Text'])
                        @include('shared.form.file', ['name' => 'nuna_img', 'text' => 'Image', 'help' => '* for a nice look, minimum size: 735px x 500px'])
                    </div>
                </div>
            </div>

            {{-- Babyhood --}}
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Babyhood</div>
                    <div class="panel-body">
                        @include('shared.form.textarea', ['name' => 'babyhood_text', 'text' => 'Text'])
                        @include('shared.form.file', ['name' => 'babyhood_img', 'text' => 'Image', 'help' => '* for a nice look, minimum size: 735px x 500px'])
                    </div>
                </div>
            </div>

            {{-- About --}}
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">About</div>
                    <div class="panel-body">
                        @include('shared.form.textarea', ['name' => 'about_text', 'text' => 'Text'])
                    </div>
                </div>
            </div>
            
            {{-- Tagline --}}
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Tagline</div>
                    <div class="panel-body">
                        @include('shared.form.textfield', ['name' => 'tagline_title', 'text' => 'Title'])
                        @include('shared.form.textarea', ['name' => 'tagline_text', 'text' => 'Text'])
                        @include('shared.form.textfield', ['name' => 'tagline_link', 'text' => 'Link'])
                        @include('shared.form.textfield', ['name' => 'tagline_link_text', 'text' => 'Link text'])
                        @include('shared.form.file', ['name' => 'tagline_img', 'text' => 'Image', 'help' => '* maximum image height is 300px'])
                    </div>
                </div>
            </div>

            {{-- Event --}}
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Event</div>
                    <div class="panel-body">
                        @include('shared.form.textfield', ['name' => 'event_title', 'text' => 'Title'])
                        @include('shared.form.textarea', ['name' => 'event_text', 'text' => 'Text'])
                        @include('shared.form.textfield', ['name' => 'event_link', 'text' => 'Link'])
                        @include('shared.form.textfield', ['name' => 'event_link_text', 'text' => 'Link text'])
                        @include('shared.form.file', ['name' => 'event_img', 'text' => 'Image', 'help' => '* maximum image height is 300px'])
                    </div>
                </div>
            </div>

            {{-- Product of The Month --}}
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Product of The Month</div>
                    <div class="panel-body">
                        @include('shared.form.textfield', ['name' => 'potm_title', 'text' => 'Title'])
                        @include('shared.form.textarea', ['name' => 'potm_text', 'text' => 'Text'])
                        @include('shared.form.textfield', ['name' => 'potm_link', 'text' => 'Link'])
                        @include('shared.form.textfield', ['name' => 'potm_link_text', 'text' => 'Link text'])
                        @include('shared.form.file', ['name' => 'potm_img', 'text' => 'Image', 'help' => '* maximum image height is 300px'])
                    </div>
                </div>
            </div>

            {{-- Facebook --}}
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Facebook URL</div>
                    <div class="panel-body">
                        @include('shared.form.textfield', ['name' => 'facebook_babyhood_url', 'text' => 'Babyhood'])
                        @include('shared.form.textfield', ['name' => 'facebook_nuna_url', 'text' => 'Nuna'])
                    </div>
                </div>
            </div>

            {{-- Instagram --}}
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Instagram URL</div>
                    <div class="panel-body">
                        @include('shared.form.textfield', ['name' => 'instagram_babyhood_url', 'text' => 'Babyhood'])
                        @include('shared.form.textfield', ['name' => 'instagram_nuna_url', 'text' => 'Nuna'])
                    </div>
                </div>
            </div>
                
            {{-- Contact --}}
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Contact</div>
                    <div class="panel-body">
                        @include('shared.form.textfield', ['name' => 'contact_email', 'text' => 'Babyhood'])
                    </div>
                </div>
            </div>

            {{-- Shipping rate (West Malaysia) --}}
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Shipping rate (West Malaysia)</div>
                    <div class="panel-body">
                        @include('shared.form.textfield', ['name' => 'shipping_rate_west_per_kilo', 'text' => 'Per kilo', 'placeholder' => '1.50', 'help' => '* in MYR'])
                        @include('shared.form.textfield', ['name' => 'shipping_rate_west_min_charge', 'text' => 'Min Charge', 'placeholder' => '10.00', 'help' => '* in MYR'])
                        @include('shared.form.textfield', ['name' => 'shipping_rate_west_min_weight', 'text' => 'Min Weight', 'placeholder' => '20.00', 'help' => '* in kgs'])
                    </div>
                </div>
            </div>
                
            {{-- Shipping rate (East Malaysia) --}}
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Shipping rate (East Malaysia)</div>
                    <div class="panel-body">
                        @include('shared.form.textfield', ['name' => 'shipping_rate_east_per_kilo', 'text' => 'Per kilo', 'placeholder' => '11.00', 'help' => '* in MYR'])
                        @include('shared.form.textfield', ['name' => 'shipping_rate_east_min_charge', 'text' => 'Min Charge', 'placeholder' => '5.00', 'help' => '* in MYR'])
                        @include('shared.form.textfield', ['name' => 'shipping_rate_east_min_weight', 'text' => 'Min Weight', 'placeholder' => '60.00', 'help' => '* in kgs'])
                    </div>
                </div>
            </div>

            {{-- Sales --}}
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Sales</div>
                    <div class="panel-body">
                        @include('shared.form.textfield', ['name' => 'email_sales', 'text' => 'Email', 'placeholder' => 'sales@babyhood.com'])
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('shared.form.back', ['link' => 'home'])
                @include('shared.form.submit')
            </div>
        </div>
    </div>
</form>
@endsection
