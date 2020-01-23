@extends('layouts.app')

@section('body')
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10"/>
            </svg>
        </div>
    </div>
    <div id="main-wrapper">
        <!-- header -->
        <div class="header">
            <div class="nav-header">
                <div class="brand-logo">
                    <a href="{{ route('home') }}">
                        <b><img src="{{ asset('/img/logo_icon.png') }}" alt=""></b>
                        <span class="brand-title"><img src="{{ asset('/img/logo_text.png') }}" alt=""></span>
                    </a>
                </div>
            </div>
            <div class="header-content">
                <div class="header-left">

                </div>
                <div class="header-right">
                </div>
            </div>
        </div>
        <!-- #/ header -->
        <!-- content body -->
        <div class="content-body">
            <div class="container">
                @include ('flash::message')
                @yield('content')
            </div>
            <!-- #/ container -->
        </div>
        <!-- #/ content body -->
        <!-- footer -->
        <div class="footer">
            @yield('footer')
        </div>
        <!-- #/ footer -->
    </div>

@stop