{{-- **************************************** --}}
{{-- ***Panel de SUPER USUARIO / Gestión de logs --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Septiembre de 2.021 --}}
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
            <h5 class="txt-dark">Gestión de Logs</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Sistema</a></li>
            <li class="active"><span>SEG. Gestión Logs</span></li>
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
                                                        <th>Procedencia</th>
                                                        <th>Tipo</th>
                                                        <th>Fecha</th>
                                                        <th>Descripción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
 
                                                    @foreach ($logs as $log)
                                                        <tr>
                                                            <td>{{ $log->procedencia }}</td>
                                                            <td>{{ $log->tipo }}</td>
                                                            <td>{{ $log->created_at }}</td>
                                                            <td>{{ $log->descripcion }}</td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>

                                            {!! $logs->links() !!}

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