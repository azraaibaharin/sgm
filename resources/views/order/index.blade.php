@extends('layouts.order')

@section('breadcrumb')
| Orders
@endsection

@section('content')
@include('shared.message')
@include('shared.error')
<div id="orders" class="container">
	<div class="row">
		@if (sizeof($orders) > 0)
			<div class="col-md-12 bottom-margin-sm">
				<small>{{ count($orders) }} result(s)</small>
			</div>
			<div class="col-md-12 bottom-margin-sm">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th class="text-center">Status</th>
							<th>Name</th>
							<th>Reference No</th>
							<th>Created</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					@foreach($orders as $o)
						<tr>
							<td class="text-center">
							@if (strpos(strtolower($o->status), 'unsuccessful') !== false)
								<span class="label label-danger">{{ ucfirst($o->status) }}</span>
							@else
								<span class="label label-success">{{ ucfirst($o->status) }}</span>
							@endif
							</td>
							<td>{{ $o->name }}</td>
							<td>{{ $o->reference_number }}</td>
							<td>{{ $o->since() }}</td>
							<td><a href="{{ url('order/'.$o->id) }}">Show</a></td>
						</tr>				
					@endforeach
					</tbody>
				</table>
			</div>
		@else
			<div class="col-md-12 text-center">
				<small>No orders avaible</small>
			</div>
		@endif		
	</div>
</div>
<a id="scrollTop" href="#top">Scroll to top</a>
@endsection