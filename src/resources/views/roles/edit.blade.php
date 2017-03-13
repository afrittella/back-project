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
                'url' => route('roles.index'),
                'title' => trans('back-project::menu.Roles'),
                'icon' => 'users'
            ],
            [
                'active' => true,
                'title' => trans('back-project::crud.edit'),
            ]
        ]
      ])
        {{  trans('back-project::menu.Roles') }}
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-push-2">
            <a href="{{ route('roles.index') }}">{!! icon('arrow-left') !!} {{ trans('back-project::menu.Roles') }}</a>
            @component('back-project::components.panel', ['box_title' => trans('back-project::crud.edit'), 'box_icon' => 'pencil'])
                {!! Form::model($role, ['class' => 'form-horizontal', 'method' => 'post', 'route' => ['roles.update', $role->id]]) !!}
                {{ method_field('PUT') }}
                @include('back-project::components.forms.text', [
                    'name' => 'name',
                    'title' => trans('back-project::roles.name'),
                    'attributes' => [
                        'required',
                        'autofocus'
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
                                        'checked' => collect($role->permissions->pluck('id'))->contains($permission->id),
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
        </div>
    </div>
@endsection