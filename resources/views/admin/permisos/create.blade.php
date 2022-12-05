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
            <h5 class="txt-dark">Gestión de Permisos</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="index.html">Sistema</a></li>
            <li><a href="#"><span>SEG. Gestión Permisos</span></a></li>
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
                        <h6 class="panel-title txt-dark">Permisos del Rol</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                        <form method="POST" action="{{ route('gestion-permisos.store') }}">
                                @csrf
                                <div class="form-group mt-30 mb-30">
                                    <label class="control-label mb-10 text-left">Rol</label>
                                    <select class="form-control" id="rol_id" name="rol_id">
                                        @foreach($roles as $id=>$nombre)
                                            <option value="{{ $nombre }}">{{ $id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mt-30 mb-30">
                                    <label class="control-label mb-10 text-left">Caso de Uso</label>
                                    <select class="form-control" id="caso_id" name="caso_id">
                                        @foreach($casos_uso as $id=>$caso_uso)
                                            <option value="{{ $caso_uso }}">{{ $id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-30">
                                    <label class="control-label mb-10 text-left">Permisos</label>
                                        <div class="checkbox checkbox-success">
                                            <input id="lee" name="lee" type="checkbox">
                                            <label for="lee">
                                                Lee
                                            </label>
                                        </div>
                                        <div class="checkbox checkbox-success">
                                            <input id="crea" name="crea" type="checkbox">
                                            <label for="crea">
                                                Crea
                                            </label>
                                        </div>
                                        <div class="checkbox checkbox-success">
                                            <input id="edita" name="edita" type="checkbox">
                                            <label for="edita">
                                                Edita
                                            </label>
                                        </div>
                                        <div class="checkbox checkbox-success">
                                            <input id="elimina" name="elimina" type="checkbox">
                                            <label for="elimina">
                                                Elimina
                                            </label>
                                        </div>
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