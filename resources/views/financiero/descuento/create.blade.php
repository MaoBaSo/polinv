{{-- **************************************** --}}
{{-- ***GESTION FINANCIERA --}}
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
            <h5 class="txt-dark">Gestión Financiera</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Financiero</a></li>
                <li><a href="#"><span>FIN. Gestión Financiera</span></a></li>
                <li class="active"><span>Descuento</span></li>
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
                        <h6 class="panel-title txt-dark">Nuevo Descuento</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <h5>SKU: {{ $items_servicio->invServicio->sku }} ( {{ $items_servicio->invServicio->nombre }} ) | VALOR ACTUAL: <b>{{ number_format(Miscellany::getValItem($items_servicio->id)) }}</b></h5>
                            <br>
                            <form action="{{ route('servicio-item.discount') }}" method="POST">
                                @csrf
                                <input id="id_item" name="id_item" type="hidden" value="{{ $items_servicio->id }}">

                                <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="valor">Valor descuento *</label>
                                    <input type="number" class="form-control" id="valor" name="valor" required>
                                </div>

                                <div class="form-group">
                                    <label class="control-label mb-10 text-left">Motivo descuento *</label>
                                    <textarea class="form-control" rows="4" id="motivo" name="motivo" required></textarea>
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