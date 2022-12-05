{{-- **************************************** --}}
{{-- ***GESTION DE EMPLEADOS --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Febrero de 2.022 --}}
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
            <h5 class="txt-dark">Gestión de Empleados</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Empleados</a></li>
            <li class="active"><span>EMP. Gestión Empleados</span></li>
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
                                <aside class="col-lg-2 col-md-4 pr-0">
                                    <div class="ma-15">
                                        <a href="{{ route('empleado.create') }}" type="button"  class="btn btn-orange btn-sm btn-block">
                                        <i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar Empleado
                                        </a>
                                    </div>
                                </aside>
                                
                                <aside class="col-lg-10 col-md-8 pl-0">
                                    <div class="panel pa-0">
                                    <div class="panel-wrapper collapse in">
                                    <div class="panel-body  pa-0">
                                        <div class="table-responsive mt-15 mb-15">

                                            <table id="datable_1" class="table  display table-hover mb-30" data-page-size="10">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Especialidad</th>
                                                        <th>Teléfono</th>
                                                        <th>Operaciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
 
                                                    @foreach ($empleados as $empleado)
                                                        <tr>
                                                            <td>{{ $empleado->primer_nombre }}&nbsp;&nbsp;{{ $empleado->segundo_nombre }}&nbsp;&nbsp;{{ $empleado->primer_apellido }}&nbsp;&nbsp;{{ $empleado->segundo_apellido }}</td>
                                                            <td>{{ Miscellany::getParameterId($empleado->especialidad_id)->variable_1 }}</td>
                                                            <td>{{ $empleado->telefono_1 }}</td>
                                                            <td>
                                                                <a href="{{ route('empleado.edit', $empleado->id) }}" class="text-inverse pr-10" title="Editar" data-toggle="tooltip">
                                                                    <i class="fa fa-edit txt-warning" style="font-size: 1.5rem;"></i>
                                                                </a>
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