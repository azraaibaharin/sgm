<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    <label for="{{ $name }}" class="col-md-2 control-label">{{ $text }}</label>
    <div class="col-md-9">
        @if (session($name))
            <input id="{{ $name }}" class="form-control a" name="{{ $name }}" value="{{ session($name) }}" placeholder="{{ $placeholder }}" />
        @else
            <input id="{{ $name }}" class="form-control" name="{{ $name }}" value="{{ old($name) }}" placeholder="{{ $placeholder }}" />
        @endif
        @if (isset($help) && !empty($help)) <small>{{ $help }}</small>@endif
        @if ($errors->has($name))
            <span class="help-block">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>