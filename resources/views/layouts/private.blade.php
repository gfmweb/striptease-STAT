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
						<b><img src="{{ asset('/img/logo_icon.png?v3') }}" alt="logo" class="logo-image"></b>
						<span class="brand-title"><img src="{{ asset('/img/logo_text.png') }}" alt=""></span>
					</a>
				</div>
				<div class="nav-control">
					<div class="hamburger">
						<span class="line"></span>
						<span class="line"></span>
						<span class="line"></span>
					</div>
				</div>
			</div>
			<div class="header-content">
				<div class="header-left"></div>
				<div class="header-right">
					<ul>
						<li class="icons">
							<a href="javascript:void(0)">
								<i class="mdi mdi-account f-s-20" aria-hidden="true"></i>
								<span style="position: relative; top: -2px;">{{ Auth::user()->name }}</span>
							</a>
							<div class="drop-down dropdown-profile animated bounceInDown">
								<div class="dropdown-content-body">
									<form id="logout-form"
										  action="{{ route('logout') }}"
										  method="POST" style="display: none;">
										{{ csrf_field() }}
									</form>
									<ul>
										<li>
											<a href="#"
											   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
												<i class="icon-power"></i> <span>Выход</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- #/ header -->
		<!-- sidebar -->
		<div class="nk-sidebar">
			<div class="nk-nav-scroll">
				@include('layouts.menu')
			</div>
			<!-- #/ nk nav scroll -->
		</div>
		<!-- #/ sidebar -->
		<!-- content body -->
		<div class="content-body">
			<div class="container-fluid">
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