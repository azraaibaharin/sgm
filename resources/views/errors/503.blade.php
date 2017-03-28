@extends('layouts.base')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-page top-bottom-margin-lg">
                <h1>You have broken the internet.</h1>
                <p><a href="{{ url('') }}">Fix it</a></p>
            </div>
        </div>
    </div>
</div>
@endsection