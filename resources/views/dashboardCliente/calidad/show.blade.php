{{-- **************************************** --}}
{{-- ***VISTA Y FIRMA DE CALIDAD --}}
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
            <h5 class="txt-dark">Gestión de Calidad Online</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Servicios</a></li>
                <li><a href="#"><span>OPT. Calidad</span></a></li>
                <li class="active"><span>Autorizar Versión 1</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->

    <!--DATOS DE CLIENTE Y NUMERO DE OT-->
    <!--Primera Linea-->
    <table>
        <thead>
          <tr>
            <th>Cliente</th>
            <th>Patio</th>
            <th>Placa</th>
            <th>Orden trabajo</th>
            <th>Fecha</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>{{ $servicio->cliente->nombre }}</th>
            <td>{{ $servicio->patio->nombre }}</td>
            <td>{{ $servicio->placa }}</td>
            <td>No. {{ $servicio->numero_orden_trabajo }}</td>
            <td>{{ $servicio->fecha_servicio }}</td>
          </tr>
        </tbody>
      </table>



    <!--Segunda Linea-->
    <table>
        <thead>
            <tr>
                <th>Movil</th>
                <th>Tipo Vehículo</th>
                <th>Inicio de proceso</th>
                <th>Fin de proceso</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>{{ $servicio->movil }}</th>
                <td>{{ $tipo_vehiculo->tipo_vehiculo }}</td>
                <td>{{ $tiempo_inicio->tiempo_inicio }}</td>
                <td>{{ $tiempo_fin->tiempo_fin }}</td>
            </tr>
        </tbody>
    </table>
    <!--ITEMS-->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo Procedimiento</th>
                <th>Verificado</th>
                <th>Pasa</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $cont_id = 10;
            ?>
            @foreach ($items_servicio as $item)
                <tr>
                    <td>{{ $cont_id }}</td>
                    <td>{{ $item->sku . ' (' . $item->accion . ') (' .$item->nombre . ')' }}</td>
                    <td>{{ Cerbero::getUserId($item->creado_por)->name }}</td>
                    <td>OK</td>
                </tr>
            <?php 
              $cont_id += 10;
            ?>                
            @endforeach            

        </tbody>
    </table>
    <!--FIRMA-->
    <table>
        <thead>
            <tr>
                <th>Recibido por:</th>
                <th>Firma</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ Auth::user()->name }} <br> {{ Auth::user()->email }}</td>
                <td style="width: 30%">
                
                    <form method="POST" action="{{ route('firma.calidad') }}">
                        @csrf
                        <input id="servicio_id" name="servicio_id" type="hidden" value="{{ $servicio->id }}">
                        <div class="form-group text-center">
                            <button type="button" class="inline-block btn btn-primary btn-sm" data-toggle="modal" data-target="#confirmar" data-whatever="@getbootstrap"><i class="fa fa-key"></i>&nbsp;&nbsp;FIRMAR</button>
                        </div>

                        <div class="modal fade" id="confirmar" tabindex="-1" role="dialog" aria-labelledby="confirmarLabel1">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h5 class="modal-title text-primary" id="confirmarLabel1"><i class="fa fa-certificate"></i> Autorizar recepción</h5>
                                    </div>
                                    <div class="modal-body">
                                        <p> <strong>ATENCION</strong>: Este proceso de firma electrónica tiene la misma validez de la firma física, acepta a satisfacción el trabajo y cierra la orden de trabajo. </p>
                                        <br>
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
                        $newImages = getListImgQA($item->id);
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
                                    <p>{{  $item->sku}}</p>                  
                                    <img class="img-responsive" src="{{ asset($imagen->url . $imagen->nombre_archivo) }}"  alt="Image description" />  
                                </td>
                        @else
                                <td>
                                    <p>{{  $item->sku}}</p>                  
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


@endsection

@section('scripts')

@endsection