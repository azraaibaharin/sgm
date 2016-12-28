@extends('layouts.store')

@section('breadcrumb')
| Stores
@endsection

@section('content')
<div class="container">
	<div id="stores-search" class="row">
		<form class="form-horizontal" role="form" method="POST" action="{{ url('stores') }}" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="col-md-4">
				<div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                    <label for="state" class="col-md-2 control-label">State</label>
                    <div class="col-md-10">
                        <select id="state" class="form-control" name="state">
                        @foreach ($states as $s)
                            @if ($state == $s)
                                <option value="{{ $s }}" selected>{{ ucfirst($s) }}</option>
                            @else
                                <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                            @endif
                        @endforeach
                        </select>
                        @if ($errors->has('state'))
                            <span class="help-block">
                                <strong>{{ $errors->first('state') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
			</div>
			<div class="col-md-2">
				<button type="submit" class="center-block btn btn-default">Search</button>
			</div>
		</form>
	</div>
</div>

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

<div id="stores" class="container">
	<div class="row">
	@if (sizeof($stores) > 0)
		<div class="col-md-12 bottom-margin-sm">
			<small>{{ count($stores) }} result(s)</small>
		</div>
		<div class="col-md-12 bottom-margin-sm">
			<table class="table table-striped">
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
	@else
		<div class="col-md-12 text-center">
			<small>No stores available. Click <a href="{{ url('stores/create') }}">here</a> to add.</small>
		</div>
	@endif		
	</div>
</div>

@endsection