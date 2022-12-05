{{-- **************************************** --}}
{{-- ***GESTION DE LINEAS --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Febrero de 2.022 --}}
{{-- **************************************** --}}

@extends('layouts.template')

@section('estilos')

    <!-- Bootstrap Datetimepicker CSS -->
    <link href="{{ asset('vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>

@endsection


@section('menu')

    @include('layouts._menuAdministrador')

@endsection


@section('contenido')

    <!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Gestión de Servicios</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Servicios</a></li>
                <li><a href="#"><span>SERV. Gestión Servicios</span></a></li>
                <li class="active"><span>Nuevo</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->

    <!-- Row Form -->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-panel card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Nuevo Servicio</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <form method="POST" action="{{ route('servicio.store') }}">
                                @csrf

                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="cliente">Cliente</label>
                                    <input type="text" class="form-control" id="cliente" name="cliente" disabled value="{{ $cliente->nombre }}">
                                </div> 
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="patio_cliente">Patio Cliente</label>
                                    <input type="text" class="form-control" id="patio_cliente" name="patio_cliente" disabled value="{{ $patio_cliente->nombre }}">
                                </div>                                
                                <div class="row mb-10">
                                    <div class="col-sm-6">

                                        <!--Fecha de servicio puede ser automatica o manual-->
                                        @if(config('appconf.FECHA_SERVICIO') == "A")
                                            <fieldset readonly onmousedown="return false;">
                                                <label class="control-label mb-10" for="fecha_servicio">Fecha servicio *</label>
                                                <input type="text" class="form-control" id="fecha_servicio" name="fecha_servicio" value="{{ Now() }}">
                                            </fieldset>
                                        @else
                                            <fieldset readonly onmousedown="return false;">
                                                <label class="control-label mb-10" for="fecha_servicio">Fecha servicio *</label>
                                                <div class='input-group date' id='datetimepicker1'>
                                                    <input type='text' class="form-control" id="fecha_servicio" name="fecha_servicio" required value="{{Now()}}" />
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </span>
                                                </div>
                                            </fieldset> 
                                        @endif

                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="tipo_registro">Tipo Documento a Crear</label>
                                        <input type="text" class="form-control" id="tipo_registro" name="tipo_registro" disabled value="{{ $tipo_registro }}">
                                    </div>
                                </div>
                                
                                <!--OT: 260522-012-->
                                @include('custom.part.sin_placa')
                                <!--OT: 260522-012-->

                                <div class="form-group">
                                    <label class="control-label mt-10 mb-10 text-left">Notas</label>
                                    <textarea class="form-control" rows="4" id="notas" name="notas"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="creado_por">Creado Por</label>
                                    <input type="text" class="form-control" id="creado_por" name="creado_por" disabled value="{{ $creado_por }}">
                                </div>                                 

                                <div class="form-group text-center">
                                    <a href="{{ url()->previous() }}" class="btn btn-warning btn-rounded btn-icon left-icon btn-sm"><i class="fa fa-hand-o-left"></i> <span>Atras</span></a>
                                    <button type="submit" class="btn btn-primary btn-rounded btn-icon left-icon btn-sm"><i class="fa fa-thumbs-o-up"></i> <span>Siguiente >></span></button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row Form-->

@endsection

@section('scripts')

		<!-- Moment JavaScript -->
		<script type="text/javascript" src="{{ asset('vendors/bower_components/moment/min/moment-with-locales.min.js') }}"></script>

		<!-- Bootstrap Colorpicker JavaScript -->
		<script src="{{ asset('vendors/bower_components/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
				
		<!-- Bootstrap Datetimepicker JavaScript -->
		<script type="text/javascript" src="{{ asset('vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
		
		<!-- Bootstrap Daterangepicker JavaScript -->
		<script src="{{ asset('vendors/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
		
		<!-- Form Picker Init JavaScript -->
		<script src="{{ asset('dist/js/form-picker-data.js') }}"></script>



@endsection