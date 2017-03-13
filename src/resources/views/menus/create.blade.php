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
            <a href="{{ route('menus.index') }}">{!! icon('arrow-left') !!} {{ trans('back-project::menu.Menus') }}</a>
            @component('back-project::components.panel', ['box_title' => trans('back-project::crud.new'), 'box_icon' => 'plus'])
                {!! Form::open(['class' => 'form-horizontal', 'method' => 'post', 'route' => 'menus.store']) !!}

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
                                        'checked' => false,
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