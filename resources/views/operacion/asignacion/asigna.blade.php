{{-- **************************************** --}}
{{-- ***GESTION DE SERVICIOS VS EMPLEADOS --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Abril de 2.022 --}}
{{-- **************************************** --}}

@extends('layouts.template')

@section('estilos')

    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
        * {font-family: 'Roboto', sans-serif;} 
        table {
            background-color: white;
            font-size: 12px;
            width: 100%;
            border: .2px solid rgb(121, 112, 112);
            border-collapse: collapse;
            padding: 2px;
        }
        table tr, td, th {
            border: .2px solid rgb(121, 112, 112);
            padding: 5px;
            /* Alto de las celdas */
            height: 10px;

        }
        #t-firma{font-size: 12px;}
        #t-img{font-size: 10px;}
        #t-img img{width: 300px; height: 199px;}

    </style>

@endsection


@section('menu')

    @include('layouts._menuAdministrador')

@endsection


@section('contenido')

    <!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Gestión Operativa</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Operativa</a></li>
                <li><a href="#"><span>OPT. Asignar servicios</span></a></li>
                <li class="active"><span>Asignar a Técnico</span></li>
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
                        <h6 class="panel-title txt-dark">Asignación de ítem</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <!--ENCABEZADOS-->
                            <table>
                                <thead>
                                <tr>
                                    <th>Procedimiento</th>
                                    <th>Valor de comisión</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $item_servicio->invServicio->sku }} ({{ $item_servicio->invServicio->nombre }})</td>
                                    <td>{{ number_format($item_servicio->invServicio->valor_base_hora) }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <!--ITEMS ASIGNADOS-->
                            <table class="mb-20">
                                <thead>
                                    <tr>
                                        <th>Token</th>
                                        <th>Técnico</th>
                                        <th>Porcentaje</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $cont_id = 10;
                                    ?>
                                    @foreach ($asigaciones_actuales as $item)  
                                        <tr>
                                            <td>{{ $item->token }}</td>
                                            <td>{{ getEmpleado($item->empleado_id)->primer_nombre }} {{ getEmpleado($item->empleado_id)->primer_apellido }}</td>
                                            <td>{{ $item->porcentaje }} %</td>
                                            <td>
                                            
                                                <form action="{{ route('operacion.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                    
                                                    <div class="form-group text-center">
                                                        <button type="button" class="inline-block btn btn-default btn-sm" data-toggle="modal" data-target="#confirmar" data-whatever="@getbootstrap"><i class="fa fa fa-trash-o"></i></button>
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
                                            
                                            </td>
                                        </tr>
                                    @endforeach            
                                </tbody>
                            </table>
                            <hr>    
                            <!--ASIGNAR NUEVO ITEM-->
                            <form method="POST" action="{{ route('operacion.store') }}">
                                @csrf

                                <input id="servicio_id" name="servicio_id" type="hidden" value="{{ $item_servicio->serv_servicios_id }}">
                                <input id="item_id" name="item_id" type="hidden" value="{{ $item_servicio->id }}">
                                <input id="valor_comision" name="valor_comision" type="hidden" value="{{ $item_servicio->invServicio->valor_base_hora }}">

                                <div class="row mb-10">
                                    <div class="col-sm-8">
                                        <!--Empleado-->
                                            <label class="control-label mb-10 text-left">Técnico *</label>
                                            <select class="form-control" id="empleado_id" name="empleado_id" required>
                                                <option value="">Elija un técnico</option>
                                                @foreach( $empleados as $key => $value )
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>                             
                                        <!--Empleado-->
                                    </div>

                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="porcentaje">Porcentaje *</label>
                                        <input type="number" class="form-control" id="porcentaje" name="porcentaje" required>
                                        <span style="font-size: 10px">Elija un numero entre 1 y 100</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label mb-10 text-left">Notas</label>
                                    <textarea class="form-control" rows="4" id="nota" name="nota"></textarea>
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