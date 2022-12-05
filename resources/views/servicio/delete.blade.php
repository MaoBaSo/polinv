{{-- **************************************** --}}
{{-- ***REPORTES XLSX --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Abril de 2.022 --}}
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
            <h5 class="txt-dark">Servicios</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Servicios</a></li>
                <li><a href="#"><span>SER. Servicios</span></a></li>
                <li class="active"><span>Eliminar</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default border-panel card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Numero de Orden de Trabajo a Eliminar</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <form action="{{ route('servicio.delete') }}" method="POST">
                                @csrf
                                <div class="row mb-10">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-4 text-center">
                                        <label class="control-label mb-10 text-left" for="orden_trabajo">#Orden Trabajo *</label>
                                        <input type="text" class="form-control" id="orden_trabajo" name="orden_trabajo" required>

                                        <div class="mt-10">
                                            <label class="control-label mb-10 text-left">Motivo de eliminación *</label>
                                            <textarea class="form-control" rows="4" id="motivo" name="motivo" required></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary mt-10"><i class="fa fa-trash-o" style="color: aliceblue"></i>&nbsp;&nbsp;Elimina Servicio</button>
                                    </div>
                                    <div class="col-sm-4"></div>
                                </div>
                            </form> 

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->

@endsection

@section('scripts')


@endsection