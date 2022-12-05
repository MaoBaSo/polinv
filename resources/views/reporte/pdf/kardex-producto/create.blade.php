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
            <h5 class="txt-dark">Imprimir Kardex</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Reportes</a></li>
                <li><a href="#"><span>Kardex</span></a></li>
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
                        <h6 class="panel-title txt-dark">Imprime Kardex producto</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <!--imprime PDF-->
                            <form action="{{ route('documentos-kardex') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-4">
                                        <!--Producto-->
                                        <label for="producto_id" >Producto *</label>
                                        <select class="form-control" id="producto_id" name="producto_id" required>
                                            <option value="">Elija un producto</option>
                                            @foreach( $productos as $key => $value )
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>                             
                                        <!--Producto-->
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="fecha_desde">Fecha desde: *</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                            <input class="form-control" name="fecha_desde" type="date" value="{{ date('d-m-Y') }}" id="fecha_desde" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="fecha_hasta">Fecha hasta: *</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                            <input class="form-control" name="fecha_hasta" type="date" value="{{ date('d-m-Y') }}" id="fecha_hasta" required>
                                        </div>
                                    </div>
                                </div>                

                                <div class="form-group text-center mt-20">
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