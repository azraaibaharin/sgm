<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    <label for="{{ $name }}" class="col-md-2 control-label">{{ $text }}</label>
    <div class="col-md-9">
        @if (session($name))
            <input id="{{ $name }}" class="form-control datepicker" name="{{ $name }}" value="{{ session($name) }}" placeholder="{{ isset($placeholder) ? $placeholder : '' }}" />
        @else
            <input id="{{ $name }}" class="form-control datepicker" name="{{ $name }}" value="{{ old($name) }}" placeholder="{{ isset($placeholder) ? $placeholder : '' }}" />
        @endif
        @if (isset($help) && !empty($help)) <small>{{ $help }}</small>@endif
        @if ($errors->has($name))
            <span class="help-block">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>