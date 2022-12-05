{{-- **************************************** --}}
{{-- ***REPORTES XLSX --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Abril de 2.022 --}}
{{-- **************************************** --}}

@extends('layouts.template')

@section('estilos')

@endsection


@section('menu')

    @if(Auth::user()->tipo_id == 9)
        @include('layouts._menuAdministrador')
    @elseif(Auth::user()->tipo_id == 10)
        @include('layouts._menuCliente')
    @else
        <p>No hay menu disponible</p>
    @endif

@endsection


@section('contenido')

    <!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Reporte de Servicios con Ítems</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Reportes</a></li>
                <li><a href="#"><span>REP. Servicios / Ítems</span></a></li>
                <li class="active"><span>Generar</span></li>
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
                        <h6 class="panel-title txt-dark">Rango de fechas</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <!--imprime PDF-->
                            <form action="{{ route('reportes.servicios') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label for="fecha_desde">Fecha desde:</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                <input class="form-control" name="fecha_desde" type="date" value="{{ date('d-m-Y') }}" id="fecha_desde">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label for="fecha_hasta">Fecha hasta:</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                <input class="form-control" name="fecha_hasta" type="date" value="{{ date('d-m-Y') }}" id="fecha_hasta">
                                            </div>
                                        </div>

                                    </div>
                                </div>                

                                <button type="submit" class="btn btn-primary "><i class="fa fa-file-excel-o" style="color: aliceblue"></i>&nbsp;&nbsp;GENERA XLSX</button>
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