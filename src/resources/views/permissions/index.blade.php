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
                'title' => trans('back-project::menu.Permissions'),
                'icon' => 'users'
            ]
        ]
      ])
        {{  trans('back-project::menu.Permissions') }}
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @component('back-project::components.panel', ['box_title' => trans('back-project::crud.list'), 'box_icon' => 'list'])
                @slot('box_right')
                    @component('back-project::components.generic-button-link', ['color' => 'default bg-purple', 'action' => 'add', 'icon' => 'add', 'class' => 'sm', 'url' => route('bp.permissions.create')])
                        {{ trans('back-project::crud.new') }}
                    @endcomponent
                @endslot
                @include('back-project::components.data-table', $permissions)
            @endcomponent
        </div>
    </div>
@endsection