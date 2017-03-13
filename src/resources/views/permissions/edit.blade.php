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
                'url' => route('permissions.index'),
                'title' => trans('back-project::menu.Permissions'),
                'icon' => 'users'
            ],
            [
                'active' => true,
                'title' => trans('back-project::crud.edit'),
            ]
        ]
      ])
        {{  trans('back-project::menu.Permissions') }}
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-push-2">
            <a href="{{ route('permissions.index') }}">{!! icon('arrow-left') !!} {{ trans('back-project::menu.Permissions') }}</a>
            @component('back-project::components.panel', ['box_title' => trans('back-project::crud.edit'), 'box_icon' => 'pencil'])
                {!! Form::model($permission, ['class' => 'form-horizontal', 'method' => 'post', 'route' => ['permissions.update', $permission->id]]) !!}
                {{ method_field('PUT') }}
                @include('back-project::components.forms.text', [
                    'name' => 'name',
                    'title' => trans('back-project::permissions.name'),
                    'attributes' => [
                        'required',
                        'autofocus'
                    ]
                ])

                @if (!empty($roles))
                    <div class="form-group col-sm-12">
                        <label>{{ trans('back-project::roles.roles') }}</label>
                        <div class="row">
                            @foreach ($roles as $role)
                                <div class="col-sm-4">
                                    @component('back-project::components.forms.checkbox', [
                                        'name' => 'roles[]',
                                        'value' => $role->id,
                                        'checked' => collect($permission->roles->pluck('id'))->contains($role->id),
                                        'label' => $role->name
                                    ])
                                        {{ $role->name }}
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