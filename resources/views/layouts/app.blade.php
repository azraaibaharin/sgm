@extends('layouts.base')

@section('navbar-right')
    <li><a href="#feature">Feature</a></li>
    <li><a href="#event">Event</a></li>
    <li><a href="#potm">Product of The Month</a></li>
    <li><a href="#getintouch">Get In Touch</a></li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">More <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li><a href="{{ url('articles') }}">Articles</a></li>
            <li><a href="{{ url('testimonials') }}">Testimonials</a></li>
            <li><a href="{{ url('stores') }}">Store Locator</a></li>
            <li><a href="{{ url('warranties/create') }}">Register Warranty</a></li>
        </ul>
    </li>
    <li class="dropdown">
    @if (!Auth::guest())
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            {{ Auth::user()->name }} <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="{{ url('home/edit') }}">Edit Home</a>
                <a href="{{ url('warranties') }}">View Warranties</a>
                <a href="{{ url('coupons') }}">View Coupons</a>
                <a href="{{ url('order') }}">View Orders</a>
                <a href="{{ url('logout') }}"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    @endif
    </li>
@endsection
