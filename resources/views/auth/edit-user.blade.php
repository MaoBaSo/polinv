{{-- **************************************** --}}
{{-- ***Panel de SUPER USUARIO / Edita Usuario --}}
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
            <h5 class="txt-dark">Gestión de Usuarios</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="index.html">Sistema</a></li>
            <li><a href="#"><span>SEG. Gestión Usuarios</span></a></li>
            <li class="active"><span>Ver</span></li>
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
                        <h6 class="panel-title txt-dark">Ver Usuario</h6>
                    </div>
                    <div class="pull-right">
                        <form action="{{ route('gestion-usuarios.destroy',$usuario->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-block btn btn-danger btn-sm">Eliminar Usuario</button>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <div class="mb-20">
                                @if($tiene_token)
                                    <form action="{{ route('gestion-tokens.destroy',$usuario->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-block btn btn-danger btn-sm">Eliminar TOKEN</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('gestion-tokens.store') }}">    
                                        @csrf
                                        <input id="user_id" name="user_id" type="hidden" value="{{ $usuario->id }}">
                                        <button type="submit" class="inline-block btn btn-primary btn-sm">Crear TOKEN</button>
                                    </form> 
                                @endif                                
                            </div>
                            <hr>
                            <form method="POST" action="{{ route('gestion-usuarios.update', $usuario->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="row mb-15">
                                    <div class="col-sm-6">
                                        <label class="control-label text-left" for="name">Nombre de Usuario *</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $usuario->name) }}">                                                
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label text-left" for="email">Email *</label>
                                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $usuario->email) }}">
                                    </div>
                                </div>                                    

                                <div class="row mb-15">
                                    <div class="col-sm-4">
                                        <fieldset readonly onmousedown="return false;">
                                        <label class="control-label mb-10 text-left">Pais *</label>
                                        <select class="form-control" id="pais_id" name="pais_id" required>
                                            <option value="">Elija un Pais</option>
                                            @foreach( $paises as $key => $value )
                                                @if($usuario->pais_id == $key)
                                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                                @else
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endif
                                            @endforeach
                                        </select> 
                                        </fieldset>
                                        <span style="font-size: 9px;">Campo NO editable por integridad de datos.</span>                                              
                                    </div>
                                        <div class="col-sm-4">
                                            <fieldset readonly onmousedown="return false;">
                                            <label class="control-label mb-10 text-left">Tipo Usuario *</label>
                                            <select class="form-control" id="tipo_id" name="tipo_id">
                                                @foreach($tipos_usuarios as $variable1=>$variable2)
                                                    @if($usuario->tipo_id == $variable2)
                                                        <option value="{{ $variable1 }}" selected>{{ $variable2 }}</option>
                                                    @else
                                                        <option value="{{ $variable1 }}">{{ $variable2 }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            </fieldset>
                                            <span style="font-size: 9px;">Campo NO editable por integridad de datos.</span>                                              
                                        </div>
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left">Rol *</label>
                                        <select class="form-control" id="rol_id" name="rol_id">
                                            @foreach($roles as $id=>$nombre)
                                                @if($usuario->rol_id == $nombre)
                                                    <option value="{{ $nombre }}" selected>{{ $id }}</option>
                                                @else
                                                    <option value="{{ $nombre }}">{{ $id }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>    

                                <div class="row mb-15">
                                    <div class="col-sm-6">
                                        <fieldset readonly onmousedown="return false;">
                                        <label class="control-label mb-10 text-left">Cliente</label>
                                        <select class="form-control" id="company_id" name="company_id">
                                            <option value="">Elija un Cliente</option>
                                            @foreach($clientes as $id=>$nombre)
                                                @if($usuario->company_id == $id)
                                                    <option value="{{ $id }}" selected>{{ $nombre }}</option>
                                                @else
                                                    <option value="{{ $id }}">{{ $nombre }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        </fieldset> 
                                        <span style="font-size: 9px;">Campo NO editable por integridad de datos.</span>                                           
                                    </div>
                                    <div class="col-sm-6">
                                        <fieldset readonly onmousedown="return false;">
                                        <label class="control-label mb-10 text-left">Patio</label>
                                        <select class="form-control" id="patio_id" name="patio_id">
                                            <option value="">Elija un Patio</option>
                                            @foreach($patios as $id=>$patio)
                                                @if($usuario->patio_id == $id)
                                                    <option value="{{ $id }}" selected>{{ $patio }}</option>
                                                @else
                                                    <option value="{{ $id }}">{{ $patio }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        </fieldset>
                                        <span style="font-size: 9px;">Campo NO editable por integridad de datos.</span>
                                    </div>
                                </div>  
                                <hr>
                                <span>Atención: modifica el Password del usuario.</span>
                                <br><br>
                                <div class="row mb-20">
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="password">Password</label>
                                        <input type="text" class="form-control" id="password" name="password">                                              
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left" for="password_confirmation">Confirme Password</label>
                                        <input type="text" class="form-control" id="password_confirmation" name="password_confirmation">
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