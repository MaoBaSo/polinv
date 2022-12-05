{{-- **************************************** --}}
{{-- ***GESTION DE SERVICIOS --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Mayo de 2.022 --}}
{{-- **************************************** --}}

@extends('layouts.template')

@section('estilos')

    <!-- Data table CSS -->
    <link href="../vendors/bower_components/datatables/media/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>

@endsection


@section('menu')

    @include('layouts._menuAdministrador')

@endsection

@section('contenido')

    <!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Gestión de Servicios</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">SERV. Gestión Servicios</a></li>
            <li class="active"><span>Finalizar</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->
    
    <!-- Row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="contact-list">
                            <div class="row">

                                <aside class="col-lg-12 col-md-12">
                                    <div class="panel pa-0">
                                    <div class="panel-wrapper collapse in">
                                    <div class="panel-body  pa-0">
                                        <div class="table-responsive mt-15 mb-15">

                                            <table id="datable_1" class="table  display table-hover mb-30" data-page-size="10">
                                                <thead>
                                                    <tr>
                                                        <th>Tipo documento</th>
                                                        <th>No.</th>
                                                        <th>Patio origen</th>
                                                        <th>Placa</th>
                                                        <th>Movil</th>                                                        
                                                        <th>Operaciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
 
                                                    @foreach ($servicios as $servicio)
                                                        <tr>
                                                            <td>{{ $servicio->tipo }}</td>

                                                            @switch($servicio->tipo)
                                                                @case("Valoración")
                                                                    <td>{{ $servicio->id }}</td>
                                                                    @break
                                                                @case("Orden Trabajo")
                                                                    <td>{{ $servicio->numero_orden_trabajo }}</td>
                                                                    @break
                                                                @case("Orden Compra")
                                                                    <td>{{ $servicio->numero_orden_compra }}</td>
                                                                    @break
                                                                @default
                                                                    <td>Sin Clasificación</td>
                                                            @endswitch                                                            

                                                            <td>{{ $servicio->patio->nombre }}</td>
                                                            <td>{{ $servicio->placa }}</td>
                                                            <td>{{ $servicio->movil }}</td>

                                                            <td>
                                                                                                                            
                                                                <form method="POST" action="{{ route('servicio-cerrar.store') }}">
                                                                    @csrf
                                                                    <input id="paso_id" name="paso_id" type="hidden" value=6>
                                                                    <input id="servicio_id" name="servicio_id" type="hidden" value={{ $servicio->id }}>

                                                                    <div class="form-group text-center">
                                                                        <button type="button" class="inline-block btn btn-primary btn-sm" data-toggle="modal" data-target="#confirmar" data-whatever="@getbootstrap"><i class="fa fa-check"></i>&nbsp;&nbsp;FINALIZAR</button>
                                                                    </div>
                                            
                                                                    <div class="modal fade" id="confirmar" tabindex="-1" role="dialog" aria-labelledby="confirmarLabel1">
                                                                        <div class="modal-dialog" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                    <h5 class="modal-title" id="confirmarLabel1"><i class="fa fa-check-square-o"></i> Finalizar Servicio</h5>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <p> <strong>ATENCION</strong>: Este proceso finaliza el servicio y lo dispone para la generación de reporte de cobro. </p>
                                                                                    <br>

                                                                                    <div class="form-group">
                                                                                        <label class="control-label mb-10 text-left" for="numero_documento">Orden Compra Asignada *</label>
                                                                                        <input type="text" class="form-control" id="numero_documento" name="numero_documento" required>
                                                                                    </div>

                                                                                    <div class="form-group">
                                                                                        <label class="control-label mb-10 text-left">Nota finalización</label>
                                                                                        <textarea class="form-control" rows="4" id="nota" name="nota"></textarea>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                                                    <button type="submit" class="btn btn-primary">FINALIZAR</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                    
                                                                </form>

                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                </aside>
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

    <!-- Data table JavaScript -->
	<script src="../vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="dist/js/dataTables-data.js"></script>

@endsection