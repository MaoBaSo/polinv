{{-- **************************************** --}}
{{-- ***GESTION DE UBICACIONES --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Junio de 2.022 --}}
{{-- **************************************** --}}

@extends('layouts.template')

@section('estilos')

<!-- Data table CSS -->
<link href="{{ asset('vendors/bower_components/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('menu')

    @include('layouts._menuAdministrador')

@endsection


@section('contenido')

    <!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Gestión de Ubicaciones</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Clientes</a></li>
                <li><a href="#"><span>CLI. Gestión Ubicaciones</span></a></li>
                <li class="active"><span>Ubicaciones</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->

    <!-- Row Form -->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-panel card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Lista de ubicaciones de Cliente</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <table id="datable_1" class="table table-hover display  pb-30">
                                <thead>
                                    <tr>
                                        <th>Fecha Creación</th>
                                        <th>Patio</th>
                                        <th>Dirección</th>
                                        <th>Bodega</th>
                                        <th>Operaciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($ubicaciones as $ubicacion)
                                        <tr>
                                            <td>{{ $ubicacion->fecha_creacion_patio }}</td>
                                            <td>{{ $ubicacion->nombre_patio }}</td>
                                            <td>{{ $ubicacion->direccion }}</td>
                                            <td>{{ $ubicacion->nombre_bodega }}</td>
                                            <td>
                                                <form action="{{ route('ubicaciones.destroy', $ubicacion->patios_id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-block btn btn-danger btn-rounded btn-xs">Eliminar Ubicación</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row Form-->

    <!-- Row Form -->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-panel card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Nueva Ubicación</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <form method="POST" action="{{ route('ubicaciones.store') }}">
                                @csrf
                                <input id="cliente_id" name="cliente_id" type="hidden" value="{{ $cliente_id }}">

                                <div class="row mb-15">
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="nombre_ubicacion">Nombre Ubicación *</label>
                                        <input type="text" class="form-control" id="nombre_ubicacion" name="nombre_ubicacion" required value="{{ old('nombre_ubicacion') }}">                                               
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="direccion">Dirección *</label>
                                        <input type="direccion" class="form-control" id="direccion" name="direccion" required value="{{ old('direccion') }}">
                                    </div>
                                    <div class="col-sm-4">
                                        <!--Bodega-->
                                        <label class="control-label mb-10 text-left">Bodega *</label>
                                        <select class="form-control" id="bodega_id" name="bodega_id" required>
                                            <option value="">Elija una bodega</option>
                                            @foreach( $bodegas as $key => $value )
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <!--Bodega-->
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
    <!-- /Row Form-->

@endsection

@section('scripts')

	<!-- Data table JavaScript -->
	<script src="{{ asset('vendors/bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dist/js/dataTables-data.js') }}"></script>


@endsection