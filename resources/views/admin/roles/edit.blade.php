{{-- **************************************** --}}
{{-- ***Panel de SUPER USUARIO / Edita Rol --}}
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
            <h5 class="txt-dark">Gestión de Roles</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="index.html">Sistema</a></li>
            <li><a href="#"><span>SEG. Gestión Roles</span></a></li>
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
                        <form action="{{ route('gestion-roles.destroy',$roles->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-block btn btn-danger btn-rounded btn-sm">Eliminar Rol</button>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form method="POST" action="{{ route('gestion-roles.update', $roles->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="nombre">Nombre de Rol</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required value="{{ old('nombre', $roles->nombre) }}">
                                </div>

                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="nombre">Nota</label>
                                    <input type="text" class="form-control" id="nota" name="nota" required value="{{ old('nota', $roles->nota) }}">
                                </div>
                                
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-success btn-rounded">Guardar Rol</button>
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