@extends('layouts.admin')

@section('breadcrumb')
| Add Article
@endsection

@section('content')
<form class="form-horizontal bottom-padding-sm" role="form" method="POST" action="{{ url('articles/create') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="container">
        <div class="row">
        	<div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add</div>
                    <div class="panel-body">
                        @include('shared.form.textfield', ['name' => 'title', 'text' => 'Title', 'placeholder' => 'Title'])
                        @include('shared.form.textarea', ['name' => 'text', 'text' => 'Content', 'placeholder' => ''])
                        @include('shared.form.textfield', ['name' => 'link', 'text' => 'URL', 'placeholder' => 'URL'])
                        @include('shared.form.textfield', ['name' => 'author', 'text' => 'Author', 'placeholder' => 'Author'])
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('shared.form.back', ['link' => 'articles'])
                @include('shared.form.submit')
            </div>
        </div>
    </div>
</form>
@endsection

