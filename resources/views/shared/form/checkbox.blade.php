<div class="form-group">
    <label class="col-md-2 control-label">{{ $text }}</label>
    <div class="col-md-9">
        <div class="checkbox">
            @foreach ($values as $value)
                <label>
                    <input type="checkbox" name="{{ $name }}[]" value="{{ $value }}" {{ str_contains(session($name), $value) ? 'checked' : '' }}> {{ ucfirst($value) }}
                </label>
            @endforeach
          </div>
    </div>
</div>