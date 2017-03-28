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
                'title' => trans('back-project::base.account'),
            ]
        ]
      ])
        {{  trans('back-project::menu.Users') }}
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-push-2">
            @component('back-project::components.panel', ['box_title' => ($user->is_social ? trans('back-project::base.account_create') : trans('back-project::crud.edit')), 'box_icon' => 'pencil'])
                {!! Form::model($user, ['class' => 'form-horizontal', 'method' => 'post', 'route' => ($user->is_social ? ['admin.add-account'] : ['admin.edit-account']) ]) !!}
                {{ method_field(($user->is_social ? 'PUT' : 'POST')) }}
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
                        ($user->is_social ? 'required' : '')
                    ]
                ])

                @include('back-project::components.forms.password', [
                    'name' => 'password_confirmation',
                    'title' => trans('back-project::users.password_confirmation'),
                    'attributes' => [
                        ($user->is_social ? 'required' : '')
                    ]
                ])

                @slot('box_footer')
                    <div class="pull-right">
                        @component('back-project::components.generic-button', [
                            'submit' => 'submit',
                            'color' => 'success',

                        ])
                            {{ ($user->is_social ? trans('back-project::crud.new') : trans('back-project::crud.save')) }}
                        @endcomponent
                    </div>
                    {!! Form::close() !!}
                @endslot
            @endcomponent
        </div>
    </div>
@endsection