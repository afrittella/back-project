<div class="navbar-custom-menu">
  <ul class="nav navbar-nav">
    <li class="user user-menu">
        <a href="{{ url(config('back-project.route_prefix').'/dashboard') }}">
            <img src=" {{ Avatar::create(strtoupper($user->username))->toBase64() }}" alt="{{  $user->username}}" class="user-image">
            <span class="hidden-xs">{{ trans('back-project::base.dashboard') }}</span>
        </a>
    </li>
    <li><a href="{{ url('logout') }}"
        onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();"><i class="fa fa-btn fa-sign-out"></i> Logout</a>
    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form></li>
  </ul>
</div>
