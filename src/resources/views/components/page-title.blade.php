    <h1>{{ $slot }}
        @if(isset($subtitle)) <small>{{ $subtitle}}</small> @endif
    </h1>

    @if(!empty($breadcrumbs))
        <ol class="breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)
                <li
                @if(!empty($breadcrumb['active']))
                    class="active">
                @else
                    >
                @endif
                @if (isset($breadcrumb['icon']))
                    {!!  icon($breadcrumb['icon']) !!}
                @endif
                @if(empty($breadcrumb['active']))
                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                @else
                    {{ $breadcrumb['title'] }}
                @endif
                </li>
            @endforeach
        </ol>
    @endif