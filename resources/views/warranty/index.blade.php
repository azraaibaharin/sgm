@extends('layouts.warranty')

@section('breadcrumb')
| Warranties
@endsection

@section('content')
@if ($message = session('message'))
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-info" role="alert">{{ $message }}</div>		
			{{ session()->flush() }}
		</div>
	</div>
</div>
@endif

@if ($message = session('message'))
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-info" role="alert">{{ $message }}</div>		
			{{ session()->flush() }}
		</div>
	</div>
</div>
@endif

<div id="warranties" class="container">
	<div class="row">
	@if (sizeof($warranties) > 0)
		<div class="col-md-12 bottom-margin-sm">
			<small>{{ count($warranties) }} result(s)</small>
		</div>
		<div class="col-md-12 bottom-margin-sm">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Address</th>
						<th>Model</th>
						<th>Serial No.</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				@foreach($warranties as $w)
					<tr>
						<td>{{ $w->full_name }}</td>
						<td>{{ $w->email }}</td>
						<td>{{ $w->phone_number }}</td>
						<td>{{ $w->address }}</td>
						<td>{{ $w->product_model_name }}</td>
						<td>{{ $w->product_serial_number }}</td>
						<td><a href="{{ url('warranties/'.$w->id) }}">Show</a></td>
					</tr>				
				@endforeach
				</tbody>
			</table>
		</div>
	@else
		<div class="col-md-12 text-center">
			<small>No warranties available. Click <a href="{{ url('warranties/create') }}">here</a> to add.</small>
		</div>
	@endif		
	</div>
</div>
@endsection