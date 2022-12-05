{{-- **************************************** --}}
{{-- ***GESTION DE LINEAS --}}
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
            <h5 class="txt-dark">Gestión de productos</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Inventario</a></li>
                <li><a href="#"><span>INV. Gestión Productos</span></a></li>
                <li class="active"><span>Ver</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->

    <!-- Row Form de Rol -->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-panel card-view">
                <div class="panel-heading">

                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Ver Producto</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form>
                                <fieldset disabled>

                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left" for="nombre">Nombre de Producto *</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required value="{{ old('nombre', $producto->nombre) }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left" for="sku">SKU *</label>
                                        <input type="text" class="form-control" id="sku" name="sku" required value="{{ old('sku', $producto->sku) }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left" for="numero_parte">Nro Parte</label>
                                        <input type="text" class="form-control" id="numero_parte" name="numero_parte" value="{{ old('numero_parte', $producto->numero_parte) }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left" for="oem">OEM</label>
                                        <input type="text" class="form-control" id="oem" name="oem" value="{{ old('oem', $producto->oem) }}">
                                    </div>
                                    <!--Presentacion-->
                                    <div class="form-group mt-30 mb-30">
                                        <label class="control-label mb-10 text-left">Presentación *</label>
                                        <select class="form-control" id="presentacion_id" name="presentacion_id" required>
                                            <option value="">Elija presentación</option>
                                            @foreach( $presentacion as $key => $value )

                                                @if($producto->presentacion_id == $key)
                                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                                @else
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endif 


                                            @endforeach
                                        </select>
                                    </div>                                
                                    <!--Presentacion-->
                                    <!--Sublinea-->
                                    <div class="form-group mt-30 mb-30">
                                        <label class="control-label mb-10 text-left">Sub Línea *</label>
                                        <select class="form-control" id="sublinea_id" name="sublinea_id" required>
                                            <option value="">Elija una Sub-Línea</option>
                                            @foreach( $sublinea_pluck as $key => $value )

                                                @if($producto->sublinea_id == $key)
                                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                                @else
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endif 

                                            @endforeach
                                        </select>
                                    </div>                                
                                    <!--Sublinea-->
                                    <!--Fabricante-->
                                    <div class="form-group mt-30 mb-30">
                                        <label class="control-label mb-10 text-left">Fabricante</label>
                                        <select class="form-control" id="fabricante_id" name="fabricante_id" >
                                            <option value="">Elija Fabricante</option>
                                        </select>
                                    </div>                                
                                    <!--Fabricante-->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left" for="nombre">Factor Máximo</label>
                                        <input type="text" class="form-control" id="factor_maximo" name="factor_maximo"  value="{{ old('factor_maximo', $producto->factor_maximo) }}">
                                    </div> 
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left" for="nombre">Factor Mínimo</label>
                                        <input type="text" class="form-control" id="factor_minimo" name="factor_minimo" value="{{ old('factor_minimo', $producto->factor_minimo) }}">
                                    </div> 
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">Características</label>
                                        <textarea class="form-control" rows="4" id="caracteristicas" name="caracteristicas">{{ old('caracteristicas', $producto->caracteristicas) }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left" for="keywords">Keywords</label>
                                        <input type="text" class="form-control" id="keywords" name="keywords" value="{{ old('keywords', $producto->keywords) }}">
                                    </div>                        
        
                                </fieldset>  

                                <div class="form-group text-center">
                                    <a href="{{ url()->previous() }}" class="btn btn-warning btn-rounded btn-icon left-icon btn-sm"><i class="fa fa-hand-o-left"></i> <span>Atras</span></a>
                                </div>
                            
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