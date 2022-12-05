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
            <h5 class="txt-dark">Gestión de Lista blanca</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Sistema</a></li>
                <li><a href="#"><span>SEG. Lista Blanca</span></a></li>
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
                        <h6 class="panel-title txt-dark">Nuevo Registro</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <form method="POST" action="{{ route('gestion-lista-blanca.store') }}">
                                @csrf

                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="ip">IP *</label>
                                    <input type="text" class="form-control" id="ip" name="ip" required>
                                </div>
                                <!--Cliente-->
                                <div class="form-group mt-30 mb-30">
                                    <label class="control-label mb-10 text-left">Cliente *</label>
                                    <select class="form-control" id="cliente_id" name="cliente_id" required>
                                        <option value="">Elija un cliente</option>
                                        @foreach( $clientes as $key => $value )
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>                                
                                <!--Cliente-->
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="origen">Origen de IP *</label>
                                    <input type="text" class="form-control" id="origen" name="origen" required>
                                </div> 
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="email_report">Reportar a email</label>
                                    <input type="email" class="form-control" id="email_report" name="email_report">
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