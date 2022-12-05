{{-- **************************************** --}}
{{-- ***Panel de CLIENTE --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Enero de 2.022 --}}
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

    <!-- Lista Servicios -->
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <div class="panel panel-default border-panel card-view panel-refresh">
                <div class="refresh-container">
                    <div class="la-anim-1"></div>
                </div>
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Lista de Servicios Encontrados</h6>
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
                                            <th>#Cotización</th>
                                            <th>#Orden Trabajo</th>
                                            <th>#Orden Compra</th>
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
                                                <td>{{ $servicio->id }}</td>
                                                <td>{{ $servicio->numero_orden_trabajo }}</td>
                                                <td>{{ $servicio->numero_orden_compra }}</td>
                                                <td>{{ Miscellany::getEstadoServicio($servicio->estado) }}</td>
                                                <td>{{ $servicio->placa}}</td>
                                                <td>{{ $servicio->movil}}</td>
                                                <td>{{ $servicio->fecha_servicio}}</td>
                                                <td>
                                                    <a href="{{ route('buscar-servicios.show', $servicio->id) }}">
                                                        <i class="fa fa-file-text-o" aria-hidden="true"></i>
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
            </div>
        </div>        
    </div>
    <!-- /Lista Servicios -->

@endsection

@section('scripts')

    <script src="{{ asset('vendors//bower_components/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('vendors/bower_components/jquery.counterup/jquery.counterup.min.js') }}"></script>

@endsection