{{-- **************************************** --}}
{{-- ***Panel de SUPER USUARIO / Gestión de permisos --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Septiembre de 2.021 --}}
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
            <h5 class="txt-dark">Gestión de permisos</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Sistema</a></li>
            <li class="active"><span>SEG. Gestión permisos</span></li>
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
                                        <a href="{{ route('gestion-permisos.create') }}" type="button"  class="btn btn-orange btn-sm btn-block">
                                        <i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar permiso
                                        </a>
                                    </div>
                                </aside>
                                
                                <aside class="col-lg-10 col-md-8 pl-0">
                                    <div class="panel pa-0">
                                    <div class="panel-wrapper collapse in">
                                    <div class="panel-body  pa-0">
                                        <div class="table-responsive mt-15 mb-15">
                                            <table id="datable_1" class="table table-hover display  pb-30">
                                                <thead>
                                                    <tr>
                                                        <th>Rol</th>
                                                        <th>Caso Uso</th>
                                                        <th>Lee</th>
                                                        <th>Crea</th>
                                                        <th>Edita</th>
                                                        <th>Elimina</th>
                                                        <th>Edición</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
 
                                                    @foreach ($permisos as $permiso)
                                                        <tr>
                                                            <td>{{ $permiso->rol }}</td>
                                                            <td>{{ $permiso->caso_uso }}</td>
                                                            
                                                            @if($permiso->lee == 1)
                                                                <td><i class="fa fa-check pr-10 txt-success"></i></td>
                                                            @else    
                                                                <td><i class="fa fa-times pr-10 txt-danger"></i></td>
                                                            @endif
                                                            @if($permiso->crea == 1)
                                                                <td><i class="fa fa-check pr-10 txt-success"></i></td>
                                                            @else    
                                                                <td><i class="fa fa-times pr-10 txt-danger"></i></td>
                                                            @endif
                                                            @if($permiso->edita == 1)
                                                                <td><i class="fa fa-check pr-10 txt-success"></i></td>
                                                            @else    
                                                                <td><i class="fa fa-times pr-10 txt-danger"></i></td>
                                                            @endif                                                           
                                                            @if($permiso->elimina == 1)
                                                                <td><i class="fa fa-check pr-10 txt-success"></i></td>
                                                            @else    
                                                                <td><i class="fa fa-times pr-10 txt-danger"></i></td>
                                                            @endif  

                                                            <td><a href="{{ route('gestion-permisos.edit', $permiso->id) }}" class="text-inverse pr-10" title="Editar" data-toggle="tooltip">
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