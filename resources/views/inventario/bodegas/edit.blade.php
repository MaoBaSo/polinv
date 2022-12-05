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
            <h5 class="txt-dark">Gestión de Bodegas</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Inventario</a></li>
                <li><a href="#"><span>INV. Gestión Bodegas</span></a></li>
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
                        <i class="zmdi zmdi-alert-circle-o"></i>ATENCIÓN, editar o eliminar Bodegas puede traer consecuencias negativas en el funcionamiento del aplicativo.
                    </div>

                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Editar Bodega</h6>
                    </div>
                    <div class="pull-right">
                        <form action="{{ route('inventario-bodegas.destroy', $bodega->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            
                            <div class="form-group text-center">
                                <button type="button" class="inline-block btn btn-danger btn-rounded btn-sm" data-toggle="modal" data-target="#confirmar" data-whatever="@getbootstrap">Eliminar Bodega</button>
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

                            <form method="POST" action="{{ route('inventario-bodegas.update', $bodega->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="nombre">Nombre de Bodega *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required value="{{ old('nombre', $bodega->nombre) }}">
                                </div>
                                <!--Ciudad-->
                                <div class="form-group mt-30 mb-30">
                                    <label class="control-label mb-10 text-left">Ciudad *</label>
                                    <select class="form-control" id="ciudad_id" name="ciudad_id" required>
                                        <option value="">Elija una ciudad</option>
                                        @foreach( $ciudades as $key => $value )
                                            @if($bodega->ciudad_id == $key)
                                                <option value="{{ $key }}" selected>{{ $value }}</option>
                                            @else
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endif 
                                        @endforeach
                                    </select>
                                </div>                                
                                <!--Ciudad-->
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="nombre">Direccion</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion', $bodega->direccion) }}">
                                </div>                                
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="nombre">Referencia Direccion</label>
                                    <input type="text" class="form-control" id="referencia_direccion" name="referencia_direccion" value="{{ old('referencia_direccion', $bodega->referencia_direccion) }}">
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left">Notas</label>
                                    <textarea class="form-control" rows="4" id="notas" name="notas">{{ old('notas', $bodega->notas) }}</textarea>
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