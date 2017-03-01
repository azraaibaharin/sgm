@extends('layouts.base')

@section('css')
<link rel="stylesheet" type="text/css" href="/css/admin.css" >
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.5.1/css/pikaday.min.css">
@endsection

@section('js-head')
    @parent
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>
    tinymce.init({ 
        selector:'textarea',
        plugins: 'textcolor',
        toolbar1: 'undo redo | styleselect | bold italic | link image | alignleft aligncenter alignright alignjustify | forecolor backcolor'
    });
    </script>
@endsection

@section('navbar-right')
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">More <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{{ url('articles') }}">Articles</a></li>
        <li><a href="{{ url('testimonials') }}">Testimonials</a></li>
        <li><a href="{{ url('stores') }}">Stores</a></li>
        <li><a href="{{ url('warranties/create') }}">Register Warranty</a></li>
    </ul>
</li>
@if (Auth::guest())
    <li><a href="{{ url('/login') }}">Login</a></li>
@else
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            {{ Auth::user()->name }} <span class="caret"></span>
        </a>

        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="{{ url('warranties') }}">View Warranties</a>
                <a href="{{ url('coupons') }}">View Coupons</a>
                <a href="{{ url('order') }}">View Orders</a>
                <a href="{{ url('/logout') }}"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </li>
@endif
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment-with-locales.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.5.1/pikaday.min.js"></script>
<script>
    var datepickers = document.getElementsByClassName('datepicker');
    for (var i = 0; i < datepickers.length; i++) {
        console.log('Datepicker is' + datepickers[i]);
        var datepicker = datepickers[i];
        var picker = new Pikaday({ 
            field: datepicker,
            format: 'YYYY-MM-DD',   
            onSelect: function() {
                console.log(this);
                console.log(picker.toString());
                datepicker.value = picker.toString();
            }
        });
    }
</script>
@endsection