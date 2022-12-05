{{-- **************************************** --}}
{{-- ***GESTION DE ITEMS --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Marzo de 2.022 --}}
{{-- **************************************** --}}

@extends('layouts.template')

@section('estilos')
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
                <li class="active"><span>Gestión</span></li>
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
                        <h6 class="panel-title txt-dark">Gestión Ítem</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form>
                                <fieldset disabled>
                                    <div class="form-group mb-10">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <!--INV Servicios--> 
                                                        <label class="control-label mb-10 text-left">Procedimiento edit*</label>
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
                                        </div>	
                                    </div>

                                    <!--Carga de imagenes-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel panel-default card-view">
                                                <div class="panel-heading">
                                                    <div class="pull-left">
                                                        <h6 class="panel-title txt-dark">Imagenes</h6>
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
                                                                            
                                                                            <li class="item" data-src="{{ asset($imagen->url . $imagen->nombre_archivo) }}" data-sub-html="<h6>{{$servicio->placa}}</h6><p>Imagen del ítem.</p>">
                                                                                <a href="">
                                                                                <img class="img-responsive" src="{{ asset($imagen->url . $imagen->nombre_archivo) }}"  alt="Image description" />	
                                                                                <span class="hover-cap">{{$servicio->placa}}</span>
                                                                                </a>
                                                                            </li>
                                                                        @endforeach                                                                        

                                                                    @else
                                                                        <!--Si el contador de imagenes tiene numero > 0, antes de actualizacion -->
                                                                        <?php 
                                                                            $cont = 1;
                                                                        ?>
                                                                        @foreach(range(1,$itemServicio->cant_img) as $current)
                                                                            
                                                                            <li class="item" data-src="{{ asset('imgservices/'. $servicio->cliente_id .'/'. $itemServicio->id .'-'. $cont .'.jpeg') }}" data-sub-html="<h6>{{$servicio->placa}}</h6><p>Imagen del ítem.</p>">
                                                                                <a href="">
                                                                                <img class="img-responsive" src="{{ asset('imgservices/'. $servicio->cliente_id .'/'. $itemServicio->id .'-'. $cont .'.jpeg') }}"  alt="Image description" />	
                                                                                <span class="hover-cap">{{$servicio->placa}}</span>
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
                                    <!--/Carga de imagenes-->

                                    <div class="form-group mb-10">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label class="control-label mb-10 text-left">Notas</label>
                                                    <textarea class="form-control" rows="4" id="notas" name="notas">{{ $itemServicio->nota_item }}</textarea>
                                                </div>
                                            </div>
                                        </div>	
                                    </div>
                                </fieldset>  
                                <div class="form-group text-center mt-15">
                                    <a href="{{ url()->previous() }}" class="btn btn-warning btn-rounded btn-icon left-icon btn-sm"><i class="fa fa-hand-o-left"></i> <span>Atras</span></a>
                                </div>
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

@endsection