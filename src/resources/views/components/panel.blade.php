<div class="box box-{{ $box_color or "default" }}">
    <div class="box-header with-border">
        @if (isset($box_icon))
            {!!  icon($box_icon) !!}
        @endif
        <h3 class="box-title">{{ $box_title }}</h3>
        @if (isset($box_right))
        <div class="pull-right">
            {!! $box_right !!}
        </div>
        @endif
    </div>
    <div class="box-body">
        {!!  $slot !!}
    </div>
    @if (isset($box_footer))
        <div class="box-footer">{!! $box_footer !!}</div>
    @endif
</div>