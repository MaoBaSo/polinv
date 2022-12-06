<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title>{{ config('app.name', 'JPEX') }} | Aplicativo Empresarial</title>
		<meta name="description" content="Aplicativo empresarial de gestión automotriz." />
		<meta name="author" content="Codigo 200 | Mauricio Baquero"/>

        <!--ATENCION-->
        <!--Derechos reservados por TUPARTE-->
        <!--Prohibida su reproducción parcial o total-->

		<!-- Favicon -->
		<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
		<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
		
		<!-- vector map CSS -->
		<link href="vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<!-- Custom CSS -->
		<link href="dist/css/style.css" rel="stylesheet" type="text/css">
    </head>
	<body>
		<!--Preloader-->
		<div class="preloader-it">
			<div class="la-anim-1"></div>
		</div>
		<!--/Preloader-->
		
		<div class="wrapper  pa-0">
			<header class="sp-header">
				<div class="sp-logo-wrap pull-left">
					<a href="index.html">
						<img class="brand-img mr-10" src="img/logo.png" alt="brand"/>
						<span class="brand-text"><img  src="{{asset('img/brandJP.png')}}" alt="brand"/></span>
					</a>
				</div>
				<div class="form-group mb-0 pull-right">
					<a href="#"><span class="inline-block pr-10">¿Que es <strong>PolInv</strong>?</span></a>
				</div>
				<div class="clearfix"></div>
			</header>
			
			<!-- Main Content -->
			<div class="page-wrapper pa-0 ma-0 auth-page">
				<div class="container">
					<!-- Row -->
					<div class="table-struct full-width full-height">
						<div class="table-cell vertical-align-middle auth-form-wrap">
							<div class="auth-form  ml-auto mr-auto no-float card-view pt-30 pb-30">
								<div class="row">
									<div class="col-sm-12 col-xs-12">
										<img class="" src="{{asset('img/LogoJP400x81.png')}}" alt="JPEX"/>
										<div class="mb-30">
											<h5 class="text-center text-muted mb-10">Sistema Gestión Inventarios POLINV PRUEBA</h5>
										</div>	
										<div class="form-wrap text-center">
											@auth
												<a class="inline-block btn btn-warning btn-rounded " href="{{ url('/dashboard') }}">Entrar a Sistema</a>
											@else
												<a class="inline-block btn btn-primary btn-rounded " href="{{ route('login') }}">Iniciar Sesión</a>
											@endauth
										</div>

										<div class="form-wrap text-center mt-30">
											<p>Tu IP: <b>{{ Cerbero::getIP() }}</b></p>
										</div>

									</div>	
								</div>
							</div>
						</div>
					</div>
					<!-- /Row -->	
				</div>
				
			</div>
			<!-- /Main Content -->
		
		</div>
		<!-- /#wrapper -->
		
		<!-- JAVASCRIPT -->
		<!-- jQuery -->
		<script src="vendors/bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap Core JavaScript -->
		<script src="vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
		<!-- Slimscroll JavaScript -->
		<script src="dist/js/jquery.slimscroll.js"></script>
		<!-- Init JavaScript -->
		<script src="dist/js/init.js"></script>
    </body>
</html>
