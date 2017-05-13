<div class="row">
    <div class="col-sm-12">
        {!! Form::open(['route' => ['menus.store'], 'method' => 'post', 'class' => 'form-inline ajax-handled']) !!}
        {!! Form::hidden('parent_id', $menu->id) !!}
        <div class="form-group {{ $errors->menuAction->has('name') ? ' has-error' : '' }}">
            {!! Form::text('name', null, ['class' => 'form-control', 'required' => true, 'placeholder' => trans('back-project::menus.name').' (*)']) !!}
        </div>
        <div class="form-group {{ $errors->menuAction->has('title') ? ' has-error' : '' }}">
            {!! Form::text('title', null, ['class' => 'form-control', 'required' => true, 'placeholder' => trans('back-project::menus.title').' (*)']) !!}
        </div>
        <div class="form-group {{ $errors->menuAction->has('route') ? ' has-error' : '' }}">
            {!! Form::text('route', null, ['class' => 'form-control', 'placeholder' => trans('back-project::menus.route')]) !!}
        </div>
        <div class="form-group {{ $errors->menuAction->has('icon') ? ' has-error' : '' }}">
            {!! Form::text('icon', null, ['class' => 'form-control', 'placeholder' => trans('back-project::menus.icon')]) !!}
        </div>
        <div class="form-group {{ $errors->menuAction->has('permission') ? ' has-error' : '' }}">
            {!! Form::text('permission', null, ['class' => 'form-control', 'placeholder' => trans('back-project::menus.permission')]) !!}
        </div>
        @component('back-project::components.generic-button', [
                    'submit' => 'submit',
                    'color' => 'success',
                    'icon' => 'add'
                ])
        @endcomponent

        {!! Form::close() !!}
    </div>
</div>

@include('back-project::inc.ajax-action-add')