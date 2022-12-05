{{-- **************************************** --}}
{{-- ***BUSQUEDA --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Abril de 2.022 --}}
{{-- **************************************** --}}

@extends('layouts.template')

@section('estilos')

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
            <h5 class="txt-dark">Buscar Servicios</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Buscar</a></li>
                <li><a href="#"><span>Servicios</span></a></li>
                <li class="active"><span>Filtros</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default border-panel card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Elija filtro de busqueda</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <!--imprime PDF-->
                            <form action="{{ route('buscar.servicios') }}" method="POST">
                                @csrf

                                <div class="row mb-10">
                                    <div class="col-sm-6">
                                        <label for="fecha_desde">Fecha desde:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                            <input class="form-control" name="fecha_desde" type="date" value="{{ date('d-m-Y') }}" id="fecha_desde">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="fecha_hasta">Fecha hasta:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                            <input class="form-control" name="fecha_hasta" type="date" value="{{ date('d-m-Y') }}" id="fecha_hasta">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-10">
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="numero_cotizacion"># Valoración</label>
                                        <input type="text" class="form-control" id="numero_cotizacion" name="numero_cotizacion">

                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="numero_orden_trabajo"># Orden de Trabajo</label>
                                        <input type="text" class="form-control" id="numero_orden_trabajo" name="numero_orden_trabajo">
                                    </div>

                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="numero_orden_compra"># Orden de Compra</label>
                                        <input type="text" class="form-control" id="numero_orden_compra" name="numero_orden_compra">
                                    </div>
                                </div>

                                <div class="row mb-20">
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="numero_movil"># Movil</label>
                                        <input type="text" class="form-control" id="numero_movil" name="numero_movil">

                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="numero_placa"># Placa</label>
                                        <input type="text" class="form-control" id="numero_placa" name="numero_placa">
                                    </div>
                                </div>
                            
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary btn-rounded btn-icon left-icon btn-sm"><i class="fa fa-thumbs-o-up"></i> <span>Buscar</span></button>
                                </div>
                            </form> 

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->

@endsection

@section('scripts')


@endsection