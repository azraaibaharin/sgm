<form class="form-horizontal" role="form" method="POST" action="{{ url($link) }}" enctype="multipart/form-data">
	{{ csrf_field() }}
	<div class="col-md-4">
		<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
            <label for="{{ $name }}" class="col-md-2 control-label">{{ $text }}</label>
            <div class="col-md-10">
                <select id="{{ $name }}" class="form-control" name="{{ $name}}">
                @foreach ($options as $opt)
                    @if (session($name) == $opt)
                        <option value="{{ $opt }}" selected>{{ ucfirst($opt) }}</option>
                    @else
                        <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                    @endif
                @endforeach
                </select>
                @if ($errors->has($name))
                    <span class="help-block">
                        <strong>{{ $errors->first($name) }}</strong>
                    </span>
                @endif
            </div>
        </div>
	</div>
	<div class="col-md-2">
		<button type="submit" class="center-block btn btn-default">Search</button>
	</div>
</form>