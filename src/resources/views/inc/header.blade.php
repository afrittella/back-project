<header class="main-header">
  <!-- Logo -->
  <a href="{{ url('') }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini">{!! config('back-project.logo_small') !!}</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg">{!! config('back-project.logo_large') !!}</span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">{{ trans('back-project::base.toggle_navigation') }}</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>

    <!-- include menu -->

    @include('back-project::inc.nav')
  </nav>
</header>
