@extends('layouts.store')

@section('breadcrumb')
| Stores
@endsection

@section('content')
<div class="container">
	<div id="stores-search" class="row">
		@include('shared.search', ['link' => 'stores', 'name' => 'state', 'text' => 'State', 'options' => $states])
	</div>
</div>
@include('shared.message')
<div id="stores" class="container">
	<div class="row">
		@if (sizeof($stores) > 0)
			<div class="col-md-12 bottom-padding-sm">
				<small>{{ count($stores) }} result(s)</small>
			</div>
			<div class="col-md-12 bottom-padding-sm">
				<div class="table-responsive">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Name</th>
								<th>Phone</th>
								<th>City</th>
								<th>State</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						@foreach($stores as $s)
							<tr>
								<td>{{ $s->name }}</td>
								<td>{{ $s->phone_number }}</td>
								<td>{{ $s->city }}</td>
								<td>{{ $s->state }}</td>
								<td><a href="{{ url('stores/'.$s->id) }}">Show</a></td>
							</tr>				
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		@else
			<div class="col-md-12 text-center">
				<small>No stores available. @if (!Auth::guest()) Click <a href="{{ url('stores/create') }}">here</a> to add.@endif</small>
			</div>
		@endif		
	</div>
</div>
<a id="scrollTop" href="#top">Scroll to top</a>
@endsection