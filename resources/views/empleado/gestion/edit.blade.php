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
                <li class="active"><span>Edita</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->

    <!-- Row Form de Rol -->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-panel card-view">
                <div class="panel-heading">

                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Editar Empleado</h6>
                    </div>
                    <div class="pull-right">
                        <form action="{{ route('empleado.destroy', $empleado->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            
                            <div class="form-group text-center">
                                <button type="button" class="inline-block btn btn-danger btn-rounded btn-sm" data-toggle="modal" data-target="#confirmar" data-whatever="@getbootstrap">Eliminar Empleado</button>
                            </div>
    
                            <div class="modal fade" id="confirmar" tabindex="-1" role="dialog" aria-labelledby="confirmarLabel1">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h5 class="modal-title" id="confirmarLabel1">Confirmar proceso</h5>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Confirma la eliminación del empleado?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-danger btn-rounded">Confirmar Eliminación</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <form method="POST" action="{{ route('empleado.update', $empleado->id) }}">
                                @csrf
                                @method('PUT')
                             
                                <div class="row mb-10">
                                    <div class="col-sm-3">
                                        <label class="control-label mb-10 text-left" for="primer_nombre">Primer Nombre *</label>
                                        <input type="text" class="form-control" id="primer_nombre" name="primer_nombre" required value="{{ old('primer_nombre', $empleado->primer_nombre) }}">
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label mb-10 text-left" for="segundo_nombre">Segundo Nombre</label>
                                        <input type="text" class="form-control" id="segundo_nombre" name="segundo_nombre" value="{{ old('segundo_nombre', $empleado->segundo_nombre) }}">
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label mb-10 text-left" for="primer_apellido">Primer Apellido *</label>
                                        <input type="text" class="form-control" id="primer_apellido" name="primer_apellido" required value="{{ old('primer_apellido', $empleado->primer_apellido) }}">
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label mb-10 text-left" for="segundo_apellido">Segundo Apellido</label>
                                        <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido" value="{{ old('segundo_apellido', $empleado->segundo_apellido) }}">
                                    </div>
                                </div>

                                <div class="row mb-10">
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="identificacion"># Identificación *</label>
                                        <input type="text" class="form-control" id="identificacion" name="identificacion" required value="{{ old('identificacion', $empleado->identificacion) }}">                                        
                                    </div>
                                    <div class="col-sm-4">
                                        <!--Ciudad-->
                                            <label class="control-label mb-10 text-left">Ciudad *</label>
                                            <select class="form-control" id="ciudad_id" name="ciudad_id" required>
                                                <option value="">Elija una ciudad</option>
                                                @foreach( $ciudades as $key => $value )
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                    @if($empleado->ciudad_id == $key)
                                                        <option value="{{ $key }}" selected>{{ $value }}</option>
                                                    @else
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endif 
                                                @endforeach
                                            </select>                             
                                        <!--Ciudad-->
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="direccion">Direccion</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion', $empleado->direccion) }}">
                                    </div>
                                </div>

                                <div class="row mb-10">
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="telefono_1">Teléfono 1</label>
                                        <input type="text" class="form-control" id="telefono_1" name="telefono_1" value="{{ old('telefono_1', $empleado->telefono_1) }}">                                    
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="telefono_2">Teléfono 2</label>
                                        <input type="text" class="form-control" id="telefono_2" name="telefono_2" value="{{ old('telefono_2', $empleado->telefono_2) }}">
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
                                                    @if($empleado->especialidad_id == $key)
                                                        <option value="{{ $key }}" selected>{{ $value }}</option>
                                                    @else
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endif 
                                                @endforeach
                                            </select>                             
                                        <!--Especialidad-->
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="valor_hora">Valor hora</label>
                                        <input type="number" class="form-control" id="valor_hora" name="valor_hora" value="{{ old('valor_hora', $empleado->valor_hora) }}">
                                    </div>

                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="porcentaje_hora">Porcentaje hora</label>
                                        <input type="number" class="form-control" id="porcentaje_hora" name="porcentaje_hora" value="{{ old('porcentaje_hora', $empleado->porcentaje_hora) }}">
                                    </div>                                    

                                </div>                                

                                <!--Cliente-->
                                <div class="form-group mt-30 mb-30">
                                    <label class="control-label mb-10 text-left">Cliente *</label>
                                    <select class="form-control" id="cliente_id" name="cliente_id" required>
                                        <option value="">Elija un cliente</option>
                                        @foreach( $clientes as $key => $value )
                                            <option value="{{ $key }}">{{ $value }}</option>
                                            @if($empleado->cliente_id == $key)
                                                <option value="{{ $key }}" selected>{{ $value }}</option>
                                            @else
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endif 
                                        @endforeach
                                    </select>
                                </div>                                
                                <!--Cliente-->

                                <div class="row mb-10">
                                    <div class="col-sm-6">
                                        <!--Cliente-->
                                        <label class="control-label mb-10 text-left">Cliente *</label>
                                        <select class="form-control" id="cliente_id" name="cliente_id" required>
                                            <option value="">Elija un cliente</option>
                                            @foreach( $clientes as $key => $value )
                                                <option value="{{ $key }}">{{ $value }}</option>

                                                @if($empleado->cliente_id == $key)
                                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                                @else
                                                    <option value="{{ $key}}">{{ $value }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <!--Cliente-->
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left">Patio *</label>
                                        <select class="form-control" id="patio_id" name="patio_id" required>
                                            @foreach($patios as $id=>$patio)
                                                @if($empleado->patio_id == $id)
                                                    <option value="{{ $id }}" selected>{{ $patio }}</option>
                                                @else
                                                    <option value="{{ $id }}">{{ $patio }}</option>
                                                @endif
                                            @endforeach
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

@endsection