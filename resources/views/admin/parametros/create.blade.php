{{-- **************************************** --}}
{{-- ***Panel de SUPER USUARIO / Crear nuevo Permiso --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Septiembre de 2.021 --}}
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
            <h5 class="txt-dark">Gestión de Parámetros</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="index.html">Sistema</a></li>
            <li><a href="#"><span>CONF. Gestión Parámetros</span></a></li>
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
                        <h6 class="panel-title txt-dark">Nuevo Parámetro</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <form method="POST" action="{{ route('gestion-parametros.store') }}">
                                @csrf

                                <div class="row mb-30">
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="key">Key</label>
                                        <input type="text" class="form-control rounded-input" id="key" name="key" required>
                                        <span class="help-block mt-10 mb-0"><small>Nombre de parámetro | Requerido</small></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="descripcion">Descripción</label>
                                        <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                                        <span class="help-block mt-10 mb-0"><small>Requerido</small></span>
                                    </div>
                                </div>

                                <div class="row mb-30">
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="modulos">Modulo</label>
                                        <input type="text" class="form-control" id="modulos" name="modulos">
                                        <span class="help-block mt-10 mb-0"><small>Módulos afectados</small></span>
                                    </div>  

                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="relacion ">Relación</label>
                                        <input type="text" class="form-control" id="relacion " name="relacion ">
                                        <span class="help-block mt-10 mb-0"><small>Relación con otro parámetro</small></span>
                                    </div>
                                </div>

                                <div class="row mb-30">
                                    <div class="col-sm-3">
                                        <label class="control-label mb-10 text-left" for="variable_1">Variable 1</label>
                                        <input type="text" class="form-control filled-input" id="variable_1" name="variable_1" required>
                                        <span class="help-block mt-10 mb-0"><small>Requerido</small></span>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label mb-10 text-left" for="variable_2">Variable 2</label>
                                        <input type="text" class="form-control filled-input" id="variable_2" name="variable_2">
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label mb-10 text-left" for="variable_3">Variable 3</label>
                                        <input type="text" class="form-control filled-input" id="variable_3" name="variable_3">
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label mb-10 text-left" for="variable_4">Variable 4</label>
                                        <input type="text" class="form-control filled-input" id="variable_4" name="variable_4">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="script">Script</label>
                                    <textarea class="form-control" id="script" name="script" rows="5"></textarea>
                                    <span class="help-block mt-10 mb-0"><small>Script o rutina ejecutable</small></span>
                                </div> 

                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-danger btn-rounded">Guardar</button>
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