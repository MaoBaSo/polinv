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
            <h5 class="txt-dark">Gestión de líneas  de inventario</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Inventario</a></li>
                <li><a href="#"><span>INV. Gestión líneas</span></a></li>
                <li class="active"><span>Nueva</span></li>
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
                        <h6 class="panel-title txt-dark">Nueva Línea</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form method="POST" action="{{ route('inventario-lineas.store') }}">
                                @csrf

                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="nombre">Nombre de Línea *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>

                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="nombre">Características</label>
                                    <input type="text" class="form-control" id="caracteristicas" name="caracteristicas">
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