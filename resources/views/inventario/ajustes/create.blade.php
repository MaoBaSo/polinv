{{-- **************************************** --}}
{{-- ***GESTION DE TRANSFERENCIAS --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Febrero de 2.022 --}}
{{-- **************************************** --}}

@extends('layouts.template')

@section('estilos')
@endsection


@section('menu')

    @include('layouts._menuAdministrador')

@endsection


@section('contenido')

    <!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Gestión de inventario</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Inventario</a></li>
                <li><a href="#"><span>INV. Ajustes</span></a></li>
                <li class="active"><span>Nuevo</span></li>
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
                        <h6 class="panel-title txt-dark">Nuevo Ajuste</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <form method="POST" action="{{ route('inventario-ajuste.store') }}">
                                @csrf
                                <input id="id_relacion" name="id_relacion" type="hidden" value="{{ $vistaProductos->id}}">

                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="producto">Producto a ajustar</label>
                                    <input type="text" class="form-control" id="producto" name="producto" disabled value="{{ $vistaProductos->nombre_producto }}">
                                </div> 
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="bodega_origen">Bodega</label>
                                    <input type="text" class="form-control" id="bodega_origen" name="bodega_origen" disabled value="{{ $vistaProductos->nombre_bodega }}">
                                </div> 

                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="bodega_origen">Cantidad disponible</label>
                                    <input type="text" class="form-control" id="cantidad_disponible" name="cantidad_disponible" disabled value="{{ $vistaProductos->cantidad_actual }}">
                                </div> 

                                <hr>

                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="documento_referencia">Numero Documento referencia *</label>
                                    <input type="text" class="form-control" id="documento_referencia" name="documento_referencia" required>
                                </div> 

                                <!--Tipo de movimiento-->
                                <div class="form-group mt-30 mb-30">
                                    <label class="control-label mb-10 text-left">Tipo Movimiento *</label>
                                    <select class="form-control" id="tipo_movimiento" name="tipo_movimiento" required>
                                        <option value="">Elija</option>
                                        <option value="+">Entrada (+)</option>
                                        <option value="-">Salida (-)</option>
                                    </select>
                                </div>                                
                                <!--Tipo de movimiento-->

                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="costo_bruto">Cantidad a ajustar *</label>
                                    <input type="number" class="form-control" id="cantidad_ajustar" name="cantidad_ajustar" required>
                                </div> 
                                
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left">Descripción del ajuste *</label>
                                    <textarea class="form-control" rows="4" id="descripcion" name="descripcion" required></textarea>
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

@endsection