{{-- **************************************** --}}
{{-- ***VISTA Y FIRMA DE VALORACIÓN --}}
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

    @include('layouts._menuCliente')

@endsection


@section('contenido')

    <!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Gestión de Servicios Online</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Servicios</a></li>
                <li><a href="#"><span>SERV. Servicios</span></a></li>
                <li class="active"><span>Autorizar Versión 1</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->

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
                    <th>Placa</th>
                    <th>Valorización</th>
                    <th>Fecha</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>{{ $servicio->cliente->nombre }}</th>
                    <td>{{ $servicio->patio->nombre }}</td>
                    <td>{{ $servicio->placa }}</td>
                    <td>No. {{ $servicio->id }}</td>
                    <td>{{ $servicio->created_at->format('d-m-Y') }}</td>
                </tr>
                </tbody>
            </table>
            <!--Segunda Linea-->
            <table>
                <thead>
                    <tr>
                        <th>Movil</th>
                        <th>Tipo Vehículo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>{{ $servicio->movil }}</th>
                        <td>{{ $tipo_vehiculo->tipo_vehiculo }}</td>
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
                        <th>Firma Aprobador:</th>
                        <th>Generado por:</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width: 50%">{{ Auth::user()->name }} <br> {{ Auth::user()->email }}</td>
                        <td style="width: 20%">
                            <form method="POST" action="{{ route('firma-proceso.store') }}">
                                @csrf
                                <input id="servicio_id" name="servicio_id" type="hidden" value="{{ $servicio->id }}">
                                <input id="valor_bruto_procedimiento" name="valor_bruto_procedimiento" type="hidden" value="{{ $servicio->valor_bruto_procedimiento }}">
                                <input id="movil" name="movil" type="hidden" value="{{ $servicio->movil }}">
                                <input id="fecha_servicio" name="fecha_servicio" type="hidden" value="{{ $servicio->fecha_servicio }}">

                                <div class="form-group text-center">
                                    <button type="button" class="inline-block btn btn-primary btn-sm" data-toggle="modal" data-target="#confirmar" data-whatever="@getbootstrap"><i class="fa fa-key"></i>&nbsp;&nbsp;FIRMAR</button>
                                </div>
        
                                <div class="modal fade" id="confirmar" tabindex="-1" role="dialog" aria-labelledby="confirmarLabel1">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h5 class="modal-title text-primary" id="confirmarLabel1"><i class="fa fa-certificate"></i> Autorizar Valoración</h5>
                                            </div>
                                            <div class="modal-body">
                                                <p> <strong>ATENCION</strong>: Este proceso de firma electrónica tiene la misma validez de la firma física, acepta los términos, procedimientos y valores que figuran en la valorización y convierte el documento en una orden de trabajo. </p>
                                                <br>
                                                <div class="form-group">
                                                    <label class="control-label mb-10 text-left" for="numero_orden_trabajo">Orden Trabajo Asignada *</label>
                                                    <input type="text" class="form-control" id="numero_orden_trabajo" name="numero_orden_trabajo" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label mb-10 text-left" for="token">TOKEN *</label>
                                                    <input type="password" class="form-control" id="token" name="token" required>
                                                    <span>Versión 1</span>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">FIRMAR</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </td>
                        <td style="width: 30%">{{ $user_creator->name }} <br> {{ $user_creator->email }}</td>
                    </tr>            
                </tbody>
            </table>
            <!--GESTION DE IMAGENES-->                
            <table id="t-img">
                <thead></thead>
                <tbody>

                    @foreach ($items_servicio as $item)

                        <!--Actualizacion OT: 090722-003 -->
                        @if($item->cant_img == 0)

                            <?php 
                                $cont = 1;
                                $newImages = getListImgItem($item->id);
                                $cant_img = $newImages->count();
                            ?>

                            <!--Si contador es igual a 0, nueva rutina de imagenes-->
                            @foreach($newImages as $imagen)
                                <?php
                                    if($cont == 3){
                                        $cont = 1;
                                    } 
                                ?>
                                    
                                @if($cont == 1)
                                    <tr>
                                        <td>
                                            <p>{{  $item->invServicio->sku}}</p>                  
                                            <img class="img-responsive" src="{{ asset($imagen->url . $imagen->nombre_archivo) }}"  alt="Image description" />  
                                        </td>
                                @else
                                        <td>
                                            <p>{{  $item->invServicio->sku}}</p>                  
                                            <img class="img-responsive" src="{{ asset($imagen->url . $imagen->nombre_archivo) }}"  alt="Image description" />  
                                        </td> 
                                    </tr>                           
                                @endif

                                <?php 
                                    $cont++;
                                ?>

                                @if($cant_img == 1)
                                    </tr> 
                                @endif

                            @endforeach  

                        @else

                            <tr>
                                <td>

                                    <?php 
                                        $cont = 1;
                                    ?>
                                    <p>{{ $item->invServicio->sku }}</p>
                                    <br>
                                    @foreach(range(1,$item->cant_img) as $current)
                                            <img src="{{ asset('imgservices/'. $servicio->cliente_id .'/'. $item->id .'-'. $cont .'.jpeg') }}" alt="">
                                        <?php 
                                            $cont++;
                                        ?>
                                    @endforeach  
                                                
                                </td> 
                            </tr>                     

                        @endif
                        <!--/Actualizacion OT: 090722-003 -->  

                    @endforeach 

                </tbody>
            </table>
        </div>
    </div>
    <!-- /Row Form-->

@endsection

@section('scripts')

@endsection