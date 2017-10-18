@extends('back-project::layouts.enter')

@push('body_classes')
  register-page
@endpush

@section('content')
  <div class="register-box">
    <div class="register-logo">
      <a href="{{config('app.url')}}">{{config('app.name') }}</a>
    </div>

    <div class="register-box-body">
      <p class="login-box-msg">{{ trans('back-project::base.register') }}</p>

      <form class="form-horizontal" role="form" method="POST" action="{{ url('register') }}">
          {{ csrf_field() }}

          <div class="form-group has-feedback{{ $errors->has('username') ? ' has-error' : '' }}">
            <input type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="{{ trans('back-project::base.username') }}" required autofocus>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            @if ($errors->has('username'))
                <span class="help-block">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
            @endif
          </div>

          <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="{{ trans('back-project::base.email_address') }}" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
          </div>

          <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
            <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="{{ trans('back-project::base.password') }}" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          </div>

          <div class="form-group has-feedback">
            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="{{ trans('back-project::base.confirm_password') }}" required>
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>

          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox" name="terms" {{ old('terms') == 'on' ? 'checked' : '' }} required> {!! trans('back-project::base.agree_terms', ['terms' => '<a href="#">'.trans('back-project::base.terms').'</a>']) !!}
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('back-project::base.enter')}}</button>
            </div>
            <!-- /.col -->
          </div>

          <div class="row">
            <div class="col-xs-12">
              <br>
              <a href="{{url('login') }}">{{ trans('back-project::base.already_registered') }}</a>
            </div>
          </div>
      </form>
    </div>
<!-- /.form-box -->
</div>
<!-- /.register-box -->

@endsection
