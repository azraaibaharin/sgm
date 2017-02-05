<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    <label for="{{ $name }}" class="col-md-2 control-label">{{ $text }}</label>
    <div class="col-md-9">
        @if (session($name))
            <textarea id="{{ $name }}" class="form-control" name="{{ $name }}" rows="6" placeholder="{{ isset($placeholder) ? $placeholder : '' }}">{{ session($name) }}</textarea>
        @else
            <textarea id="{{ $name }}" class="form-control" name="{{ $name }}" rows="5" placeholder="{{ isset($placeholder) ? $placeholder : '' }}">{{ old($name) }}</textarea>
        @endif
        @if (isset($help) && !empty($help)) <small>{{ $help }}</small>@endif
        @if ($errors->has($name))
            <span class="help-block">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>