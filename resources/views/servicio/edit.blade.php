{{-- **************************************** --}}
{{-- ***GESTION DE SERVICIOS --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Febrero de 2.022 --}}
{{-- **************************************** --}}

@extends('layouts.template')

@section('estilos')
    
    <!-- Data table CSS -->
    <link href="{{ asset('vendors/bower_components/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    
    <style>
        .onlyView{background-color: white; border:solid; border-width: 1px;}
    </style>


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
                <li><a href="#">Servicios</a></li>
                <li><a href="#"><span>SERV. Gestión Servicios</span></a></li>
                <li class="active"><span>Actualiza</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->
    
    <!--MUESTRA DATOS DEL SERVICIO--> 
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-panel card-view">
                <div class="panel-heading">

                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Datos básicos del servicio</h6>
                    </div>

                    <div class="pull-right">
                        <!--SOLO SE ELIMINAN SERVICIOS EN EL PASO 1-->
                        @if($servicio->tipo == 'Valoración'  && $servicio->estado == 1)
                            <form action="{{ route('servicio.destroy', $servicio->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <div class="form-group text-center">
                                    <button type="button" class="inline-block btn btn-default btn-sm" data-toggle="modal" data-target="#confirmar" data-whatever="@getbootstrap"><i class="fa fa-exclamation-triangle" style="color: red"></i>&nbsp;&nbsp;Eliminar Servicio</button>
                                </div>
        
                                <div class="modal fade" id="confirmar" tabindex="-1" role="dialog" aria-labelledby="confirmarLabel1">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h5 class="modal-title" id="confirmarLabel1">Confirmar proceso</h5>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Confirma la eliminación del registro?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-danger">Confirmar Eliminación</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>                        
                        @endif
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
   
                            <!--Formulario carga datos de servicio SOLO VISTA-->        
                            <form class="form-horizontal">

                                <fieldset readonly onmousedown="return false;">
                                
                                    <div class="form-group mb-0">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label mb-10" for="cliente">Cliente</label>
                                                    <input type="text" style="background-color: white; border:solid; border-width: 1px;" class="form-control filled-input" id="cliente" name="cliente"  value="{{ $servicio->cliente->nombre }}">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="control-label mb-10" for="patio_cliente">Patio Cliente</label>
                                                    <input type="text" style="background-color: white; border:solid; border-width: 1px;" class="form-control filled-input" id="patio_cliente" name="patio_cliente"  value="{{ $servicio->patio->nombre }}">
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="control-label mb-10" for="tipo_registro">Tipo Documento actual</label>
                                                    <input type="text" style="background-color: white; border:solid; border-width: 1px;" class="form-control filled-input" id="tipo_registro" name="tipo_registro"  value="{{ $servicio->tipo }}">
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="control-label mb-10" for="tipo_registro">Estado actual</label>
                                                    <input type="text" style="background-color: white; border:solid; border-width: 1px;" class="form-control filled-input" id="tipo_registro" name="tipo_registro"  value="{{ Miscellany::getEstadoServicio($servicio->estado) }}">
                                                </div>
                                            </div>
                                        </div>	
                                    </div>
        
                                    <div class="form-group mb-0">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label class="control-label mb-10" for="valor_registro">Valor del servicio</label>
                                                    <input type="text" style="background-color: white; border:solid; border-width: 1px;" class="form-control filled-input text-success" id="valor_registro" name="valor_registro"  value="{{ number_format(Miscellany::getValServicio($servicio->id), 2, ',', '.') }}">
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="control-label mb-10" for="placa">Placa Vehículo</label>
                                                    <input type="text" style="background-color: white; border:solid; border-width: 1px;" class="form-control filled-input" id="placa" name="placa"  value="{{ $servicio->placa }}">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="control-label mb-10" for="movil">Movil Vehículo</label>
                                                    <input type="text" style="background-color: white; border:solid; border-width: 1px;" class="form-control filled-input" id="placa" name="placa"  value="{{ $servicio->movil }}">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="control-label mb-10" for="placa">Numero Documento</label>
                                                    <input type="text" style="background-color: white; border:solid; border-width: 1px;" class="form-control filled-input" id="orden_trabajo" name="orden_trabajo"  value="{{ $servicio->numero_orden_trabajo }}">
                                                </div>
                                            </div>
                                        </div>	
                                    </div>
        
                                    <div class="form-group mb-0">
                                        <div class="col-sm-12">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label mb-10">Notas</label>
                                                    <textarea class="form-control" rows="4" id="notas" name="notas">{{ $servicio->nota_servicio }}</textarea>
                                                </div>
                                            </div>
                                        </div>	
                                    </div>                            
                                
                                </fieldset>    
                            </form>

                            <!--BOTONERA CAMBIO ESTADOS SERVICIO-->
                            @if($servicio->tipo == 'Valoración'  && $servicio->estado == 1)
                                <h5 class="text-center">Proceso Autorización</h5>
                                <div class="form-group mb-0">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-1"></div>

                                            <div class="col-sm-2">
                                                <!--imprime PDF-->
                                                <form action="{{ route('reportes.valorizacion') }}" method="POST">
                                                    @csrf
                                                    <input id="servicio_id" name="servicio_id" type="hidden" value="{{ $servicio->id }}">
                                                    <button type="submit" class="btn btn-primary btn-block"><i class="fa  fa-file-pdf-o" style="color: aliceblue"></i>&nbsp;&nbsp;GENERA PDF</button>
                                                </form> 

                                            </div>
                                            <div class="col-sm-6">
                                                <!--Sube Orden de trabajo-->
                                                <form method="POST" action="{{ route('servicio-estado.update') }}">
                                                    @csrf
                                                    <input id="paso_id" name="paso_id" type="hidden" value=2>
                                                    <input id="servicio_id" name="servicio_id" type="hidden" value={{ $servicio->id }}>
                                                    <input id="nota" name="nota" type="hidden" value="">
                
                                                    <div class="form-group mb-0">
                                                        <div class="col-sm-12">
                                                            <div class="row">
                
                                                                <div class="input-group mb-15">
                                                                    <input type="text" id="numero_documento" name="numero_documento" class="form-control" placeholder="No Orden trabajo">
                                                                    <span class="input-group-btn">
                                                                    <button type="submit" class="btn btn-primary btn-anim"><i class="icon-rocket"></i><span class="btn-text">Autorizar</span></button>
                                                                    </span> 
                                                                </div>
                
                                                            </div>
                                                        </div>	
                                                    </div>
                
                                                </form>

                                            </div>
                                            <div class="col-sm-2">                            
                                                <!--Agrega un nuevo ítem al servicio-->
                                                <a href="{{ route('servicio-item.createwid', $servicio->id ) }}" type="button"  class="btn btn-primary btn-block">
                                                    <i class="fa fa-plus" style="color: aliceblue"></i>&nbsp;&nbsp;Agregar Item
                                                </a>   

                                            </div>

                                            <div class="col-sm-1"></div>
                                        </div>
                                    </div>	
                                </div>

                            @elseif($servicio->tipo == 'Orden Trabajo' &&  $servicio->estado == 1) 
                                <h5 class="text-center">Proceso Asignación</h5>
                                <!--Aignacion directa-->
                                <form method="POST" action="{{ route('servicio-estado.update') }}">
                                    @csrf
                                    <input id="paso_id" name="paso_id" type="hidden" value=3>
                                    <input id="servicio_id" name="servicio_id" type="hidden" value={{ $servicio->id }}>
                                    <input id="nota" name="nota" type="hidden" value="">

                                    <div class="button-list  text-center">
                                        <button type="submit" class="btn btn-success btn-anim"><i class="icon-rocket"></i><span class="btn-text">Directa</span></button>
                                        <a href="{{ route('operacion-asignacion.createwid', $servicio->id ) }}" type="button" class="btn btn-primary btn-anim">
                                            <i class="fa fa-sign-out"></i><span class="btn-text">A Técnicos</span>
                                        </a>             
                                    </div>
                                </form>
                            @elseif($servicio->tipo == 'Orden Trabajo' &&  $servicio->estado == 2) 
                                <h5 class="text-center">Enviar a Calidad</h5>
                                <form method="POST" action="{{ route('servicio-estado.update') }}">
                                    @csrf
                                    <input id="paso_id" name="paso_id" type="hidden" value=4>
                                    <input id="servicio_id" name="servicio_id" type="hidden" value={{ $servicio->id }}>

                                    <div class="form-group mb-0">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-8">

                                                    <div class="input-group mb-15">
                                                        <input type="text" id="nota" name="nota" class="form-control" placeholder="Nota">
                                                        <span class="input-group-btn">
                                                        <button type="submit" class="btn btn-primary btn-anim"><i class="icon-rocket"></i><span class="btn-text">Revisión Calidad</span></button>
                                                        </span> 
                                                    </div>

                                                </div>
                                                <div class="col-sm-2">
                                                </div>
                                            </div>
                                        </div>	
                                    </div>

                                </form>

                            @elseif($servicio->tipo == 'Orden Trabajo' &&  $servicio->estado == 3) 
                                <h5 class="text-center">Proceso Calidad</h5>
                                <div class="button-list  text-center">
                                    <a href="{{ route('operacion-revision.show', $servicio->id ) }}" type="button" class="btn btn-success btn-anim">
                                        <i class="icon-rocket"></i><span class="btn-text">Revisar calidad</span>
                                    </a>
                                </div>
                            @elseif($servicio->tipo == 'Orden Trabajo' &&  $servicio->estado == 4) 
                                <h5 class="text-center">Proceso Finalización</h5>
                                <form method="POST" action="{{ route('servicio-estado.update') }}">
                                    @csrf
                                    <input id="paso_id" name="paso_id" type="hidden" value=6>
                                    <input id="servicio_id" name="servicio_id" type="hidden" value={{ $servicio->id }}>
                                    <input id="nota" name="nota" type="hidden" value="">

                                    <div class="form-group mb-0">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-8">

                                                    <div class="input-group mb-15">
                                                        <input type="text" id="numero_documento" name="numero_documento" class="form-control" placeholder="No Orden Compra">
                                                        <span class="input-group-btn">
                                                        <button type="submit" class="btn btn-success btn-anim"><i class="icon-rocket"></i><span class="btn-text">Finalizar</span></button>
                                                        </span> 
                                                    </div>

                                                </div>
                                                <div class="col-sm-2">
                                                </div>
                                            </div>
                                        </div>	
                                    </div>

                                </form>

                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ MUESTRA DATOS DEL SERVICIO--> 

    <!--LISTA DE ITEMS DEL SEVICIO-->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-panel card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Lista de ítems del servicio</h6>
                    </div>
                    <div class="pull-right">
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <table id="datable_1" class="table table-hover display  pb-30">
                                <thead>
                                    <tr>
                                        <th>Tipo de procedimiento</th>
                                        <th>Valor</th>
                                        <th>Descuento</th>
                                        <th>Neto</th>
                                        <th>Operaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items_servicio as $item)
                                        <tr>
                                            <td>{{ $item->invServicio->sku }} ({{ $item->invServicio->nombre }}) </td>
                                            <td>{{ number_format($item->valor, 2, ',', '.') }}</td>
                                            <td>{{ number_format($item->descuento, 2, ',', '.') }}</td>
                                            <td>{{ number_format(($item->valor - $item->descuento)   , 2, ',', '.') }}</td>
                                            <td>
                                                <a href="{{ route('servicio-item.show', $item->id) }}" class="text-inverse pr-10" title="Ver Ítem" data-toggle="tooltip">
                                                    <i class="fa fa-eye text-muted" style="font-size: 2.5rem;"></i>
                                                </a>
                                              
                                                @if($servicio->tipo == 'Valoración'  && $servicio->estado == 1)
                                                    &nbsp;
                                                    <a href="{{ route('servicio-item.edit', $item->id) }}" class="text-inverse pr-10" title="Editar Ítem" data-toggle="tooltip">
                                                        <i class="fa fa-pencil-square text-muted" style="font-size: 2.5rem;"></i>
                                                    </a>
                                                    &nbsp;
                                                    <a href="{{ route('servicio-item-creatediscount.create', $item->id) }}" class="text-inverse pr-10" title="Descuento" data-toggle="tooltip">
                                                        <i class="fa fa-money text-muted" style="font-size: 2.5rem;"></i>
                                                    </a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="form-group text-center">
                                <a href="{{ url()->previous() }}" class="btn btn-primary btn-rounded btn-icon left-icon btn-sm"><i class="fa fa-hand-o-left"></i> <span>Atras</span></a>
                            </div>

                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /LISTA DE ITEMS DEL SEVICIO-->

@endsection

@section('scripts')

	<!-- Data table JavaScript -->
	<script src="{{ asset('vendors/bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('dist/js/dataTables-data.js') }}"></script>

@endsection