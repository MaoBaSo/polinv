{{-- **************************************** --}}
{{-- ***Panel de SUPER USUARIO / Gestión de usuarios --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Enero de 2.022 --}}
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
            <h5 class="txt-dark">Gestión de Usuarios</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Sistema</a></li>
            <li class="active"><span>SEG. Gestión Usuarios</span></li>
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
                                        <a href="{{ route('gestion-usuarios.create') }}" type="button"  class="btn btn-orange btn-sm btn-block">
                                        <i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar Usuario
                                        </a>
                                    </div>
                                </aside>
                                
                                <aside class="col-lg-10 col-md-8 pl-0">
                                    <div class="panel pa-0">
                                    <div class="panel-wrapper collapse in">
                                    <div class="panel-body  pa-0">
                                        <div class="table-responsive mt-15 mb-15">
                                        <table id="datable_3" class="table  display table-hover mb-30" data-page-size="10">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Email</th> 
                                                        <th>Tipo Usuario</th>   
                                                        <th>Edición</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
 
                                                    @foreach ($usuarios as $usuario)
                                                        <tr>
                                                            <td>{{ $usuario->name }}</td>
                                                            <td>{{ $usuario->email }}</td>
                                                            <td>{{ Miscellany::getParameterId($usuario->tipo_id)->variable_1 }}</td>
                                                            <td><a href="{{ route('gestion-usuarios.edit', $usuario->id) }}" class="text-inverse pr-10" title="Editar" data-toggle="tooltip">
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

@endsection