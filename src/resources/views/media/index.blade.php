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
                'active' => true,
                'title' => trans('back-project::menu.All Media'),
                'icon' => 'file-image-o'
            ]
        ]
      ])
        {{  trans('back-project::menu.All Media') }}
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @component('back-project::components.panel', ['box_title' => trans('back-project::crud.list'), 'box_icon' => 'list'])

                @if (!empty($attachments))

                    <div class="row">
                        @foreach($attachments as $attachment)

                            <div class="col-md-3 col-sm-3">

                                @component('back-project::components.thumbnail', [
                                    'image' => $attachment,

                                    'fancybox' => true,
                                    'show_user' => true
                                ])

                                    @component('back-project::components.generic-button-link', [
                                        'url' => route('bp.media.edit', [$attachment->id]),
                                        'action' => 'edit',
                                        'class' => 'sm',
                                        'color' => 'default',
                                        'icon' => 'edit'
                                    ])
                                        {{ trans('back-project::crud.edit') }}
                                    @endcomponent

                                    @component('back-project::components.generic-button-link', [
                                        'url' => route('bp.media.delete', [$attachment->id]),
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
            @endcomponent
        </div>
    </div>
@endsection