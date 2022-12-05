{{-- **************************************** --}}
{{-- ***ETAPAS TECNICAS --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Abril de 2.022 --}}
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
            <h5 class="txt-dark">Gestión Técnica</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Operaciones</a></li>
            <li class="active"><span>OPT. Dashboard</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">

        @foreach ($list_empleados as $empleado)

            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default contact-card card-view">
                    <div class="panel-heading bg-grad-primary">
                        <div class="pull-left">
                            <div class="pull-left user-img-wrap mr-15">
                                <img class="card-user-img img-circle pull-left" src="{{ asset('img/user1.png') }}" alt="user"/>
                            </div>
                            <div class="pull-left user-detail-wrap">	
                                <span class="block card-user-name">
                                    {{ $empleado->primer_nombre }}&nbsp;&nbsp;{{ $empleado->primer_apellido }}
                                </span>
                                <span class="block card-user-desn">
                                    {{ Miscellany::getParameterId($empleado->especialidad_id)->variable_1 }}
                                </span>
                            </div>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('dashboard-operaciones.show', $empleado->id) }}" class="btn btn-default btn-sm"><span>GESTIONAR</span></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body row">
                            <div class="user-others-details pl-15 pr-15">
                                <div class="mb-15">
                                    <i class="fa-spin fa fa-cog inline-block mr-10 txt-warning"></i>
                                    <span class="inline-block txt-dark">{{ getCantServRecibir($empleado->id) }} ítems por recibir</span>
                                </div>
                                <div class="mb-15">
                                    <i class="fa-spin fa fa-spinner inline-block mr-10"></i>
                                    <span class="inline-block txt-dark">{{ getCantServCerrar($empleado->id) }} ítems por cerrar</span>
                                </div>
                            </div>
                            <hr class="light-grey-hr mt-20 mb-20"/>
                            <div class="emp-detail pl-15 pr-15">
                                <div class="mb-5">
                                    <span class="inline-block capitalize-font mr-5">OT más antigua:</span>

                                    @if(!is_null(getServAntiguo($empleado->id)))
                                        <span class="txt-dark">{{ getServAntiguo($empleado->id)->fecha_servicio }}</span>
                                    @else
                                        <span class="txt-dark"></span>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
          
    </div>
    <!-- Row -->

@endsection

@section('scripts')
@endsection