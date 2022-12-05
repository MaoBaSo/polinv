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
                        <h6 class="panel-title txt-dark">Nuevo Cliente</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <form method="POST" action="{{ route('clientes.store') }}">
                                @csrf

                                <div class="row mb-15">
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="nit">NIT *</label>
                                        <input type="text" class="form-control" id="nit" name="nit" required value="{{ old('nit') }}">                                               
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="nombre">Nombre *</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required value="{{ old('nombre') }}">
                                    </div>
                                    <div class="col-sm-4">
                                        <!--Ciudad-->
                                        <label class="control-label mb-10 text-left">Ciudad *</label>
                                        <select class="form-control" id="ciudad_id" name="ciudad_id" required>
                                            <option value="">Elija una ciudad</option>
                                            @foreach( $ciudades as $key => $value )
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <!--Ciudad-->
                                    </div>
                                </div> 

                                <div class="row mb-15">
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="direccion">Dirección *</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion" required value="{{ old('direccion') }}">                                               
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="email">Email *</label>
                                        <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
                                    </div>
                                </div> 

                                <div class="row mb-15">
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="telefono_1">Teléfono 1 *</label>
                                        <input type="text" class="form-control" id="telefono_1" name="telefono_1" required>                                               
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="telefono_2">Teléfono 2</label>
                                        <input type="text" class="form-control" id="telefono_2" name="telefono_2">
                                    </div>
                                </div> 

                                <div class="row mb-15">
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="contacto">Contacto *</label>
                                        <input type="text" class="form-control" id="contacto" name="contacto" required>                                               
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="telefono_contacto">Teléfono Contacto</label>
                                        <input type="text" class="form-control" id="telefono_contacto" name="telefono_contacto">
                                    </div>
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