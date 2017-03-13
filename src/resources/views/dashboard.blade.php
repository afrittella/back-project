@extends('back-project::layouts.admin')

@section('page-header')
  @component('back-project::components.page-title',
  [
    'breadcrumbs' => [
        [
            'active' => true,
            //'url' => url(config('back-project.route_prefix', 'admin').'/dashboard'),
            'title' => trans('back-project::base.dashboard'),
            'icon' => 'dashboard'
        ]
    ]
  ])
      {{  trans('back-project::base.dashboard') }}
  @endcomponent
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      @component('back-project::components.panel', ['box_title' => 'Today', 'box_icon' => 'list'])

      @endcomponent
    </div>
  </div>
@endsection