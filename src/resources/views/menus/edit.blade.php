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
                'url' => route('menus.index'),
                'title' => trans('back-project::menu.Menus'),
                'icon' => 'ellipsis-v'
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
        <div class="col-md-12">
            @if (!empty($menu->parent_id))
                <a href="{{ route('menus.edit', [$menu->parent_id]) }}">{!! icon('arrow-left') !!} {{ trans('back-project::crud.back') }}</a>
            @else
                <a href="{{ route('menus.index') }}">{!! icon('arrow-left') !!} {{ trans('back-project::menu.Menus') }}</a>
            @endif
            @component('back-project::components.panel', ['box_title' => trans('back-project::crud.edit'), 'box_icon' => 'pencil'])
                {!! Form::model($menu, ['class' => 'form-horizontal', 'method' => 'post', 'route' => ['menus.update', $menu->id]]) !!}
                {{ method_field('PUT') }}

                @include('back-project::components.forms.text', [
                    'name' => 'name',
                    'title' => trans('back-project::menus.name'),
                    'attributes' => [
                        'required',
                        'autofocus'
                    ]
                ])

                @include('back-project::components.forms.text', [
                    'name' => 'title',
                    'title' => trans('back-project::menus.title'),
                    'attributes' => [
                        'required'
                    ]
                ])

                @include('back-project::components.forms.text', [
                    'name' => 'description',
                    'title' => trans('back-project::menus.description'),
                    'attributes' => [

                    ]
                ])

                @include('back-project::components.forms.text', [
                    'name' => 'route',
                    'title' => trans('back-project::menus.route'),
                    'attributes' => [

                    ]
                ])

                @include('back-project::components.forms.text', [
                    'name' => 'icon',
                    'title' => trans('back-project::menus.icon'),
                    'attributes' => [

                    ]
                ])

                @if (!empty($permissions))
                    <div class="col-sm-8 col-sm-push-4">
                        <label>{{ trans('back-project::roles.permissions') }}</label>
                        <div class="row">
                            @foreach ($permissions as $permission)
                                <div class="col-sm-4">
                                    @component('back-project::components.forms.checkbox', [
                                        'name' => 'permissions[]',
                                        'value' => $permission->id,
                                        'checked' => ($menu->permission == $permission->name),
                                        'label' => $permission->name
                                    ])
                                        {{ $permission->name }}
                                    @endcomponent
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

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

            @if ($menu->depth < 2)
                @component('back-project::components.panel', ['box_title' => trans('back-project::menus.children'), 'box_icon' => 'sitemap', 'box_color' => 'info'])
                    <h4><i class="fa fa-plus"></i> {{ trans('back-project::crud.new') }}</h4>
                    @component('back-project::menus.action-add', ['menu' => $menu])
                    @endcomponent
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-2">
                                <small>{{ trans('back-project::menus.name') }}</small>
                            </div>
                            <div class="col-md-2">
                                <small>{{ trans('back-project::menus.title') }}</small>
                            </div>
                            <div class="col-md-2">
                                <small>{{ trans('back-project::menus.route') }}</small>
                            </div>
                            <div class="col-md-2">
                                <small>{{ trans('back-project::menus.icon') }}</small>
                            </div>
                            <div class="col-md-2">
                                <small>{{ trans('back-project::menus.permission') }}</small>
                            </div>
                            <div class="col-md-2">
                                <small>{{ trans('back-project::crud.actions') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="list-group">
                        @each('back-project::menus.action', $children, 'menu')
                    </div>
                @endcomponent
            @endif
        </div>
    </div>
@endsection