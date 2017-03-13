@extends('back-project::layouts.admin')

@section('page-header')
    @component('back-project::components.page-title',
      [
        'breadcrumbs' => [
            [
                'url' => route('admin.dashboard'),
                'title' => trans('back-project::menu.Dashboard'),
                'icon' => 'dashboard'
            ],
            [
                'active' => true,
                'title' => trans('back-project::menu.My Media'),
                'icon' => 'user-circle-o'
            ]
        ]
      ])
        {{  trans('back-project::menu.My Media') }}
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @component('back-project::components.panel', ['box_title' => trans('back-project::crud.list'), 'box_icon' => 'list'])
                @slot('box_right')
                    @component('back-project::components.generic-button-link', [
                        'color' => 'default bg-purple',
                        'action' => 'add',
                        'icon' => 'add',
                        'class' => 'sm',
                        'attributes' => ' data-toggle="modal" data-target="#media-manager-single-upload"'
                        ])
                        {{ trans('back-project::crud.new') }}
                    @endcomponent
                @endslot

                @if (!empty($attachments))
                    <div class="row">
                        @foreach($attachments as $attachment)

                            <div class="col-md-3 col-sm-4">

                                @component('back-project::components.thumbnail', [
                                    'image' => $attachment,
                                    'fancybox' => true
                                ])
                                    @if(!$attachment->is_main)
                                        @component('back-project::components.generic-button-link', [
                                            'url' => route('attachments.main', [$attachment->id]),
                                            'action' => 'main',
                                            'class' => 'sm',
                                            'color' => 'success',
                                            'icon' => 'star'
                                        ])
                                        @endcomponent
                                    @endif

                                    @component('back-project::components.generic-button-link', [
                                        'url' => route('attachments.edit', [$attachment->id]),
                                        'action' => 'edit',
                                        'class' => 'sm',
                                        'color' => 'default',
                                        'icon' => 'edit'
                                    ])
                                        {{ trans('back-project::crud.edit') }}
                                    @endcomponent

                                    @component('back-project::components.generic-button-link', [
                                        'url' => route('attachments.delete', [$attachment->id]),
                                        'action' => 'delete',
                                        'class' => 'sm',
                                        'color' => 'default',
                                        'icon' => 'delete'
                                    ])
                                        {{ trans('back-project::crud.delete') }}
                                    @endcomponent
                                @endcomponent
                            </div>
                            @if (($loop->index + 1) % 4 == 0)
                                </div>
                                <div class="row">
                            @endif
                        @endforeach
                    </div>
                @endif
                @include('back-project::components.upload-window', [
                    'title' => trans('back-project::media.upload_window_title'),
                    'url' => route('attachments.store')
                    ])
            @endcomponent
        </div>
    </div>
@endsection