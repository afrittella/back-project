<?php
if (isset($app_user) && !is_object($app_user))
    header('Location: '.route('login'));
?>
{{-- Admin layout - author <afrittella> --}}<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('site_description')">
    <meta name="author" content="@yield('site_content')">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('site_title')</title>

    @include('back-project::inc.bootbox')

    @include('back-project::inc.alerts')

    @include('back-project::inc.fancybox')


    @stack('meta')

    @stack('before_styles')

    <link href="{{ asset('vendor/adminlte/') }}/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link href="{{ asset('vendor/adminlte/') }}/dist/css/AdminLTE.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/pace/pace.min.css">
    <link href="{{ asset('vendor/adminlte/') }}/dist/css/skins/skin-yellow.min.css" rel="stylesheet">

@stack('after_styles')

@stack('head_scripts')

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="hold-transition skin-yellow sidebar-mini @stack('body_classes')">
@stack('after_body')

<div class="wrapper">

@include('back-project::inc.header')

<!-- main-menu -->
@include('back-project::inc.sidebar')
<!-- /main-menu

    <!-- content -->
    <div class="content-wrapper">
        <section class="content-header">
            @yield('page-header')
        </section>

        <section class="content">
            @yield('content')
        </section>
    </div>
    <!-- /content-wrapper -->

</div>
<!-- /wrapprer -->

@stack('before_scripts')
<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
<script>window.jQuery || document.write('<script src="{{ asset('vendor/adminlte') }}/plugins/jQuery/jQuery-2.2.3.min.js"><\/script>')</script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ asset('vendor/adminlte') }}/bootstrap/js/bootstrap.min.js"></script>
<script src="{{ asset('vendor/adminlte') }}/plugins/pace/pace.min.js"></script>
<script src="{{ asset('vendor/adminlte') }}/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="{{ asset('vendor/adminlte') }}/plugins/fastclick/fastclick.js"></script>
<script src="{{ asset('vendor/adminlte') }}/dist/js/app.min.js"></script>
<script src="{{ asset('vendor/back-project') }}/js/jquery.form.min.js"></script>
<script src="{{ asset('vendor/back-project') }}/js/admin.js"></script>

<script type="text/javascript">
    // To make Pace works on Ajax calls
    $(document).ajaxStart(function () {
        Pace.restart();
    });
    // Ajax calls should always have the CSRF token attached to them, otherwise they won't work
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // Set active state on menu element
    var current_url = "{{ Request::url() }}";
    $("ul.sidebar-menu li a").each(function () {
        if ($(this).attr('href').startsWith(current_url) || current_url.startsWith($(this).attr('href'))) {
            $(this).parents('li').addClass('active');
        }
    });
</script>

@stack('bottom_scripts')
</body>

</html>
