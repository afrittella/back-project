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

@push('bottom_scripts')
<script type="text/javascript">
$( document ) . ready( function () {
    var options = {
      success: onSuccess,
      error: onError,
      resetForm: true
    };
    $("form.ajax-handled").ajaxForm(options);

    function onSuccess(responseText, statusText, xhr, form) {
        location.reload();
    }

    function onError(response) {
        //console.log(response.responseJSON);
        if ("" !== response.responseText) {
            $.each(response.responseJSON, function(i, item) {
               var field = $("[name="+i+"]");
               field.parent("div.form-group").addClass('has-error');
            });
        }
    }
});
</script>
@endpush