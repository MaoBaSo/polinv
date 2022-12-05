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
            <h5 class="txt-dark">Liquidar cobros clientes</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Financiero</a></li>
                <li><a href="#"><span>FIN. Cobros</span></a></li>
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
                        <h6 class="panel-title txt-dark">Opciones</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                                
                            <div class="form-group text-center">

                                <a href="{{ route('cobros.showinfo') }}">
                                    <button class="btn btn-primary"><i class="fa fa-file-excel-o" style="color: aliceblue"></i>&nbsp;&nbsp;GENERA XLSX</button>
                                </a>

                                <button type="button" class="inline-block btn btn-danger" data-toggle="modal" data-target="#confirmar" data-whatever="@getbootstrap">Cerrar Periodo</button>
                            </div>
    
                            <div class="modal fade" id="confirmar" tabindex="-1" role="dialog" aria-labelledby="confirmarLabel1">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h5 class="modal-title" id="confirmarLabel1">Confirmar Cierre</h5>
                                        </div>
                                        <div class="modal-body">
                                            <h5>¡Atención!</h5>
                                            <p>Por favor recuerde antes de cerrar:</p>
                                            <br>
                                            <p>&nbsp;&nbsp;-No finalizar servicios.</p>
                                            <p>&nbsp;&nbsp;-Genere un archvivo excel antes del cierre.</p>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                            <a href="{{ route('cobros.cierre') }}">
                                                <button class="btn btn btn-danger">Confirmar Cierre</button>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
    
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