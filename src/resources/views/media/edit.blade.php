@extends('back-project::layouts.admin')

@section('page-header')
    @component('back-project::components.page-title',
      [
        'breadcrumbs' => [
            [
                'url' => route('bp.admin.dashboard'),
                'title' => trans('back-project::menu.Dashboard'),
                'icon' => 'dashboard'
            ],
            [
                'url' => route('bp.media.index'),
                'title' => trans('back-project::menu.My Media'),
                'icon' => 'user-circle-o'
            ],
            [
                'active' => true,
                'title' => trans('back-project::crud.edit'),
            ]
        ]
      ])
        {{  trans('back-project::menu.Menus') }}
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-9 col-md-push-1">
            <a href="{{ route('bp.media.index') }}">{!! icon('arrow-left') !!} {{ trans('back-project::menu.All Media') }}</a>
            @component('back-project::components.panel', ['box_title' => trans('back-project::crud.edit'), 'box_icon' => 'pencil'])
                {!! Form::model($attachment, ['class' => 'form-horizontal', 'method' => 'post', 'route' => ['bp.media.update', $attachment->id]]) !!}
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col-md-4">
                        {!! MediaManager::getCachedImageTag('medium', $attachment) !!}
                    </div>
                    <div class="col-md-8">
                        @component('back-project::components.forms.text', [
                            'name' => 'description',
                            'title' => trans('back-project::media.description'),
                            'attributes' => [
                                'autofocus',
                                'placeholder="'.trans('back-project::media.description').'"'
                            ],
                            'hide_label' => true
                        ])
                        @endcomponent

                        <hr>   <br>
                        <img src=" {{ Avatar::create(strtoupper($attachment->user->username))->toBase64() }}" alt="{{  $attachment->user->username}}" class="user-image" with="40" height="40">
                        {{ $attachment->user->username }}
                    </div>
                </div>
                @slot('box_footer')
                    <div class="pull-right">
                        @component('back-project::components.generic-button', [
                            'submit' => 'submit',
                            'color' => 'success',

                        ])
                            {{ trans('back-project::crud.save') }}
                        @endcomponent
                    </div>
                    {!! Form::close() !!}
                @endslot
            @endcomponent

        </div>
    </div>
@endsection