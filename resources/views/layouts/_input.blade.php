<div class="form-group{{ $errors->has($input_name) ? ' has-error' : '' }}">
    <label for="{{$input_name}}" class="col-md-2 control-label">Model</label>
    <div class="col-md-9">
        <input id="{{$input_name}}" class="form-control" name="{{$input_name}}" value="{{ old($input_name) ? old($input_name) : $model }}"required autofocus>

        @if ($errors->has('model'))
            <span class="help-block">
                <strong>{{ $errors->first('model') }}</strong>
            </span>
        @endif
    </div>
</div>