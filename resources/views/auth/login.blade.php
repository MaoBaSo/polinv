<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title>PolInv | Inventario</title>
		<meta name="description" content="Aplicativo empresarial de gestión de personal." />
		<meta name="author" content="Codigo 200 | Mauricio Baquero - Gerardo Riarte"/>

        <!--ATENCION-->
        <!--Derechos reservados por TUPARTE / CARPARTS-->
        <!--Prohibida su reproducción parcial o total-->

		<!-- Favicon -->
		<link rel="shortcut icon" href="favicon.ico">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
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
						<img class="brand-img mr-10" src="{{ asset('img/logo.png') }}" alt="brand"/>
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

                                        <!-- Session Status -->
                                        <x-auth-session-status class="mb-4" :status="session('status')" />

                                        <!-- Validation Errors -->
                                        <x-auth-validation-errors class="mb-4" :errors="$errors" />


                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label class="control-label mb-10" for="email">Usuario</label>
                                                <input type="email" class="form-control" required="" id="email" name="email" placeholder="Usuario">
                                            </div>
                                            <div class="form-group">
                                                <label class="pull-left control-label mb-10" for="password">Password</label>
                                                @if (Route::has('password.request'))
                                                    <a class="capitalize-font txt-danger block mb-10 pull-right font-12" href="{{ route('password.request') }}">
                                                    </a>
                                                @endif                                                
                                                <div class="clearfix"></div>
                                                <input type="password" class="form-control" required="" id="password" name="password" placeholder="Digite pwd">
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="checkbox checkbox-primary pr-10 pull-left">
                                                    <input id="remember_me" type="checkbox" name="remember">
                                                    <label for="remember_me"> Mantener Conectado</label>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-primary btn-rounded">Iniciar Sesión</button>
                                            </div>
                                        </form>

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
