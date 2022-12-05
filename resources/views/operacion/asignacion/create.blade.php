{{-- **************************************** --}}
{{-- ***GESTION DE SERVICIOS VS EMPLEADOS --}}
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

    @include('layouts._menuAdministrador')

@endsection


@section('contenido')

    <!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Gestión Operativa</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Operativa</a></li>
                <li><a href="#"><span>OPT. Asignar servicios</span></a></li>
                <li class="active"><span>Asignar</span></li>
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
                    <th>Orden Trabajo</th>
                    <th>Fecha</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>{{ $servicio->cliente->nombre }}</th>
                    <td>{{ $servicio->patio->nombre }}</td>
                    <td>{{ $servicio->placa }}</td>
                    <td>{{ $servicio->numero_orden_trabajo }}</td>
                    <td>{{ $servicio->fecha_servicio }}</td>
                </tr>
                </tbody>
            </table>
            <!--ITEMS Y VALORIZACION-->
            <table>
                <thead>
                    <tr>
                        <th>Tipo Procedimiento</th>
                        <th>Comisión Técnico</th>
                        <th>% Asignado</th>
                        <th>Asignar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items_servicio as $item)  
                        <tr>
                            <td>{{ $item->invServicio->sku . ' (' . $item->accion . ') (' .$item->invServicio->nombre . ')' }}</td>
                            <td>{{ number_format($item->invServicio->valor_base_hora) }}</td>
                            <td>{{ getCostoItem($item->id) }} %</td>
                            <td class="text-center">
                                <a href="{{ route('operacion.asigna', $item->id) }}" class="text-inverse pr-10" title="Agignación" data-toggle="tooltip">
                                    <i class="fa fa-users txt-primary" style="font-size: 1.5rem;"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach            
                </tbody>
            </table>

            <div class="form-group text-center mt-10">
                <a href="{{ url()->previous() }}" class="btn btn-warning btn-icon left-icon btn-sm"><i class="fa fa-hand-o-left"></i> <span>Atras</span></a>
                <a href="{{ route('operacion-state.update', $servicio->id) }}"><button class="btn btn-primary btn-icon left-icon btn-sm"><i class="fa fa-thumbs-o-up"></i> <span>Procesar</span></button></a>
            </div>

        </div>
    </div>
    <!-- /Row Form-->

@endsection

@section('scripts')

@endsection