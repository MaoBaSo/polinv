{{-- **************************************** --}}
{{-- ***GESTION DE SERVICIOS --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Marzo de 2.022 --}}
{{-- **************************************** --}}

@extends('layouts.template')

@section('estilos')

    <!-- Data table CSS -->
    <link href="../vendors/bower_components/datatables/media/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>

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
            <li class="active"><span>SERV. Gestión Servicios</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->
    
    <!-- Row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="contact-list">
                            <div class="row">
                                <aside class="col-lg-2 col-md-4 pr-0">
                                    <div class="ma-15">
                                        <a href="{{ route('servicio.create') }}" type="button"  class="btn btn-orange btn-sm btn-block">
                                        <i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar Servicio
                                        </a>
                                    </div>
                                </aside>
                                
                                <aside class="col-lg-10 col-md-8 pl-0">
                                    <div class="panel pa-0">
                                    <div class="panel-wrapper collapse in">
                                    <div class="panel-body  pa-0">
                                        <div class="table-responsive mt-15 mb-15">

                                            @if($conPatio == "N")
                                                <div class="alert alert-danger alert-dismissable alert-style-1">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                        <i class="zmdi zmdi-block"></i>Usted NO tiene asignación de PATIO, por lo tanto, no podrá realizar operaciones distintas a consultar.
                                                </div>
                                                <br>
                                            @endif

                                            <table id="datable_1" class="table  display table-hover mb-30" data-page-size="10">
                                                <thead>
                                                    <tr>
                                                        <th>Fecha</th>
                                                        <th>Tipo documento</th>
                                                        <th>No.</th>
                                                        <th>Patio origen</th>
                                                        <th>Placa</th>
                                                        <th>Movil</th>
                                                        <th>Estado</th>                                                        
                                                        <th>Operaciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
 
                                                    @foreach ($servicios as $servicio)
                                                        <tr>
                                                            <td>{{ castFechaYMD($servicio->fecha_servicio) }}</td>
                                                            <td>{{ $servicio->tipo }}</td>

                                                            @switch($servicio->tipo)
                                                                @case("Valoración")
                                                                    <td>{{ $servicio->id }}</td>
                                                                    @break
                                                                @case("Orden Trabajo")
                                                                    <td>{{ $servicio->numero_orden_trabajo }}</td>
                                                                    @break
                                                                @case("Orden Compra")
                                                                    <td>{{ $servicio->numero_orden_compra }}</td>
                                                                    @break
                                                                @default
                                                                    <td>Sin Clasificación</td>
                                                            @endswitch                                                            

                                                            <td>{{ $servicio->patio->nombre }}</td>
                                                            <td>{{ $servicio->placa }}</td>
                                                            <td>{{ $servicio->movil }}</td>
                                                            <td>{{ Miscellany::getEstadoServicio($servicio->estado) }}</td>

                                                            <td><a href="{{ route('servicio.edit', $servicio->id) }}" class="text-inverse pr-10" title="Actualizar" data-toggle="tooltip">
                                                                <i class="fa fa-refresh txt-warning" style="font-size: 1.5rem;"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                </aside>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->	

@endsection

@section('scripts')

    <!-- Data table JavaScript -->
	<script src="../vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="dist/js/dataTables-data.js"></script>

@endsection