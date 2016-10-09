@extends('layouts.product')

@section('content')
<h1>{{ $brand }} {{ $model }}</h1>
<br><label>Description:</label> {{ $description }}
<br><label>Category:</label> {{ $category_id }}
<br><label>Images:</label> {{ $image_links }}
<br><label>Videos:</label> {{ $video_links }}
<br><label>Color:</label> {{ $color }}
<br><label>Downloads:</label> {{ $download_links }}
<br><label>Weight:</label> {{ $weight }}
<br><label>Dimension:</label> {{ $dimension }}
<br><label>Weight capacity</label> {{ $weight_capacity }}
<br><label>Age equirement:</label> {{ $age_requirement }}
<br><label>Awards:</label> {{ $awards }}
<br><a href="{{ url('products') }}">Back</a>
<br><a href="{{ url('products/'.$id.'/edit') }}">Edit</a>
@endsection