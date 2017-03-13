<label>
{!! Form::checkbox($name, $value,  isset($checked) ? $checked : false, isset($attributes) ? $attributes : []) !!}
    {{ $slot }}
</label>