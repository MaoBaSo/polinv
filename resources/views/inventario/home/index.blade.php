{{-- **************************************** --}}
{{-- ***HOME INVENTARIOS --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Febrero de 2.022 --}}
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
            <h5 class="txt-dark">Gestión de Inventarios</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Inventario</a></li>
            <li class="active"><span>INV. Gestión Inventarios</span></li>
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
                                        <a href="{{ route('inventario-movimiento.create') }}" type="button"  class="btn btn-orange btn-sm btn-block">
                                        <i class="fa fa-plus"></i>&nbsp;&nbsp;Ingresar Producto
                                        </a>
                                    </div>                                   
                                </aside>
                                
                                <aside class="col-lg-10 col-md-8 pl-0">
                                    <div class="panel pa-0">
                                    <div class="panel-wrapper collapse in">
                                    <div class="panel-body  pa-0">
                                        <div class="table-responsive mt-15 mb-15">

                                            <table id="datable_1" class="table table-hover display  pb-30">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre Producto</th>
                                                        <th>sku</th>
                                                        <th>numero parte</th>
                                                        <th>oem</th>
                                                        <th>nombre_bodega</th>
                                                        <th>cantidad actual</th>
                                                        <th>operaciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
 
                                                    @foreach ($productos as $producto)
                                                        <tr>
                                                            <td>{{ $producto->nombre_producto }}</td>
                                                            <td>{{ $producto->sku }}</td>
                                                            <td>{{ $producto->numero_parte }}</td>
                                                            <td>{{ $producto->oem }}</td>
                                                            <td>{{ $producto->nombre_bodega }}</td>
                                                            <td>{{ $producto->cantidad_actual }}</td>
                                                            <td>
                                                                <a href="{{ route('inventario-transferencia.createwid',$producto->id ) }}" class="text-inverse pr-10" title="Transferir" data-toggle="tooltip">
                                                                    <i class="fa fa-exchange txt-warning" style="font-size: 1.5rem;"></i>
                                                                </a>
                                                                <a href="{{ route('inventario-ajuste.createwid',$producto->id ) }}" class="text-inverse pr-10" title="Ajustar" data-toggle="tooltip">
                                                                    <i class="fa fa-wrench txt-warning" style="font-size: 1.5rem;"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>

                                            {!! $productos->links() !!}

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