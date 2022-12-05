{{-- **************************************** --}}
{{-- ***Panel de SUPER USUARIO / Edita Permisos --}}
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
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Editar Rol</h6>
                    </div>
                    <div class="pull-right">
                        <form action="{{ route('gestion-permisos.destroy',$permisos->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-block btn btn-danger btn-rounded btn-sm">Eliminar Permiso</button>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <form method="POST" action="{{ route('gestion-permisos.update', $permisos->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group mt-30 mb-30">
                                    <label class="control-label mb-10 text-left">Rol</label>
                                    <select class="form-control" id="rol_id" name="rol_id" disabled>
                                        @foreach($roles as $id=>$nombre)
                                            @if($permisos->rol_id == $nombre)
                                                <option value="{{ $nombre }}" selected>{{ $id }}</option>
                                            @else
                                                <option value="{{ $nombre }}">{{ $id }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mt-30 mb-30">
                                    <label class="control-label mb-10 text-left">Caso de Uso</label>
                                    <select class="form-control" id="caso_id" name="caso_id" disabled>
                                        @foreach($casos_uso as $id=>$caso_uso)
                                            @if($permisos->caso_id == $caso_uso)
                                                <option value="{{ $caso_uso }}" selected>{{ $id }}</option>
                                            @else
                                                <option value="{{ $caso_uso }}">{{ $id }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-30">
                                    <label class="control-label mb-10 text-left">Permisos</label>
                                        <div class="checkbox checkbox-success">
                                            @if ($permisos->lee)
                                                <input id="lee" name="lee" type="checkbox" checked>
                                            @else
                                                <input id="lee" name="lee" type="checkbox">
                                            @endif
                                            <label for="lee">
                                                Lee
                                            </label>
                                        </div>
                                        <div class="checkbox checkbox-success">
                                            @if ($permisos->crea)
                                                <input id="crea" name="crea" type="checkbox" checked>
                                            @else
                                                <input id="crea" name="crea" type="checkbox">
                                            @endif
                                            <label for="crea">
                                                Crea
                                            </label>
                                        </div>
                                        <div class="checkbox checkbox-success">
                                            @if ($permisos->edita)
                                                <input id="edita" name="edita" type="checkbox" checked> 
                                            @else
                                                <input id="edita" name="edita" type="checkbox"> 
                                            @endif
                                            <label for="edita">
                                                Edita
                                            </label>
                                        </div>
                                        <div class="checkbox checkbox-success">
                                            @if ($permisos->elimina)
                                                <input id="elimina" name="elimina" type="checkbox" checked> 
                                            @else
                                                <input id="elimina" name="elimina" type="checkbox"> 
                                            @endif
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