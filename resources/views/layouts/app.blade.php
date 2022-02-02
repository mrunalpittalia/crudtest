<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<?php $route_name = \Route::current()->getName();?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <link rel="icon" href="{{ asset('favicon.ico') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@if(isset($page_title)){{ $page_title.' - ' }}@endif {{ config('app.name') }}</title>
    <script src="{{ asset('js/app.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript" >
        jQuery(document).ready(function($) {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery('[data-bs-toggle="tooltip"]').tooltip({ boundary: 'window' });
            jQuery('[data-bs-toggle="popover"]').popover();
        });
    </script>
    <style type="text/css">
        .header_logo{width: 180px;}
        @media (max-width: 767.98px) {
            .header_logo{width: 100%;}
            .navbar-brand{ text-align: center; }
        }
    </style>
    @yield('customscss')
</head>
<body class="d-flex flex-column h-100" >
    <header class="shadow-sm bg-transparent">
        <nav id="navbar" class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('home') }}" title="{{ config('app.name') }}"  >
                    <div class="d-block d-md-inline-block text-primary align-middle m-2">
                        <div class="d-block w-100 fs-5 fw-bold">
                            {{ config('app.name') }}
                        </div>
                    </div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#system_navigation" aria-controls="system_navigation" aria-expanded="false" >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="system_navigation">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="fw-bold nav-link @if($route_name == 'home'){{'active'}}@endif" href="{{ route('home') }}">
                                {{ trans('messages.menu_home_text') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="fw-bold nav-link @if($route_name == 'company.index'){{'active'}}@endif" href="{{ route('company.index') }}">
                                {{ trans('messages.menu_company_manage_text') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="fw-bold nav-link @if($route_name == 'employee.index'){{'active'}}@endif" href="{{ route('employee.index') }}">
                                {{ trans('messages.menu_employee_manage_text') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main role="main" class="flex-shrink-0 my-5" id="content_main">
        <div class="@if(empty($containerfluid)){{'container'}}@else{{'container-fluid'}}@endif">
            <div id="system_message" class="row">
                <div class="col-12">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible my-3 text-start" role="alert">
                            <div class="w-100">{!! session('status') !!}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (Session::has('sys_messages'))
                        <?php $sys_messages = Session::get('sys_messages');?>
                        @foreach ($sys_messages as $message_type => $messages)
                            @if (is_array($messages) && count($messages) > 0)
                                <div class="alert alert-{{$message_type}} my-3 text-start alert-dismissible" role="alert">
                                    @foreach ($messages as $key => $each_message)
                                        <div class="w-100">{!!$each_message!!}</div>
                                    @endforeach
                                    <button type="button"class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                        @endforeach
                        <?php Session::forget('sys_messages'); ?>
                    @endif
                </div>
            </div>
            <div id="content_cover" class="row">
                <div id="content_cover_cl" class="col-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>
    @yield('customscript')
</body>
</html>