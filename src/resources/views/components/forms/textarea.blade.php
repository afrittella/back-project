<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    @if(empty($hide_label))
        @include('back-project::components.forms.label', [
                'name' => $name,
                'title' => $title,
                'required' => ((isset($attributes) and in_array('required', $attributes)) ? true : false)
                ]
        )
        <div class="col-md-8">
    @else
        <div class="col-md-12">
    @endif
        {!! Form::textarea($name, null, array_merge(['class' => 'form-control'], isset($attributes) ? $attributes : [])) !!}

        @if ($errors->has($name))
            <span class="help-block">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>