{{-- **************************************** --}}
{{-- ***GESTION DE CLIENTES --}}
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
            <h5 class="txt-dark">Gestión de Clientes</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Clientes</a></li>
                <li><a href="#"><span>CLI. Gestión Clientes</span></a></li>
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
                        <i class="zmdi zmdi-alert-circle-o"></i>ATENCIÓN, editar o eliminar clientes puede traer consecuencias negativas en el funcionamiento del aplicativo.
                    </div>

                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Editar Clientes</h6>
                    </div>

                    <div class="pull-right">

                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            
                            <div class="form-group text-center">
                                <button type="button" class="inline-block btn btn-danger btn-rounded btn-sm" data-toggle="modal" data-target="#confirmar" data-whatever="@getbootstrap">Eliminar Cliente</button>
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
                            <form method="POST" action="{{ route('clientes.update', $cliente->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="row mb-15">
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="nit">NIT *</label>
                                        <input type="text" class="form-control" id="nit" name="nit" required value="{{ old('nit', $cliente->nit) }}">                                               
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="nombre">Nombre *</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required value="{{ old('nombre', $cliente->nombre) }}">
                                    </div>
                                    <div class="col-sm-4">
                                        <!--Ciudad-->
                                        <label class="control-label mb-10 text-left">Ciudad *</label>
                                        <select class="form-control" id="ciudad_id" name="ciudad_id" required>
                                            <option value="">Elija una ciudad</option>
                                            @foreach( $ciudades as $key => $value )
                                                @if($cliente->ciudad_id == $key)
                                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                                @else
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endif 
                                            @endforeach
                                        </select>
                                        <!--Ciudad-->
                                    </div>
                                </div> 

                                <div class="row mb-15">
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="direccion">Dirección *</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion" required value="{{ old('direccion', $cliente->direccion) }}">                                               
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="email">Email *</label>
                                        <input type="email" class="form-control" id="email" name="email" required value="{{ old('email', $cliente->email) }}">
                                    </div>
                                </div> 

                                <div class="row mb-15">
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="telefono_1">Teléfono 1 *</label>
                                        <input type="text" class="form-control" id="telefono_1" name="telefono_1" required value="{{ old('telefono_1', $cliente->telefono_1) }}">                                               
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="telefono_2">Teléfono 2</label>
                                        <input type="text" class="form-control" id="telefono_2" name="telefono_2" value="{{ old('telefono_2', $cliente->telefono_2) }}">
                                    </div>
                                </div> 

                                <div class="row mb-15">
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="contacto">Contacto *</label>
                                        <input type="text" class="form-control" id="contacto" name="contacto" required value="{{ old('contacto', $cliente->contacto) }}">                                               
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="telefono_contacto">Teléfono Contacto</label>
                                        <input type="text" class="form-control" id="telefono_contacto" name="telefono_contacto" value="{{ old('telefono_contacto', $cliente->telefono_contacto) }}">
                                    </div>
                                </div> 

                                <div class="form-group">
                                    <label class="control-label mb-10 text-left">Notas</label>
                                    <textarea class="form-control" rows="4" id="notas" name="notas">{{ $cliente->notas }}</textarea>
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