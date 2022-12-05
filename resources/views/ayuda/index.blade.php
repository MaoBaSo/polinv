{{-- **************************************** --}}
{{-- ***GESTION DE AYUDA --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Marzo de 2.022 --}}
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
            <h5 class="txt-dark">Ayuda</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Soporte</a></li>
                <li class="active"><span>Ayuda</span></li>
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
                        <h6 class="panel-title txt-dark">APPEX Software</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="panel-group accordion-struct accordion-style-1" id="accordion_2" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading activestate" role="tab" id="heading_10">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapse_10" aria-expanded="true" ><div class="icon-ac-wrap pr-20"><span class="plus-ac"><i class="ti-plus"></i></span><span class="minus-ac"><i class="ti-minus"></i></span></div>Acerca de...</a> 
                                </div>
                                <div id="collapse_10" class="panel-collapse collapse in" role="tabpanel">
                                    <div class="panel-body pa-15"> APPEX Software, es un sistema a medida construido para la compañía J-Pintuexpress Internacional por la casa de software codigo200.com, los derechos de uso están reservados. </div>
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