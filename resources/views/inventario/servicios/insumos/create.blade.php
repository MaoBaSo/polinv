{{-- **************************************** --}}
{{-- ***GESTION DE INSUMOS --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Febrero de 2.022 --}}
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
            <h5 class="txt-dark">Gestión de Servicios</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Inventario</a></li>
                <li><a href="#"><span>INV. Gestión Servicios</span></a></li>
                <li class="active"><span>Nuevo insumo</span></li>
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
                            <h6 class="panel-title txt-dark">Lista de insumos requeridos</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="form-wrap">

                                <table id="datable_1" class="table table-hover display  pb-30">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Cantidad</th>
                                            <th>Presentación</th>
                                            <th>Costo neto</th>
                                            <th>Nota</th>
                                            <th>Operaciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($InvInsumos as $insumo)
                                            <tr>
                                                <td>{{ $insumo->nombre }}</td>
                                                <td>{{ $insumo->cantidad }}</td>
                                                <td>{{ $insumo->presentacion }}</td>
                                                <td>{{ $insumo->costo_neto }}</td>
                                                <td>{{ $insumo->nota }}</td>
                                                <td>
                                                    <form action="{{ route('inventario-insumos.destroy', $insumo->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-block btn btn-danger btn-rounded btn-xs">Eliminar Insumo</button>
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
                            <h6 class="panel-title txt-dark">Nuevo Insumo</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="form-wrap">

                                <form method="POST" action="{{ route('inventario-insumos.store') }}">
                                    @csrf
                                    <input id="servicio_id" name="servicio_id" type="hidden" value="{{ $servicio_id }}">

                                    <!--Productos-->
                                    <div class="form-group mt-30 mb-30">
                                        <label class="control-label mb-10 text-left">Producto *</label>
                                        <select class="form-control" id="producto_id" name="producto_id" required>
                                            <option value="">Elija un producto</option>
                                            @foreach( $productos as $key => $value )
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>                                
                                    <!--Productos-->

                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left" for="cantidad">Cantidad *</label>
                                        <input type="number" step="any" class="form-control" id="cantidad" name="cantidad" required>
                                    </div> 
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left" for="costo_neto">Costo neto</label>
                                        <input type="number" class="form-control" id="costo_neto" name="costo_neto" required>
                                    </div> 
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">Notas</label>
                                        <textarea class="form-control" rows="4" id="notas" name="notas"></textarea>
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