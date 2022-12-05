{{-- **************************************** --}}
{{-- ***GESTION DE SERVICIOS --}}
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
            <h5 class="txt-dark">Gestión de Servicios</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Inventario</a></li>
                <li><a href="#"><span>INV. Gestión Servicios</span></a></li>
                <li class="active"><span>Edita</span></li>
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

                    <div class="alert alert-warning alert-dismissable alert-style-1">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="zmdi zmdi-alert-circle-o"></i>ATENCIÓN, editar o eliminar servicios puede traer consecuencias negativas en el funcionamiento del aplicativo.
                    </div>

                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Editar servicios</h6>
                    </div>

                    <div class="pull-right">

                        <form action="{{ route('inventario-servicios.destroy', $servicio->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            
                            <div class="form-group text-center">
                                <button type="button" class="inline-block btn btn-danger btn-rounded btn-sm" data-toggle="modal" data-target="#confirmar" data-whatever="@getbootstrap">Eliminar Servicio</button>
                            </div>
    
                            <div class="modal fade" id="confirmar" tabindex="-1" role="dialog" aria-labelledby="confirmarLabel1">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h5 class="modal-title" id="confirmarLabel1">Confirmar proceso</h5>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Confirma la eliminación del registro?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-danger btn-rounded">Confirmar Eliminación</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <form method="POST" action="{{ route('inventario-servicios.update', $servicio->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="row mb-30">
                                            <div class="col-sm-6">
                                                <label class="control-label mb-10 text-left" for="nombre">Nombre de servicio *</label>
                                                <input type="text" class="form-control" id="nombre" name="nombre" required value="{{ old('nombre', $servicio->nombre) }}">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="control-label mb-10 text-left" for="sku">SKU *</label>
                                                <input type="text" class="form-control" id="sku" name="sku" readonly onmousedown="return false;" value="{{ old('sku', $servicio->sku) }}">
                                            </div>
                                        </div>
                                    </div>	
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="row mb-30">
                                            <div class="col-sm-6">
                                                <!--Tipo Vehículo-->
                                                <label class="control-label mb-10 text-left">Tipo vehículo *</label>
                                                <select class="form-control" id="tipo_vehiculo" name="tipo_vehiculo" required>
                                                    <option value="">Elija tipo vehículo</option>
                                                    @foreach( $tipo_vehiculo as $key => $value )
                                                        @if($servicio->tipo_vehiculo == $value)
                                                            <option value="{{ $value }}" selected>{{ $value }}</option>
                                                        @else
                                                            <option value="{{ $value }}">{{ $value }}</option>
                                                        @endif 
                                                    @endforeach
                                                </select>
                                                <!--/Tipo Vehículo-->
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="control-label mb-10 text-left" for="codigo_servicio">Código Servicio *</label>
                                                <input type="text" class="form-control" id="codigo_servicio" name="codigo_servicio" required value="{{ old('codigo_servicio', $servicio->codigo_servicio) }}">
                                            </div>
                                        </div>
                                    </div>	
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="row mb-30">
                                            <div class="col-sm-3">
                                                <label class="control-label mb-10" for="valor_reparar_pintar">Valor Reparar y pintar *</label>
                                                <input type="number" class="form-control filled-input rounded-input" id="valor_reparar_pintar" name="valor_reparar_pintar" required value="{{ old('valor_reparar_pintar', $servicio->valor_reparar_pintar) }}">
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label mb-10" for="valor_cambiar_pintar">Valor Cambiar y Pintar *</label>
                                                <input type="number" class="form-control filled-input rounded-input" id="valor_cambiar_pintar" name="valor_cambiar_pintar" required value="{{ old('valor_cambiar_pintar', $servicio->valor_cambiar_pintar) }}">
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label mb-10" for="valor_cambiar_reparar">Valor Cambiar *</label>
                                                <input type="number" class="form-control filled-input rounded-input" id="valor_cambiar_reparar" name="valor_cambiar_reparar" required value="{{ old('valor_cambiar_reparar', $servicio->valor_cambiar_reparar) }}">
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label mb-10" for="valor_fabricar">Valor Fabricar *</label>
                                                <input type="number" class="form-control filled-input rounded-input" id="valor_fabricar" name="valor_fabricar" required value="{{ old('valor_fabricar', $servicio->valor_fabricar) }}">
                                            </div>
                                        </div>
                                    </div>	
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="row mb-30">
                                            <div class="col-sm-6">
                                                <label class="control-label mb-10 text-left" for="nombre">Comisión Técnico *</label>
                                                <input type="number" class="form-control" id="valor_base_hora" name="valor_base_hora" required value="{{ old('valor_base_hora', $servicio->valor_base_hora) }}">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="control-label mb-10 text-left" for="nombre">Tiempo estandar *</label>
                                                <input type="number" step="any" class="form-control" id="tiempo_estandar" name="tiempo_estandar" required value="{{ old('tiempo_estandar', $servicio->tiempo_estandar) }}">
                                                <span>En horas, Mínimo 1 hora</span>
                                            </div>
                                        </div>
                                    </div>	
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="row mb-30">
                                            <div class="col-sm-12">
                                                <label class="control-label mb-10 text-left">Caracteristicas</label>
                                                <textarea class="form-control" rows="4" id="caracteristicas" name="caracteristicas">{{ old('caracteristicas', $servicio->caracteristicas) }}</textarea>
                                            </div>
                                        </div>
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

@endsection