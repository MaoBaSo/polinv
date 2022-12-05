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
                <li><a href="#"><span>INV. Transferencias</span></a></li>
                <li class="active"><span>Nueva</span></li>
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
                        <h6 class="panel-title txt-dark">Nueva Transferencia</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <form method="POST" action="{{ route('inventario-transferencia.store') }}">
                                @csrf
                                <input id="id_relacion" name="id_relacion" type="hidden" value="{{ $vistaProductos->id }}">

                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="producto">Producto a transferir</label>
                                    <input type="text" class="form-control" id="producto" name="producto" disabled value="{{ $vistaProductos->nombre_producto }}">
                                </div> 
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="bodega_origen">Bodega Origen</label>
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
                                <!--Bodegas-->
                                <div class="form-group mt-30 mb-30">
                                    <label class="control-label mb-10 text-left">Bogeda destino *</label>
                                    <select class="form-control" id="bodega_destino" name="bodega_destino" required>
                                        <option value="">Elija una bodega</option>
                                        @foreach( $bodegas as $key => $value )
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>                                
                                <!--Bodegas-->

                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="costo_bruto">Cantidad a transferir *</label>
                                    <input type="number" class="form-control" id="cantidad_transferir" name="cantidad_transferir" required>
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

@endsection