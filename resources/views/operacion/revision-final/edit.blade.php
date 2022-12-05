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
                <li class="active"><span>Editar</span></li>
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

                            <!--Actualizacion OT: 090722-003 carga de imagenes V2 -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default card-view">
                                        <div class="panel-heading">
                                            <div class="pull-left">
                                                <h6 class="panel-title txt-dark">Imagenes Actuales del ítem</h6>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="panel-wrapper collapse in">
                                            <div class="panel-body">
                                                <div class="gallery-wrap">
                                                    <div class="portfolio-wrap project-gallery">
                                                        <ul id="portfolio_1" class="portf auto-construct  project-gallery" data-col="4">
                                                            <!--Actualizacion OT: 090722-003 -->
                                                            @if($ope_calidad->cant_img == 0)
                                                                <!--Si contador es igual a 0, nueva rutina de imagenes-->
                                                                @foreach($imagenes as $imagen)
                                                                    
                                                                    <li class="item" data-src="{{ asset($imagen->url . $imagen->nombre_archivo) }}" data-sub-html="<h6>Img: {{$imagen->nombre_archivo}}</h6><p>
                                                                        
                                                                        <a href='{{ route('calidad-imagen.delete', [$imagen->id,  $ope_calidad->item_id] ) }}'>
                                                                            <button class='btn btn-danger btn-anim'><i class='fa fa-trash-o'></i><span class='btn-text'>Borrar</span></button>
                                                                        </a>

                                                                        </p>">
                                                                        <a href="">
                                                                        <img class="img-responsive" src="{{ asset($imagen->url . $imagen->nombre_archivo) }}"  alt="Image description" />	
                                                                        <span class="hover-cap">Ítem: {{$ope_calidad->item_id}}</span>
                                                                        </a>
                                                                    </li>
                                                                @endforeach                                                                        

                                                            @else
                                                                <!--Si el contador de imagenes tiene numero > 0, antes de actualizacion -->
                                                                <?php 
                                                                    $cont = 1;
                                                                ?>
                                                                @foreach(range(1,$ope_calidad->cant_img) as $current)
                                                                    
                                                                    <li class="item" data-src="{{ asset('imgservices/'. $servicio->cliente_id .'/'. $item->id .'-'. $cont .'.jpeg') }}" data-sub-html="<h6>Ítem: {{$item->id}}</h6><p>Esta imagen está en V1, no se puede eliminar.</p>">
                                                                        <a href="">
                                                                        <img class="img-responsive" src="{{ asset('imgservices/'. $servicio->cliente_id .'/'. $item->id .'-'. $cont .'.jpeg') }}"  alt="Image description" />	
                                                                        <span class="hover-cap">Ítem: {{$item->id}}</span>
                                                                        </a>
                                                                    </li>
                                                                    <?php 
                                                                        $cont++;
                                                                    ?>
                                                                @endforeach

                                                            @endif
                                                            <!--/Actualizacion OT: 090722-003 -->

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                         
                            <!--/Actualizacion OT: 090722-003 carga de imagenes V2-->

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
                            <form method="POST" action="{{ route('operacion-revision.update', $ope_calidad->id) }}" accept-charset="UTF-8"  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

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
                                    <textarea class="form-control" rows="4" id="notas" name="notas" required>{{ $ope_calidad->nota }}</textarea>
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
    
    <!-- Gallery JavaScript -->
    <script src="{{ asset('dist/js/isotope.js') }}"></script>
    <script src="{{ asset('dist/js/lightgallery-all.js') }}"></script>
    <script src="{{ asset('dist/js/froogaloop2.min.js') }}"></script>
    <script src="{{ asset('dist/js/gallery-data.js') }}"></script>

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