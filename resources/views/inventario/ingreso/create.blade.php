{{-- **************************************** --}}
{{-- ***GESTION DE INVENTARIOS --}}
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
            <h5 class="txt-dark">Ingresar a inventario</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Inventario</a></li>
                <li><a href="#"><span>INV. Gestión Inventario</span></a></li>
                <li class="active"><span>Cargar</span></li>
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
                        <h6 class="panel-title txt-dark">Cargar Producto</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <form method="POST" action="{{ route('inventario-movimiento.store') }}">
                                @csrf

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
                                <!--Bodegas-->
                                <div class="form-group mt-30 mb-30">
                                    <label class="control-label mb-10 text-left">Bodega *</label>
                                    <select class="form-control" id="bodega_id" name="bodega_id" required>
                                        <option value="">Elija una bodega</option>
                                        @foreach( $bodegas as $key => $value )
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>                                
                                <!--Bodegas-->
                                <!--Proveedores-->
                                <div class="form-group mt-30 mb-30">
                                    <label class="control-label mb-10 text-left">Proveedor</label>
                                    <select class="form-control" id="proveedor_id" name="proveedor_id">
                                        <option value="">Elija un proveedor</option>
                                    </select>
                                </div>                                
                                <!--Proveedores-->

                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="cantidad">Cantidad a ingresar *</label>
                                    <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                                </div> 
    
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="documento_referencia">Numero Documento referencia</label>
                                    <input type="text" class="form-control" id="documento_referencia" name="documento_referencia" required>
                                </div> 

                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="vence_garantia">Vencimiento de Garantía</label>
                                    <input type="date" class="form-control" id="vence_garantia" name="vence_garantia">
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="costo_bruto">Costo Bruto *</label>
                                    <input type="number" class="form-control" id="costo_bruto" name="costo_bruto" required>
                                </div> 

                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="costo_impuesto">Valor impuesto *</label>
                                    <input type="number" class="form-control" id="costo_impuesto" name="costo_impuesto" required>
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