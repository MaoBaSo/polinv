{{-- **************************************** --}}
{{-- ***GESTION DE ITEMS --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Marzo de 2.022 --}}
{{-- **************************************** --}}

@extends('layouts.template')

@section('estilos')

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
            <h5 class="txt-dark">Gestión de Ítems</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Servicios</a></li>
                <li><a href="#"><span>SERV. Gestión Ítems</span></a></li>
                <li class="active"><span>Editar</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->

    <!--MUESTRA DATOS DEL ITEM-->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-panel card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Editar Ítem</h6>
                    </div>
                    
                    <div class="pull-right">
                        <!--SOLO SE ELIMINAN ÍTEMS EN EL PASO 1-->
                        @if($servicio->tipo == 'Valoración'  && $servicio->estado == 1)
                            <form action="{{ route('servicio-item.destroy', $itemServicio->id ) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                
                                <div class="form-group text-center">
                                    <button type="button" class="inline-block btn btn-danger btn-rounded btn-sm" data-toggle="modal" data-target="#confirmar" data-whatever="@getbootstrap">Eliminar Ítem</button>
                                </div>
        
                                <div class="modal fade" id="confirmar" tabindex="-1" role="dialog" aria-labelledby="confirmarLabel1">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h5 class="modal-title" id="confirmarLabel1">Confirmar proceso</h5>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Confirma la eliminación del registro?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-danger btn-rounded">Confirmar Eliminación</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>                        
                        @endif
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
                                                            @if($itemServicio->cant_img == 0)
                                                                <!--Si contador es igual a 0, nueva rutina de imagenes-->
                                                                @foreach($imagenes as $imagen)
                                                                    
                                                                    <li class="item" data-src="{{ asset($imagen->url . $imagen->nombre_archivo) }}" data-sub-html="<h6>Img: {{$imagen->nombre_archivo}}</h6><p>
                                                                        
                                                                        <a href='{{ route('flota-imagen.delete', [$imagen->id,  $itemServicio->id] ) }}'>
                                                                            <button class='btn btn-danger btn-anim'><i class='fa fa-trash-o'></i><span class='btn-text'>Borrar</span></button>
                                                                        </a>

                                                                        </p>">
                                                                        <a href="">
                                                                        <img class="img-responsive" src="{{ asset($imagen->url . $imagen->nombre_archivo) }}"  alt="Image description" />	
                                                                        <span class="hover-cap">Ítem: {{$itemServicio->id}}</span>
                                                                        </a>
                                                                    </li>
                                                                @endforeach                                                                        

                                                            @else
                                                                <!--Si el contador de imagenes tiene numero > 0, antes de actualizacion -->
                                                                <?php 
                                                                    $cont = 1;
                                                                ?>
                                                                @foreach(range(1,$itemServicio->cant_img) as $current)
                                                                    
                                                                    <li class="item" data-src="{{ asset('imgservices/'. $servicio->cliente_id .'/'. $itemServicio->id .'-'. $cont .'.jpeg') }}" data-sub-html="<h6>Ítem: {{$itemServicio->id}}</h6><p>Esta imagen está en V1, no se puede eliminar.</p>">
                                                                        <a href="">
                                                                        <img class="img-responsive" src="{{ asset('imgservices/'. $servicio->cliente_id .'/'. $itemServicio->id .'-'. $cont .'.jpeg') }}"  alt="Image description" />	
                                                                        <span class="hover-cap">Ítem: {{$itemServicio->id}}</span>
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

                            <form method="POST" action="{{ route('servicio-item.update', $itemServicio->id) }}" accept-charset="UTF-8"  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input id="serv_servicio_id" name="serv_servicio_id" type="hidden" value="{{ $servicio->id }}">

                                <div class="col-sm-12">
                                    <!--Procedimiento-->
                                    <div class="row mb-20">
                                        <div class="col-sm-6">
                                            <!--INV Servicios--> 
                                                <label class="control-label mb-10 text-left">Procedimiento *</label>
                                                <select class="form-control select2" id="inv_servicio_id" name="inv_servicio_id">
                                                    <option value="">Elija un Procedimiento</option>
                                                    @foreach( $tipoServicios as $key => $value )
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                        @if($itemServicio->inv_servicios_id == $key)
                                                            <option value="{{ $key }}" selected>{{ $value }}</option>
                                                        @else
                                                            <option value="{{ $key }}">{{ $value }}</option>
                                                        @endif 
                                                    @endforeach
                                                </select>

                                            <!--INV Servicios-->
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="control-label mb-10" for="valor_item">Valor Ítem</label>
                                            <input type="text" class="form-control filled-input rounded-input" id="valor_item" name="valor_item" disabled value="{{ number_format($itemServicio->valor - $itemServicio->descuento, 2, ',', '.')}}">
                                        </div>

                                    </div>
                                    <!--Accion-->
                                    <div class="row mb-20">

                                        <div class="col-sm-3">
                                            <div class="radio radio-success">
                                                @if($itemServicio->accion == "Reparar y Pintar")
                                                    <input type="radio" name="accion" id="valor_reparar_pintar" value="valor_reparar_pintar" checked>
                                                @else
                                                    <input type="radio" name="accion" id="valor_reparar_pintar" value="valor_reparar_pintar">
                                                @endif
                                                <label for="valor_reparar_pintar">Valor reparar y pintar</label>
                                            </div>                                                
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="radio radio-success">
                                                @if($itemServicio->accion == "Cambiar y Pintar")
                                                    <input type="radio" name="accion" id="valor_cambiar_pintar" value="valor_cambiar_pintar" checked>
                                                @else
                                                    <input type="radio" name="accion" id="valor_cambiar_pintar" value="valor_cambiar_pintar">
                                                @endif
                                                <label for="valor_cambiar_pintar">Valor cambiar y pintar</label>
                                            </div>                                                
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="radio radio-success">
                                                @if($itemServicio->accion == "Cambiar")
                                                    <input type="radio" name="accion" id="valor_cambiar_reparar" value="valor_cambiar_reparar" checked>
                                                @else
                                                    <input type="radio" name="accion" id="valor_cambiar_reparar" value="valor_cambiar_reparar">
                                                @endif
                                                <label for="valor_cambiar_reparar">Valor cambiar</label>
                                            </div>                                                
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="radio radio-success">
                                                @if($itemServicio->accion == "Fabricar")
                                                    <input type="radio" name="accion" id="fabricar" value="fabricar">
                                                @else
                                                    <input type="radio" name="accion" id="fabricar" value="fabricar">
                                                @endif
                                                <label for="fabricar">Valor fabricar</label>
                                            </div>                                                
                                        </div>

                                    </div>

                                    <!--Carga de imagenes-->
                                    <div class="row mb-20" >
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
                                    <!-- Row -->
                                    <div class="row mb-20">
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
                                    <!--/Carga de imagenes-->
                                    <!--Notas-->
                                    <div class="row mb-20">
                                        <div class="col-sm-12">
                                            <label class="control-label mb-10 text-left">Notas</label>
                                            <textarea class="form-control" rows="4" id="notas" name="notas">{{ $itemServicio->nota_item }}</textarea>
                                        </div>	
                                    </div>
                                </div>	

                                @include('layouts._buttonsForms') 

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /MUESTRA DATOS DEL ITEM-->

@endsection

@section('scripts')

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