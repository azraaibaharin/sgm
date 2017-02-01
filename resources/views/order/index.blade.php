@extends('layouts.order')

@section('breadcrumb')
| Orders
@endsection

@section('content')
<div class="container">
	<div id="orders-search" class="row">
		<form class="form-horizontal" role="form" method="POST" action="{{ url('order/search') }}" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="col-md-4">
				<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-2 control-label">Email</label>
                    <div class="col-md-10">
                        <input class="form-control type="text" name="email">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
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
			{{ session()->forget('message') }}
		</div>
	</div>
</div>
@endif

@if ($error = session('error'))
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-danger" role="alert">{{ $error }}</div>		
			{{ session()->forget('error') }}
		</div>
	</div>
</div>
@endif

<div id="orders" class="container">
	<div class="row">
	@if (sizeof($orders) > 0)
		<div class="col-md-12 bottom-margin-sm">
			<small>{{ count($orders) }} result(s) for <b>{{ $email }}</b></small>
		</div>
		<div class="col-md-12 bottom-margin-sm">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th class="text-center">Status</th>
						<th>Name</th>
						<th>Phone</th>
						<th>Address</th>
						<th>Created</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				@foreach($orders as $o)
					<tr>
						<td class="text-center">
							<span class="label label-default">{{ ucfirst($o->status) }}</span>
							{{-- {{ ucfirst($o->status) }} --}}
						</td>
						<td>{{ $o->name }}</td>
						<td>{{ $o->phone_number }}</td>
						<td>{{ $o->address }}</td>
						<td>{{ $o->since() }}</td>
						<td><a href="{{ url('order/'.$o->id) }}">Show</a></td>
					</tr>				
				@endforeach
				</tbody>
			</table>
		</div>
	@else
		<div class="col-md-12 text-center">
			<small>Type your email to search for your orders</small>
		</div>
	@endif		
	</div>
</div>
@endsection