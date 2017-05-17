@extends('layouts.warranty')

@section('breadcrumb')
| Warranties
@endsection

@section('content')
@include('shared.message')
<div id="warranties" class="container">
	<div class="row">
		@if (sizeof($warranties) > 0)
			<div class="col-md-12 bottom-padding-sm">
				<small>{{ count($warranties) }} result(s)</small>
			</div>
			<div class="col-md-12 bottom-padding-sm">
				<div class="table-responsive">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Serial No.</th>
								<th>Name</th>
								<th>Model</th>
								<th>Submitted On</th>
								<th>Details</th>
							</tr>
						</thead>
						<tbody>
						@foreach($warranties as $w)
							<tr>
								<td>{{ $w->product_serial_number }}</td>
								<td>{{ $w->full_name }}</td>
								<td>{{ $w->product_model_name }}</td>
								<td>{{ date('Y-m-d', strtotime($w->created_at)) }}</td>
								<td><a href="{{ url('warranties/'.$w->id) }}">Show</a></td>
							</tr>				
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		@else
			<div class="col-md-12 text-center">
				<small>No warranties available. @if (!Auth::guest()) Click <a href="{{ url('warranties/create') }}">here</a> to add. @endif</small>
			</div>
		@endif		
	</div>
</div>
<a id="scrollTop" href="#top">Scroll to top</a>
@endsection