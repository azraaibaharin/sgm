@extends('layouts.app')

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
@if (!Auth::guest())
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            {{ Auth::user()->name }} <span class="caret"></span>
        </a>

        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="{{ url('/testimonials/create') }}">Add Testimonial</a>
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
