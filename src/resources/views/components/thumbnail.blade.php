<div class="thumbnail">
    @if (!empty($fancybox))
        <a href="{!! MediaManager::getCachedImageUrl('original', $image->name) !!}" data-fancybox="images" data-caption="{{ $image->description }}" data-type="image">
    @endif

    {!! MediaManager::getCachedImageTag((!empty($format) ? $format : 'medium'), $image) !!}
    @if (!empty($fancybox))
        </a>
    @endif
    <div class="caption">
        <p style="overflow: hidden;">
            <strong>{{ $image->original_name }}</strong>
            @if ($image->is_main)
                {!! @icon('fa-star') !!}
            @endif
        </p>
        <p>{{ $image->description }}</p>
        @if (!empty($show_user))
            <p>
            <img src=" {{ Avatar::create(strtoupper($image->user->username))->toBase64() }}" alt="{{  $image->user->username}}" class="user-image" with="40" height="40">
            {{ $image->user->username }}
            </p>
        @endif
        {!! $slot !!}
    </div>
</div>
