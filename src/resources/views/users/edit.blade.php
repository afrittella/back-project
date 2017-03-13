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
                'url' => route('users.index'),
                'title' => trans('back-project::menu.Users'),
                'icon' => 'users'
            ],
            [
                'active' => true,
                'title' => trans('back-project::crud.edit'),
            ]
        ]
      ])
        {{  trans('back-project::menu.Users') }}
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-push-2">
            <a href="{{ route('users.index') }}">{!! icon('arrow-left') !!} {{ trans('back-project::menu.Users') }}</a>
            @component('back-project::components.panel', ['box_title' => trans('back-project::crud.edit'), 'box_icon' => 'pencil'])
                {!! Form::model($user, ['class' => 'form-horizontal', 'method' => 'post', 'route' => ['users.update', $user->id]]) !!}
                {{ method_field('PUT') }}
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
                ])

                @include('back-project::components.forms.password', [
                    'name' => 'password_confirmation',
                    'title' => trans('back-project::users.password_confirmation'),
                ])
@php

@endphp
                @if (!empty($roles))
                    <div class="form-group col-sm-12">
                        <label>{{ trans('back-project::users.roles') }}</label>
                        <div class="row">
                            @foreach ($roles as $role)
                                <div class="col-sm-4">
                                    @component('back-project::components.forms.checkbox', [
                                        'name' => 'roles[]',
                                        'value' => $role->id,
                                        'checked' => collect($user->roles->pluck('id'))->contains($role->id),
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