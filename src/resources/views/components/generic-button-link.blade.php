<a href="{{ $url or "#" }}" @if (isset($action)) data-action="{{ $action }}" @endif class="btn btn-{{ $color or 'primary' }} btn-flat {{ !empty($block) ? 'btn-block' : '' }} btn-{{ $class or "normal"}}" @if (isset($attributes)) {!! $attributes !!} @endif>
    @if (isset($icon))
        {!!  icon($icon) !!}
    @endif
    {{ $slot }}
</a>