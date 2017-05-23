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
                'url' => route('bp.users.index'),
                'title' => trans('back-project::menu.Users'),
                'icon' => 'users'
            ],
            [
                'active' => true,
                'title' => trans('back-project::crud.new'),
            ]
        ]
      ])
        {{  trans('back-project::menu.Users') }}
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-push-2">
            <a href="{{ route('bp.users.index') }}">{!! icon('arrow-left') !!} {{ trans('back-project::menu.Users') }}</a>
            @component('back-project::components.panel', ['box_title' => trans('back-project::crud.new'), 'box_icon' => 'plus'])
                {!! Form::open(['class' => 'form-horizontal', 'method' => 'post', 'route' => 'bp.users.store']) !!}

                @include('back-project::components.forms.text', [
                    'name' => 'username',
                    'title' => trans('back-project::users.username'),
                    'attributes' => [
                        'required',
                        'autofocus'
                    ]
                ])

                @include('back-project::components.forms.email', [
                    'name' => 'email',
                    'title' => trans('back-project::users.email'),
                    'attributes' => [
                        'required'
                    ]
                ])

                @include('back-project::components.forms.password', [
                    'name' => 'password',
                    'title' => trans('back-project::users.password'),
                    'attributes' => [
                        'required'
                    ]
                ])

                @include('back-project::components.forms.password', [
                    'name' => 'password_confirmation',
                    'title' => trans('back-project::users.password_confirmation'),
                    'attributes' => [
                        'required'
                    ]
                ])

                @if (!empty($roles))
                    <div class="form-group col-sm-12">
                        <label>{{ trans('back-project::users.roles') }}</label>
                        <div class="row">
                            @foreach ($roles as $role)
                                <div class="col-sm-4">
                                    @component('back-project::components.forms.checkbox', [
                                        'name' => 'roles[]',
                                        'value' => $role->id,
                                        'checked' => false,
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