{{-- **************************************** --}}
{{-- ***ETAPAS TECNICAS --}}
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
            <h5 class="txt-dark">Planilla de trabajo</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Operaciones</a></li>
                <li><a href="#"><span>OPT. Gestión Operativa</span></a></li>
                <li class="active"><span>Planilla</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->

    <!-- Row Form -->
    <div class="row">
        <div class="col-sm-12">

            <!--DATOS DEL EMPLEADO-->
            <!--Primera Linea-->
            <table>
                <tbody>
                    <tr>
                        <td>Nombre: <strong>{{ $empleado->primer_nombre }} {{ $empleado->segundo_nombre }} {{ $empleado->primer_apellido }} {{ $empleado->segundo_apellido }}</strong> </td>
                        <td>Especialidad: {{ Miscellany::getParameterId($empleado->especialidad_id)->variable_1 }}</td>
                    </tr>
                </tbody>
            </table>

            <!--Segunda linea-->
            <table>
                <thead>
                    <tr>
                        <th style="width: 10%; background-color: aliceblue">Token procedimiento</th>
                        <th style="width: 10%; background-color: aliceblue">Fecha</th>
                        <th style="width: 8%; background-color: aliceblue">Movil</th>
                        <th style="width: 6%; background-color: aliceblue">Placa</th>
                        <th style="width: 8%; background-color: aliceblue">Tipo vehículo</th>
                        <th style="width: 8%; background-color: aliceblue">Orden Trabajo</th>
                        <th style="width: 34%; background-color: aliceblue">SKU</th>
                        <th style="width: 8%; background-color: aliceblue">Acción</th>
                        <th style="width: 8%; background-color: aliceblue">Actualizar</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($list_items_asignados as $item) 

                        <tr>
                            <td>{{ $item->token }}</td>
                            <td>{{ $item->fecha_servicio }}</td>
                            <td>{{ $item->movil }}</td>
                            <td>{{ $item->placa }}</td>
                            <td>{{ $item->tipo_vehiculo }}</td>
                            <td>{{ $item->numero_orden_trabajo }}</td>
                            <td>{{ $item->sku }}</td>
                            <td>{{ $item->accion }}</td>
                            <td>
                                @if($item->estado == 1)
                                    <a href="{{ route('dashboard-operaciones.state', $item->token) }}" class="btn btn-success btn-icon btn-md  btn-block"><span>Recibe</span></a>
                                @else
                                    <a href="{{ route('dashboard-operaciones.state', $item->token) }}" class="btn btn-primary btn-icon btn-md  btn-block"><span>Cierra</span></a>
                                @endif    
                            </td>
                        </tr>

                    @endforeach  

                </tbody>
            </table>

            <div class="text-center mt-10">
                <a href="{{ route('dashboard-operaciones.index') }}" class="btn btn-primary btn-icon left-icon btn-large"><i class="fa fa-hand-o-left"></i> <span>PANEL TÉCNICO</span></a>
            </div>

        </div>
    </div>
    <!-- /Row Form-->

@endsection

@section('scripts')

@endsection