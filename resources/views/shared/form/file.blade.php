<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    <label for="{{ $name }}" class="col-md-2 control-label">{{ $text }}</label>

    <div class="col-md-9">
        @if (session($name))
            <img src="{{ asset('img/'.session($name)) }}" class="img-thumbnail" alt="">
        @endif

        <input id="{{ $name }}" type="file" class="form-control" name="{{ $name }}">
        <small>{{ $help }}</small>

        @if ($errors->has($name))
        <span class="help-block">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
        @endif
    </div>
</div>