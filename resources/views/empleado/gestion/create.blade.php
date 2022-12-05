{{-- **************************************** --}}
{{-- ***GESTION DE EMPLEADOS --}}
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
            <h5 class="txt-dark">Gestión de Empleados</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Empleados</a></li>
                <li><a href="#"><span>EMP. Gestión Empleados</span></a></li>
                <li class="active"><span>Nuevo</span></li>
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
                        <h6 class="panel-title txt-dark">Nuevo Empleado</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <form method="POST" action="{{ route('empleado.store') }}">
                                @csrf

                                <div class="row mb-10">
                                    <div class="col-sm-3">
                                        <label class="control-label mb-10 text-left" for="primer_nombre">Primer Nombre *</label>
                                        <input type="text" class="form-control" id="primer_nombre" name="primer_nombre" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label mb-10 text-left" for="segundo_nombre">Segundo Nombre</label>
                                        <input type="text" class="form-control" id="segundo_nombre" name="segundo_nombre">
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label mb-10 text-left" for="primer_apellido">Primer Apellido *</label>
                                        <input type="text" class="form-control" id="primer_apellido" name="primer_apellido" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label mb-10 text-left" for="segundo_apellido">Segundo Apellido</label>
                                        <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido">
                                    </div>
                                </div>

                                <div class="row mb-10">
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="identificacion"># Identificación *</label>
                                        <input type="text" class="form-control" id="identificacion" name="identificacion" required>                                        
                                    </div>
                                    <div class="col-sm-4">
                                        <!--Ciudad-->
                                            <label class="control-label mb-10 text-left">Ciudad *</label>
                                            <select class="form-control" id="ciudad_id" name="ciudad_id" required>
                                                <option value="">Elija una ciudad</option>
                                                @foreach( $ciudades as $key => $value )
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>                             
                                        <!--Ciudad-->
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="direccion">Direccion</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion">
                                    </div>
                                </div>

                                <div class="row mb-10">
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="telefono_1">Teléfono 1</label>
                                        <input type="text" class="form-control" id="telefono_1" name="telefono_1">                                    
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="telefono_2">Teléfono 2</label>
                                        <input type="text" class="form-control" id="telefono_2" name="telefono_2">
                                    </div>
                                </div>

                                <div class="row mb-10">
                                    <div class="col-sm-4">
                                        <!--Especialidad-->
                                            <label class="control-label mb-10 text-left">Especialidad *</label>
                                            <select class="form-control" id="especialidad_id" name="especialidad_id" required>
                                                <option value="">Elija una especialidad</option>
                                                @foreach( $especialidad as $key => $value )
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>                             
                                        <!--Especialidad-->
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="valor_hora">Valor hora</label>
                                        <input type="number" class="form-control" id="valor_hora" name="valor_hora">
                                    </div>

                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="porcentaje_hora">Porcentaje hora</label>
                                        <input type="number" class="form-control" id="porcentaje_hora" name="porcentaje_hora">
                                    </div>                                    

                                </div>                                

                                <div class="row mb-10">
                                    <div class="col-sm-6">
                                        <!--Cliente-->
                                        <label class="control-label mb-10 text-left">Cliente *</label>
                                        <select class="form-control" id="cliente_id" name="cliente_id" required>
                                            <option value="">Elija un cliente</option>
                                            @foreach( $clientes as $key => $value )
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <!--Cliente-->
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left">Patio *</label>
                                        <select class="form-control" id="patio_id" name="patio_id" required>
                                            <option value="">Elija un Patio</option>
                                        </select>
                                    </div>
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
    <script type="text/javascript">
        $("#cliente_id").change(function(event){
        $.get("{{ url('patios')}}"+"/"+event.target.value+"", function(response,state ){
            $("#patio_id").empty();
            for(i=0; i<response.length; i++){
            $("#patio_id").append("<option value='"+response[i].id+"'> "+response[i].nombre+"</option>");
            }
        });
        });
    </script>
@endsection