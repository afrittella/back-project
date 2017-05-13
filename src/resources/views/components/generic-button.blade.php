<button type="{{ $submit or "button" }}" @if (isset($action)) data-action="{{ $action }}" @endif class="btn btn-{{ $color or 'success'}} btn-flat {{ !empty($block) ? 'btn-block' : '' }} btn-{{ $class or "normal"}}">
    @if (isset($icon))
        {!!  icon($icon) !!}
    @endif
    {{ $slot or "" }}</button>