{{-- **************************************** --}}
{{-- ***GESTION DE PRODUCTOS --}}
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
            <h5 class="txt-dark">Gestión de Productos</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Inventario</a></li>
            <li class="active"><span>INV. Gestión Productos</span></li>
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
                                        <a href="{{ route('inventario-productos.create') }}" type="button"  class="btn btn-orange btn-sm btn-block">
                                        <i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar Producto
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
                                                        <th>Nombre</th>
                                                        <th>sku</th>
                                                        <th>numero parte</th>
                                                        <th>oem</th>
                                                        <th>factor maximo</th>
                                                        <th>factor minimo</th>
                                                        <th>Operaciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
 
                                                    @foreach ($productos as $producto)
                                                        <tr>
                                                            <td>{{ $producto->nombre }}</td>
                                                            <td>{{ $producto->sku }}</td>
                                                            <td>{{ $producto->numero_parte }}</td>
                                                            <td>{{ $producto->oem }}</td>
                                                            <td>{{ $producto->factor_maximo }}</td>
                                                            <td>{{ $producto->factor_minimo }}</td>

                                                            <td>
                                                                <a href="{{ route('inventario-productos.show', $producto->id) }}" class="text-inverse pr-10" title="Ver" data-toggle="tooltip">
                                                                    <i class="fa fa-eye txt-warning" style="font-size: 1.5rem;"></i>
                                                                </a>
                                                                <a href="{{ route('inventario-productos.edit', $producto->id) }}" class="text-inverse pr-10" title="Editar" data-toggle="tooltip">
                                                                    <i class="fa fa-edit txt-warning" style="font-size: 1.5rem;"></i>
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
	<script src="{{ asset('vendors/bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dist/js/dataTables-data.js') }}"></script>

@endsection