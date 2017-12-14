@extends('back-project::layouts.enter')

@push('body_classes')
  register-page
@endpush

<!-- Main Content -->
@section('content')
  <div class="register-box">
    <div class="register-logo">
      <a href="/">{{config('app.name') }}</a>
    </div>

    <div class="register-box-body">
      <p class="register-box-msg">{{ trans('back-project::base.reset_password') }}</p>

      <form role="form" method="POST" action="{{ url('/password/reset') }}">
        {!! csrf_field() !!}

        <input type="hidden" name="token" value="{{ $token }}">

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

        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('back-project::base.reset_password') }}</button>
        </div>

      </form>
    </div>
    <!-- /.form-box -->
  </div>
  <!-- /.register-box -->
@endsection
