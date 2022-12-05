{{-- **************************************** --}}
{{-- ***GESTION DE ITEMS --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Marzo de 2.022 --}}
{{-- **************************************** --}}

@extends('layouts.template')

@section('estilos')

    <!-- select2 CSS -->
    <link href="{{ asset('vendors/bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- switchery CSS -->
    <link href="{{ asset('vendors/bower_components/switchery/dist/switchery.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- bootstrap-select CSS -->
    <link href=".{{ asset('vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- bootstrap-tagsinput CSS -->
    <link href=".{{ asset('vendors/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css"/>
    <!-- bootstrap-touchspin CSS -->
    <link href="{{ asset('vendors/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- multi-select CSS -->
    <link href="{{ asset('vendors/bower_components/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Bootstrap Switches CSS -->
    <link href="{{ asset('vendors/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Bootstrap Datetimepicker CSS -->
    <link href="{{ asset('vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Bootstrap Dropify CSS -->
    <link rel="stylesheet" href="{{ asset('vendors/bower_components/dropify/dist/css/dropify.min.css' )}}">

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
                <li class="active"><span>Nuevo Procedimiento</span></li>
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
                        <h6 class="panel-title txt-dark">Nuevo Procedimiento</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            
                            <form method="POST" action="{{ route('servicio-item.store') }}" accept-charset="UTF-8"  enctype="multipart/form-data">
                                @csrf
                                <input id="serv_servicio_id" name="serv_servicio_id" type="hidden" value="{{ $servicio_id }}">
                                <!--INV Servicios--> 
                                <div class="form-group mt-30 mb-30">
                                    <label class="control-label mb-10 text-left">Procedimiento *</label>
                                    <select class="form-control select2" id="inv_servicio_id" name="inv_servicio_id" required>
                                        <option value="">Elija un Procedimiento</option>
                                        @foreach( $tipoServicios as $key => $value )
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>  
                                <!--INV Servicios-->

                                <div class="row mt-30 mb-30" >
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="radio radio-success">
                                                    <input type="radio" name="accion" id="valor_reparar_pintar" value="valor_reparar_pintar">
                                                    <label for="valor_reparar_pintar">Valor reparar y pintar</label>
                                                </div>                                                
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="radio radio-success">
                                                    <input type="radio" name="accion" id="valor_cambiar_pintar" value="valor_cambiar_pintar">
                                                    <label for="valor_cambiar_pintar">Valor cambiar y pintar</label>
                                                </div>                                                
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="radio radio-success">
                                                    <input type="radio" name="accion" id="valor_cambiar_reparar" value="valor_cambiar_reparar">
                                                    <label for="valor_cambiar_reparar">Valor cambiar</label>
                                                </div>                                                
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="radio radio-success">
                                                    <input type="radio" name="accion" id="fabricar" value="fabricar">
                                                    <label for="fabricar">Valor fabricar</label>
                                                </div>                                                
                                            </div>

                                        </div>
                                    </div>	
                                </div>

                                <!--Carga de imagenes-->
                                <!-- Row -->
                                <div class="row mt-30 mb-30" >
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input class="dropify"  data-max-file-size="10M" data-allowed-file-extensions="jpg jpeg" data name="files[]" type="file">
                                            </div>
                                            <div class="col-sm-6">
                                                <input class="dropify"  data-max-file-size="10M" data-allowed-file-extensions="jpg jpeg" data name="files[]" type="file">
                                            </div>
                                        </div>
                                    </div>	
                                </div>
                                <!-- /Row -->
                                <!-- Row -->
                                <div class="row mt-30 mb-30">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input class="dropify"  data-max-file-size="10M" data-allowed-file-extensions="jpg jpeg" data name="files[]" type="file">
                                            </div>
                                            <div class="col-sm-6">
                                                <input class="dropify"  data-max-file-size="10M" data-allowed-file-extensions="jpg jpeg" data name="files[]" type="file">
                                            </div>
                                        </div>
                                    </div>	
                                </div>
                                <!-- /Row -->
                                <!--/Carga de imagenes-->

                                <div class="form-group">
                                    <label class="control-label mb-10 text-left">Notas</label>
                                    <textarea class="form-control" rows="4" id="notas" name="notas"></textarea>
                                </div>

                                @include('layouts._buttonsForms') 

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

    <!-- Select2 JavaScript -->
    <script src="{{ asset('vendors/bower_components/select2/dist/js/select2.full.min.js') }}"></script>   
    <!-- Switchery JavaScript -->
    <script src="{{ asset('vendors/bower_components/switchery/dist/switchery.min.js') }}"></script>
    <!-- Bootstrap Select JavaScript -->
    <script src="{{ asset('vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <!-- Bootstrap Tagsinput JavaScript -->
    <script src="{{ asset('vendors/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <!-- Bootstrap Touchspin JavaScript -->
    <script src="{{ asset('vendors/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}"></script>
    <!-- Multiselect JavaScript -->
    <script src="{{ asset('vendors/bower_components/multiselect/js/jquery.multi-select.js') }}"></script>
    <!-- Bootstrap Switch JavaScript -->
    <script src="{{ asset('vendors/bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
    <!-- Form Advance Init JavaScript -->
    <script src="{{ asset('dist/js/form-advance-data.js') }}"></script>
    
    <script src="{{ asset('vendors/bower_components/dropify/dist/js/dropify.min.js' )}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
          $('.dropify').dropify({
  
              messages: {
                  'default': 'Arrastra la imagen o da clic para elegir',
                  'replace': 'Arrastra la imagen o da clic para reemplazar',
                  'remove':  'Eliminar',
                  'error':   'Ooops, hay un problema con tu imagen.'
              }
  
          });
        });
    </script>

@endsection