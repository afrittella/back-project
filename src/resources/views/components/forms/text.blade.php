<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">

    @include('back-project::components.forms.label', [
                'name' => $name,
                'title' => $title . ((isset($attributes) and in_array('required', $attributes)) ? ' (*) ' : '')
                ]
    )

    <div class="col-md-8">
        {!! Form::text($name, null, array_merge(['class' => 'form-control'], isset($attributes) ? $attributes : [])) !!}

        @if ($errors->has($name))
            <span class="help-block">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>