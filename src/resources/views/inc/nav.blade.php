<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
        <li class="dropdown notifications-menu user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                &nbsp;{!! @icon('user') !!}
                {{ $app_user->username }}
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li class="header">
                    <img src=" {{ Avatar::create(strtoupper($app_user->username))->toBase64() }}"
                         alt="{{  $app_user->username}}"
                         class="user-image">
                    {{ $app_user->username }}
                    <small>{{ $app_user->email }}</small>
                </li>
                <li>
                    <ul class="menu">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">
                                {!! @icon('dashboard') !!}
                                {{ trans('back-project::base.dashboard') }}
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.account') }}">
                                {!! @icon('user') !!}
                                {{ trans('back-project::base.account') }}
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();">
                                {!! @icon('sign-out') !!}
                                {{ trans('back-project::base.logout') }}
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</div>

