{{-- **************************************** --}}
{{-- ***GESTION DE CALIDAD --}}
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
            <h5 class="txt-dark">Gestión de Calidad</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Operación</a></li>
                <li><a href="#"><span>OPT. Gestión Calidad</span></a></li>
                <li class="active"><span>Servicio</span></li>
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
                        <h6 class="panel-title txt-dark">Gestionar Calidad</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <!--MUESTRA DATOS DEL SERVICIO--> 
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-default border-panel card-view">
                                        <div class="panel-heading">

                                            <div class="pull-left">
                                                <h6 class="panel-title txt-dark">Datos básicos del servicio</h6>
                                            </div>
                                            <div class="pull-right">

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
                                                                            <input type="text" class="form-control filled-input rounded-input" id="cliente" name="cliente"  value="{{ $servicio->cliente->nombre }}">
                                                                        </div>
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label mb-10" for="patio_cliente">Patio Cliente</label>
                                                                            <input type="text" class="form-control filled-input rounded-input" id="patio_cliente" name="patio_cliente"  value="{{ $servicio->patio->nombre }}">
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <label class="control-label mb-10" for="tipo_registro">Tipo Documento actual</label>
                                                                            <input type="text" class="form-control filled-input rounded-input" id="tipo_registro" name="tipo_registro"  value="{{ $servicio->tipo }}">
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <label class="control-label mb-10" for="tipo_registro">Estado actual</label>
                                                                            <input type="text" class="form-control filled-input rounded-input" id="tipo_registro" name="tipo_registro"  value="{{ Miscellany::getEstadoServicio($servicio->estado) }}">
                                                                        </div>
                                                                    </div>
                                                                </div>	
                                                            </div>
                                
                                                            <div class="form-group mb-0">
                                                                <div class="col-sm-12">
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label mb-10" for="valor_registro">Valor del servicio</label>
                                                                            <input type="text" class="form-control filled-input rounded-input text-success" id="valor_registro" name="valor_registro"  value="{{ number_format($servicio->valor_bruto_procedimiento, 2, ',', '.') }}">
                                                                        </div>
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label mb-10" for="placa">Placa Vehículo *</label>
                                                                            <input type="text" class="form-control filled-input rounded-input" id="placa" name="placa"  value="{{ $servicio->placa }}">
                                                                        </div>
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label mb-10" for="placa">Numero Orden Trabajo</label>
                                                                            <input type="text" class="form-control filled-input rounded-input" id="orden_trabajo" name="orden_trabajo"  value="{{ $servicio->numero_orden_trabajo }}">
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
                                                    
                                                    <div class="clearfix"></div>
                                                    
                                                    <h5 class="text-center">Cierre Proceso calidad</h5>
                                                    <div class="form-group mb-0">
                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <div class="col-sm-1"></div>
                                                                <div class="col-sm-2">
                                                                    <!--imprime PDF-->
                                                                    <form action="{{ route('reportes.rcalidad') }}" method="POST">
                                                                        @csrf
                                                                        <input id="servicio_id" name="servicio_id" type="hidden" value="{{ $servicio->id }}">
                                                                        <button type="submit" class="btn btn-primary btn-block"><i class="fa  fa-file-pdf-o" style="color: aliceblue"></i>&nbsp;&nbsp;GENERA PDF</button>
                                                                    </form> 
                    
                                                                </div>
                                                                <div class="col-sm-8">  
                                                                    
                                                                    @if($cant_items_abiertos > 0)
                                                                        <div class="input-group mb-15">
                                                                            <input type="text" id="nota" name="nota" class="form-control" placeholder="Nota">
                                                                            <span class="input-group-btn">
                                                                            <button type="submit" class="btn btn-primary disabled "><i class="fa fa-check"></i><span class="btn-text">Cerrar Proceso</span></button>
                                                                            </span> 
                                                                        </div>
                                                                    @else
                                                                        <!--Cierra el proceso-->                                                                    
                                                                        <form method="POST" action="{{ route('operacion-estado.update') }}">
                                                                            @csrf
                                                                            <input id="paso_id" name="paso_id" type="hidden" value=5>
                                                                            <input id="servicio_id" name="servicio_id" type="hidden" value={{ $servicio->id }}>                                    
                                                                            <div class="input-group mb-15">
                                                                                <input type="text" id="nota" name="nota" class="form-control" placeholder="Nota">
                                                                                <span class="input-group-btn">
                                                                                <button type="submit" class="btn btn-primary btn-anim"><i class="fa fa-check"></i><span class="btn-text">Cerrar Proceso</span></button>
                                                                                </span> 
                                                                            </div>
                                                                        </form>                                                                    
                                                                    @endif

                                                                </div>
                                                                <div class="col-sm-1"></div>                                                                  
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ MUESTRA DATOS DEL SERVICIO--> 
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
                                        <th>Nota</th>
                                        <th>OK Calidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items_servicio as $item)
                                        <tr>
                                            <td>{{ $item->invServicio->nombre }}</td>
                                            <td>{{ number_format($item->valor, 2, ',', '.') }}</td>
                                            <td>{{ $item->nota_item }}</td>
                                            <td>

                                                @if($item->ok_revisado == 1)
                                                    <a href="{{ route('operacion-revision.edit', $item->id) }}" class="text-inverse pr-10" title="Editar" data-toggle="tooltip">
                                                        <i class="fa fa-thumbs-o-up txt-primary" style="font-size: 2.5rem;"></i>
                                                    </a>                                               
                                                @else
                                                    <a href="{{ route('operacion-revision.createwid', $item->id) }}" class="text-inverse pr-10" title="OK Aprobado" data-toggle="tooltip">
                                                        <i class="fa fa-thumbs-o-up txt-warning" style="font-size: 2.5rem;"></i>
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

@endsection