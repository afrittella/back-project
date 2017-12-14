@extends('back-project::layouts.enter')

@push('body_classes')
  login-page
@endpush

<!-- Main Content -->
@section('content')
  <div class="login-box">
    <div class="login-logo">
      <a href="/">{{config('app.name') }}</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">{{ trans('back-project::base.forgot_password_message') }}</p>

        <form role="form" method="POST" action="{{ url('password/email') }}">
            {{ csrf_field() }}

            <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
              <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ trans('back-project::base.email_address') }}" required autofocus>
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
              @if ($errors->has('email'))
                  <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
                  </span>
              @endif
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('back-project::base.enter') }}</button>
            </div>

        </form>

        <div class="row">
          <div class="col-xs-12">
            <a href="{{ url('login') }}">{{ trans('back-project::base.login') }}</a> -
            <a href="{{ url('register') }}" class="text-center">{{ trans('back-project::base.register') }}</a>
          </div>
        </div>
    </div>
    <!-- /.login-box-body -->

  </div>
  <!-- /.login-box -->
@endsection
