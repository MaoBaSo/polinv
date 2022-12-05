{{-- **************************************** --}}
{{-- ***REPORTES PDF --}}
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
            <h5 class="txt-dark">Imprimir Documentos</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Documentos</a></li>
                <li><a href="#"><span>Orden Trabajo</span></a></li>
                <li class="active"><span>PDF</span></li>
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
                        <h6 class="panel-title txt-dark">Imprime Recepción de servicio</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <!--imprime PDF-->
                            <form action="{{ route('documentos.recepcioncalidad') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label mb-10 text-left" for="orden_trabajo">Orden Trabajo *</label>
                                            <input type="text" class="form-control" id="orden_trabajo" name="orden_trabajo" required>
                                        </div> 
                                    </div>
                                    <div class="col-sm-3"></div>
                                </div>                

                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-file-pdf-o" style="color: aliceblue"></i>&nbsp;&nbsp;GENERA PDF</button>
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