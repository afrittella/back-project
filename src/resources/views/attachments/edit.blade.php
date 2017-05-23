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
                'url' => route('bp.attachments.index'),
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
            <a href="{{ route('bp.attachments.index') }}">{!! icon('arrow-left') !!} {{ trans('back-project::menu.My Media') }}</a>
            @component('back-project::components.panel', ['box_title' => trans('back-project::crud.edit'), 'box_icon' => 'pencil'])
                {!! Form::model($attachment, ['class' => 'form-horizontal', 'method' => 'post', 'route' => ['bp.attachments.update', $attachment->id]]) !!}
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
{{--
                        @component('back-project::components.forms.checkbox', [
                            'name' => 'is_main',
                            'value' => 1,
                            'checked' => (bool) $attachment->is_main
                        ])
                            {{ trans('back-project::media.is_main') }}
                        @endcomponent
                        --}}

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