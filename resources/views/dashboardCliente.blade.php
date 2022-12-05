{{-- **************************************** --}}
{{-- ***Panel de CLIENTE --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Enero de 2.022 --}}
{{-- **************************************** --}}

@extends('layouts.template')

@section('estilos')

    <style>
        .page-wrapper {
        margin-left: 250px;
        padding: 85px 20px;
        position: relative;
        background-image: url("{{ asset('img/fondo_cliente.jpg') }}");
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center center;
        background-size: cover;
        -webkit-transition: all 0.4s ease;
        -moz-transition: all 0.4s ease;
        transition: all 0.4s ease;
        left: 0; }

        @media (max-width: 1400px) {
            .page-wrapper {
            margin-left: 0px; }
            }

    </style>

@endsection


@section('menu')

    @include('layouts._menuCliente')

@endsection


@section('contenido')

    <!-- Contadores -->
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <!--Por Autorizar-->
                <div class="col-sm-4 col-xs-12">
                    <div class="panel panel-default card-view pa-0">
                        <div class="panel-wrapper collapse in">
                            <div class="panel-body pa-0">
                                <div class="sm-data-box">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-xs-6 data-wrap-left">
                                                <span class="capitalize-font block">Por Autorizar</span>
                                                <span class="txt-dark block"><span class="counter inline-block"><span class="counter-anim">{{ $count_autorizar }}</span></span><span class="trand-icon inline-block txt-success"><i class="fa fa-edit"></i></span></span>
                                            </div>
                                            <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                <i class="fa fa-edit data-right-rep-icon bg-grad-info"></i>
                                            </div>
                                        </div>
                                        <div class="progress-anim">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-grad-success 
                                                wow animated progress-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Por recibir-->
                <div class="col-sm-4 col-xs-12">
                    <div class="panel panel-default card-view pa-0">
                        <div class="panel-wrapper collapse in">
                            <div class="panel-body pa-0">
                                <div class="sm-data-box">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-xs-6 data-wrap-left">
                                                <span class="capitalize-font block">Por Recibir</span>
                                                <span class="txt-dark block"><span class="counter inline-block"><span class="counter-anim">{{ $count_recibir }}</span></span><span class="trand-icon inline-block txt-success"><i class="fa fa-pencil"></i></span></span>
                                            </div>
                                            <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                <i class="fa  fa-pencil data-right-rep-icon bg- bg-grad-info"></i>
                                            </div>
                                        </div>
                                        <div class="progress-anim">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-grad-success 
                                                wow animated progress-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Totales-->
                <div class="col-sm-4 col-xs-12">
                    <div class="panel panel-default card-view pa-0">
                        <div class="panel-wrapper collapse in">
                            <div class="panel-body pa-0">
                                <div class="sm-data-box">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-xs-6 data-wrap-left">
                                                <span class="capitalize-font block">Total Servicios</span>
                                                <span class="txt-dark block"><span class="counter inline-block"><span class="counter-anim">{{ $count_autorizar + $count_recibir }}</span></span><span class="trand-icon inline-block txt-success"><i class="fa fa-chevron-up"></i></span></span>
                                            </div>
                                            <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                <i class="zmdi zmdi-time data-right-rep-icon bg-grad-info"></i>
                                            </div>
                                        </div>
                                        <div class="progress-anim">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-grad-success 
                                                wow animated progress-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /Contadores -->

    <!-- Lista Servicios -->
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <div class="panel panel-default border-panel card-view panel-refresh">
                <div class="refresh-container">
                    <div class="la-anim-1"></div>
                </div>
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Lista de Servicios</h6>
                    </div>
                    <div class="pull-right">
                        <a href="#" class="pull-left inline-block refresh mr-15">
                            <i class="zmdi zmdi-replay"></i>
                        </a>
                        <a href="#" class="pull-left inline-block full-screen mr-15">
                            <i class="zmdi zmdi-fullscreen"></i>
                        </a>
                        <div class="pull-left inline-block dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                            <ul class="dropdown-menu bullet dropdown-menu-right"  role="menu">
                                <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>option 1</a></li>
                                <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>option 2</a></li>
                                <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>option 3</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body row pa-0">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table id="datable_1" class="table  display table-hover border-none">
                                    <thead>
                                        <tr>
                                            <th>Tipo</th>
                                            <th># Documento</th>
                                            <th>Estado</th>
                                            <th>Placa</th>
                                            <th>Movil</th>
                                            <th>Fecha</th>
                                            <th>Ver</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        
                                        @foreach ($servicios as $servicio)                                        
                                            <tr>
                                                <td>{{ $servicio->tipo }}</td>

                                                @if ($servicio->tipo == 'Valoración'  && $servicio->estado == 1)
                                                    <td>{{ $servicio->id}}</td>
                                                    <td>
                                                        <span class="label label-warning">autorizar</span>
                                                    </td>
                                                @else
                                                    <td>{{ $servicio->numero_orden_trabajo}}</td>
                                                    <td>
                                                        <span class="label label-success">recibir</span>
                                                    </td>
                                                @endif

                                                <td>{{ $servicio->placa}}</td>
                                                <td>{{ $servicio->movil}}</td>
                                                <td>{{ $servicio->created_at}}</td>
                                                <td>
                                                    @if ($servicio->tipo == 'Valoración'  && $servicio->estado == 1)
                                                        <a href="{{ route('gestion-operativa.show', $servicio->id) }}">
                                                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('gestion-operativa.calidad', $servicio->id) }}">
                                                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>	
                    </div>	
                </div>
            </div>
        </div>        
    </div>
    <!-- /Lista Servicios -->

@endsection

@section('scripts')

    <script src="{{ asset('vendors//bower_components/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('vendors/bower_components/jquery.counterup/jquery.counterup.min.js') }}"></script>

@endsection