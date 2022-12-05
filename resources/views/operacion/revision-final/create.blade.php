{{-- **************************************** --}}
{{-- ***GESTION DE CALIDAD --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Febrero de 2.022 --}}
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
            <h5 class="txt-dark">Gestión de Calidad</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Operación</a></li>
                <li><a href="#"><span>OPT. Gestión Calidad</span></a></li>
                <li class="active"><span>Nuevo</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->

  
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-panel card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Gestión Calidad Ítem</h6>
                    </div>
                    <div class="pull-right">
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            
                            <!--DATOS ITEMS DEL SEVICIO-->
                            <table id="datable_1" class="table table-hover display  pb-30">
                                <thead>
                                    <tr>
                                        <th>Tipo de procedimiento</th>
                                        <th>Valor</th>
                                        <th>Nota</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>{{ $item->invServicio->nombre }}</td>
                                        <td>{{ number_format($item->valor, 2, ',', '.') }}</td>
                                        <td>{{ $item->nota_item }}</td>
                                    </tr>

                                </tbody>
                            </table>
                            <!-- /LISTA DE ITEMS DEL SEVICIO-->

                            <!--SUBE PROCESO DE CALIDAD--> 
                            <form method="POST" action="{{ route('operacion-revision.store') }}" accept-charset="UTF-8"  enctype="multipart/form-data">
                                @csrf
                                <input id="servicio_id" name="servicio_id" type="hidden" value="{{ $item->serv_servicios_id  }}">
                                <input id="item_id" name="item_id" type="hidden" value="{{ $item->id }}">

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
                                    <label class="control-label mb-10 text-left">Notas *</label>
                                    <textarea class="form-control" rows="4" id="notas" name="notas" required></textarea>
                                </div>

                                <!--Botonera-->
                                @include('layouts._buttonsForms') 

                            </form>
                            <!-- /SUBE PROCESO DE CALIDAD--> 

                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>

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