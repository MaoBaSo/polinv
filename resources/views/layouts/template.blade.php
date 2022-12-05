<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>{{ config('app.name', 'JPEX') }} | Aplicativo Inventarios</title>
	<meta name="description" content="Aplicativo empresarial de gestión automotriz." />
	<meta name="author" content="Codigo 200 | Mauricio Baquero"/>

	<!--ATENCION-->
	<!--Derechos reservados por TUPARTE-->
	<!--Prohibida su reproducción parcial o total-->

	<!-- Favicon -->
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
	<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

	<!--alerts CSS -->
	<link href="{{ asset('vendors/bower_components/sweetalert/dist/sweetalert.css') }}" rel="stylesheet" type="text/css">

	<!-- Custom CSS -->
	<link href="{{ asset('dist/css/style.css') }}" rel="stylesheet" type="text/css">

	@yield('estilos')

</head>

<body>
	<!--Preloader-->
	<div class="preloader-it">
		<div class="la-anim-1"></div>
	</div>
	<!--/Preloader-->
    <div class="wrapper theme-2-active navbar-top-light horizontal-nav">

		<!-- Top Menu Items -->
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="nav-wrap">
			<div class="mobile-only-brand pull-left">
				<div class="nav-header pull-left">
					<div class="logo-wrap">
						<a href="{{ route('dashboard') }}">
							<img class="brand-img" src="{{ asset('img/logo.png') }}" alt="brand"/>
							<span class="brand-text"><img  src="{{asset('img/brandJP.png')}}" alt="brand"/></span>
						</a>
					</div>
				</div>	
				<a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block ml-20 pull-left" href="javascript:void(0);"><i class="zmdi zmdi-menu"></i></a>
				<a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-more"></i></a>

			</div>
			<div id="mobile_only_nav" class="mobile-only-nav pull-right">
				<ul class="nav navbar-right top-nav pull-right">

					<!--Acerca de-->
					<li class="dropdown alert-drp">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-desktop top-nav-icon"></i></a>
						<ul  class="dropdown-menu alert-dropdown" data-dropdown-in="bounceIn" data-dropdown-out="bounceOut">
							<li>
								<div class="notification-box-head-wrap">
									<span class="notification-box-head pull-left inline-block">Acerca de...</span>
									<div class="clearfix"></div>
									<hr class="light-grey-hr ma-0"/>
								</div>
							</li>
							<li>
								<div class="streamline message-nicescroll-bar">
									<div class="sl-item">
										<a href="javascript:void(0)">
											<div class="icon bg-green">
												<i class="ti-desktop "></i>
											</div>
											<div class="sl-content">
												<span class="inline-block capitalize-font  pull-left truncate head-notifications">SgV</span>
												<span class="inline-block capitalize-font  pull-left truncate head-notifications">Licensed to: Demostración</span>
												<div class="clearfix"></div>
												<p>Versión: {{ config('appconf.VERSION') }}</p>
												<p>Power By Codigo200.com</p>
											</div>
										</a>	
									</div>
									<hr class="light-grey-hr ma-0"/>
								</div>

							</li>
						</ul>
					</li>
					<!--/Acerca de-->

					<li>
						<a href="{{ route('ayuda') }}"><i class="fa fa-support top-nav-icon"></i></a>
					</li>

					<li class="dropdown auth-drp">
						<a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown"><img src="{{ asset('img/user1.png') }}" alt="user_auth" class="user-auth-img img-circle"/><span class="user-online-status"></span><span class="user-auth-name inline-block">{{ Auth::user()->name }} <span class="ti-angle-down"></span></span></a>

						<ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
							<li>
								<a href="#"><i class="zmdi zmdi-account"></i><span>Profile</span></a>
							</li>
							<li class="divider"></li>
							<li>
							<a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="zmdi zmdi-power"></i><span>Log Out</span></a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									{{ csrf_field() }}
								</form>
							</li>
						</ul>
					</li>
				</ul>
			</div>	
			</div>
		</nav>
		<!-- /Top Menu Items -->
				
		<!-- Left Sidebar Menu -->
		<div class="fixed-sidebar-left">
			<ul class="nav navbar-nav side-nav nicescroll-bar">
				<li class="navigation-header">
					<span>Menu</span> 
					<hr/>
				</li>
				
				<!--.Contenido-->
				{{--MENU--}}
				@yield('menu')
				<!--.Contenido-->			
			</ul>
		</div>
		<!-- /Left Sidebar Menu -->
		
		<!-- Main Content -->
		<div class="page-wrapper">
			<div class="container pt-30">
			<!-- Validation Errors -->
			@include('layouts._mensaje')
            <!--.Contenido-->
            {{--CONTENIDO--}}
            @yield('contenido')
            <!--.Contenido-->

			<!-- Footer -->
			<footer class="footer pl-30 pr-30">
				<div class="container">
					<div class="row">
						<div class="col-sm-6">
							<p>Software <strong>PolInv</strong> | Inventarios: <strong>Politecnico Grancolombiano</strong> | VERSION {{ config('appconf.VERSION') }} </p>
						</div>
						<div class="col-sm-6 text-right">
							<p>Siguenos en:</p>
							<a href="https://www.facebook.com/"  target="_blank"><i class="fa fa-facebook"></i></a>
							<a href="https://www.instagram.com/"  target="_blank"><i class="fa fa-instagram"></i></a>
							<a href="https://www.linkedin.com/" target="_blank"><i class="fa fa-linkedin"></i></a>
						</div>
					</div>
				</div>
			</footer>
			<!-- /Footer -->
			</div>
		</div>
		<!-- /Main Content -->

    </div>

	<!-- JavaScript -->
    <!-- jQuery -->
    <script src="{{ asset('vendors/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js') }}"></script>

	<!-- Slimscroll JavaScript Menu-->
	<script src="{{ asset('dist/js/jquery.slimscroll.js') }}"></script>
	<script src="{{ asset('vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js') }}"></script>
	<!--Menu-->	
	<script src="{{ asset('dist/js/skills-counter-data.js') }}"></script>
	<!-- Init JavaScript -->
	<script src="{{ asset('dist/js/init.js') }}"></script>
	<script src="{{ asset('dist/js/widgets-data.js') }}"></script>
    
	<!-- Fancy Dropdown JS -->
	<script src="{{ asset('dist/js/dropdown-bootstrap-extended.js') }}"></script>

    @yield('scripts')

</body>

</html>