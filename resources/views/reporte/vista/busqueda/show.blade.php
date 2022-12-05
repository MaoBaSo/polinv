{{-- **************************************** --}}
{{-- ***VER SERVICIO --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Abril de 2.022 --}}
{{-- **************************************** --}}

@extends('layouts.template')

@section('estilos')

    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
        * {font-family: 'Roboto', sans-serif;} 
        table {
            background-color: white;
            font-size: 12px;
            width: 100%;
            border: .2px solid rgb(121, 112, 112);
            border-collapse: collapse;
            padding: 2px;
        }
        table tr, td, th {
            border: .2px solid rgb(121, 112, 112);
            padding: 5px;
            /* Alto de las celdas */
            height: 10px;

        }
        #t-firma{font-size: 12px;}
        #t-img{font-size: 10px;}
        #t-img img{width: 300px; height: 199px;}

    </style>

@endsection


@section('menu')

    @if(Auth::user()->tipo_id == 9)
        @include('layouts._menuAdministrador')
    @elseif(Auth::user()->tipo_id == 10)
        @include('layouts._menuCliente')
    @else
        <p>No hay menu disponible</p>
    @endif

@endsection


@section('contenido')

    <!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Ver Servicio</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Servicios</a></li>
                <li><a href="#"><span>VTA. Servicios</span></a></li>
                <li class="active"><span>Ver servicio</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->

    <!-- Row Form -->
    <div class="row mb-10">
        <div class="col-sm-12">

            <div class="row mb-10">
                <div class="col-sm-2">
                    <!--imprime PDF Ctización-->
                    <form action="{{ route('reportes.valorizacion') }}" method="POST">
                        @csrf
                        <input id="servicio_id" name="servicio_id" type="hidden" value="{{ $servicio->id }}">
                        <button type="submit" class="btn btn-primary"><i class="fa  fa-file-pdf-o" style="color: aliceblue"></i>&nbsp;&nbsp;VALORIZACIÓN PDF</button>
                    </form> 
                </div>
                <div class="col-sm-2">
                    <!--imprime PDF-->
                    <form action="{{ route('reportes.rcalidad') }}" method="POST">
                        @csrf
                        <input id="servicio_id" name="servicio_id" type="hidden" value="{{ $servicio->id }}">
                        <button type="submit" class="btn btn-primary"><i class="fa  fa-file-pdf-o" style="color: aliceblue"></i>&nbsp;&nbsp;CALIDAD PDF</button>
                    </form>                     
                </div>
                <div class="col-sm-8"></div>
            </div>

        </div>
    </div>

    <!-- Row Form -->
    <div class="row">
        <div class="col-sm-12">
            <!--DATOS DE CLIENTE Y NUMERO DE VALORIZACION-->
            <!--Primera Linea-->
            <table>
                <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Patio</th>
                    <th>Tipo Vehículo</th>
                    <th>Fecha</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>{{ $servicio->cliente->nombre }}</th>
                    <td>{{ $servicio->patio->nombre }}</td>
                    @if(!is_null($tipo_vehiculo->tipo_vehiculo))
                        <td>{{ $tipo_vehiculo->tipo_vehiculo }}</td>
                    @else
                        <td></td>
                    @endif
                    <td>{{ $servicio->fecha_servicio }}</td>    

                </tr>
                </tbody>
            </table>
            <!--Segunda Linea-->
            <table>
                <thead>
                    <tr>
                        <th>Movil</th>
                        <th>Placa</th>
                        <th>#Cotización</th>
                        <th>#Orden Trabajo</th>
                        <th>#Orden Compra</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>{{ $servicio->movil }}</th>
                        <td>{{ $servicio->placa }}</td>
                        <td>{{ $servicio->id }}</td>
                        <td>{{ $servicio->numero_orden_trabajo }}</td>
                        <td>{{ $servicio->numero_orden_compra }}</td>
                        
                    </tr>
                </tbody>
            </table>
            <!--ITEMS Y VALORIZACION-->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo Procedimiento</th>
                        <th>Bruto</th>
                        <th>Desc.</th>
                        <th>Neto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $cont_id = 10;
                    ?>
                    @foreach ($items_servicio as $item)  
                        <tr>
                            <td>{{ $cont_id }}</td>
                            <td>{{ $item->invServicio->sku . ' (' . $item->accion . ') (' .$item->invServicio->nombre . ')' }}</td>
                            <td>{{ number_format($item->valor)}}</td>
                            <td>{{ number_format($item->descuento)}}</td>
                            <td>{{ number_format($item->valor - $item->descuento)}}</td>
                        </tr>
                        <?php 
                            $cont_id += 10;
                        ?>
                    @endforeach            

                    <tr>
                        <td style="text-align: right; height: 10px !important;" colspan="2">Sub-Totales</td>
                        <td><b>{{ number_format($servicio->valor_bruto_procedimiento) }}</b></td>
                        <td><b>{{ number_format(Miscellany::getDescServicio($servicio->id)) }}</b></td>
                        <td><b>{{ number_format(Miscellany::getValServicio($servicio->id)) }}</b></td>
                    </tr>
                    <tr>
                        <td style="text-align: right;" colspan="4">Valor IVA</td>
                        <td>{{ $val_iva }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: right;" colspan="4">Valor NETO</td>
                        <td>{{ number_format(Miscellany::getValServicio($servicio->id) + $val_iva) }}</td>
                    </tr>
                </tbody>
            </table>
            <!--FIRMA-->
            <table>
                <thead>
                    <tr>
                        <th>Aprobado por:</th>
                        <th>Creado por:</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @if(!is_null($autorizado_por))
                            <td style="width: 50%">{{ $autorizado_por->name }} <br> {{ $autorizado_por->email }}</td>    
                        @else
                            <td>Sin Firma Electrónica <br> Busque Original firmado </td>
                        @endif
                        <td style="width: 50%">{{ $creado_por->name }} <br> {{ $creado_por->email }}</td>
                    </tr>

                    @if(!is_null($autorizado_por))

                        <tr>
                            <td colspan="2" style="background-color: aliceblue">TOKEN: {{ $firma->firma }}</td>
                        </tr>                        
                    @endif

                </tbody>
            </table>
            <!--GESTION DE IMAGENES-->                
            <table id="t-img">
                <thead></thead>
                <tbody>

                    <table id="t-img">
                        <thead></thead>
                        <tbody>
        
                            @foreach ($items_servicio as $item)
        
                                <!--Actualizacion OT: 090722-003 -->
                                @if($item->cant_img == 0)

                                    <!--Si contador es igual a 0, nueva rutina de imagenes-->                                
                                    <!-- Row -->
                                    <div class="row mt-20" style="padding-left: .5%; padding-right: .5%;">
                                        <div class="col-md-12">
                                            <div class="panel panel-default card-view">
                                                <div class="panel-heading">
                                                    <div class="pull-left">
                                                        <h6 class="panel-title txt-dark">{{ $item->invServicio->sku }}</h6>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="panel-wrapper collapse in">
                                                    <div class="panel-body">
                                                        
                                                        <div class="gallery-wrap">
                                                            <div class="portfolio-wrap project-gallery">
                                                                <ul id="portfolio_1" class="portf auto-construct  project-gallery" data-col="4">
                                                                    <?php 
                                                                        $newImages = getListImgItem($item->id);
                                                                        $cant_img = $newImages->count();
                                                                    ?>

                                                                    @foreach($newImages as $imagen)

                                                                        <li class="item" data-src="{{ asset($imagen->url . $imagen->nombre_archivo) }}" data-sub-html="<h6>{{$servicio->placa}}</h6><p>Imagen del ítem.</p>">
                                                                            <a href="">
                                                                            <img class="img-responsive" src="{{ asset($imagen->url . $imagen->nombre_archivo) }}"  alt="Image description" />	
                                                                            <span class="hover-cap">{{$servicio->placa}}</span>
                                                                            </a>
                                                                        </li>
                                        
                                                                    @endforeach  
                                                                    
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Row -->  
        
                                @else
                                            
                                    <!-- Row -->
                                    <div class="row mt-20" style="padding-left: .5%; padding-right: .5%;">
                                        <div class="col-md-12">
                                            <div class="panel panel-default card-view">
                                                <div class="panel-heading">
                                                    <div class="pull-left">
                                                        <h6 class="panel-title txt-dark">{{ $item->invServicio->sku }}</h6>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="panel-wrapper collapse in">
                                                    <div class="panel-body">
                                                        
                                                        <div class="gallery-wrap">
                                                            <div class="portfolio-wrap project-gallery">
                                                                <ul id="portfolio_1" class="portf auto-construct  project-gallery" data-col="4">
                                                                    <?php 
                                                                        $cont = 1;
                                                                    ?>
                                                                    @foreach(range(1,$item->cant_img) as $current)
                                                                        
                                                                        <li class="item" data-src="{{ asset('imgservices/'. $servicio->cliente_id .'/'. $item->id .'-'. $cont .'.jpeg') }}" data-sub-html="<h6>{{$servicio->placa}}</h6><p>Imagen del ítem.</p>">
                                                                            <a href="">
                                                                            <img class="img-responsive" src="{{ asset('imgservices/'. $servicio->cliente_id .'/'. $item->id .'-'. $cont .'.jpeg') }}"  alt="Image description" />	
                                                                            <span class="hover-cap">{{$servicio->placa}}</span>
                                                                            </a>
                                                                        </li>
                                                                        <?php 
                                                                            $cont++;
                                                                        ?>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Row --> 

                                @endif
                                <!--/Actualizacion OT: 090722-003 -->  
        
                            @endforeach 
        
                        </tbody>
                    </table>                    


                </tbody>
            </table>

        </div>
    </div>
    <!-- /Row Form-->

@endsection

@section('scripts')

    <!-- Gallery JavaScript -->
    <script src="{{ asset('dist/js/isotope.js') }}"></script>
    <script src="{{ asset('dist/js/lightgallery-all.js') }}"></script>
    <script src="{{ asset('dist/js/froogaloop2.min.js') }}"></script>
    <script src="{{ asset('dist/js/gallery-data.js') }}"></script>


@endsection