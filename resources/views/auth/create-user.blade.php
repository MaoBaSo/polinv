{{-- **************************************** --}}
{{-- ***Panel de SUPER USUARIO / Crear nuevo Usuario --}}
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
                        <h6 class="panel-title txt-dark">Nuevo Usuario</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <form method="POST" action="{{ route('gestion-usuarios.store') }}">
                                    @csrf

                                    <div class="row mb-15">
                                        <div class="col-sm-6">
                                            <label class="control-label text-left" for="name">Nombre de Usuario *</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">                                                
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="control-label text-left" for="email">Email *</label>
                                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
                                        </div>
                                    </div>                                    

                                    <div class="row mb-15">
                                        <div class="col-sm-4">
                                            <label class="control-label mb-10 text-left">Pais *</label>
                                            <select class="form-control" id="pais_id" name="pais_id" required>
                                                <option value="">Elija un Pais</option>
                                                @foreach( $paises as $key => $value )
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>                                               
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label mb-10 text-left">Tipo Usuario *</label>
                                            <select class="form-control" id="tipo_id" name="tipo_id">
                                                <option value="">Elija un tipo usuario</option>
                                                @foreach($tipos_usuarios as $variable1=>$id)
                                                    <option value="{{ $variable1 }}">{{ $id }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-4">
                                            <label class="control-label mb-10 text-left">Rol *</label>
                                            <select class="form-control" id="rol_id" name="rol_id">
                                                <option value="">Elija un Rol</option>
                                                @foreach($roles as $id=>$nombre)
                                                    <option value="{{ $nombre }}">{{ $id }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>    

                                    <div class="row mb-15">
                                        <div class="col-sm-6">
                                            <label class="control-label mb-10 text-left">Cliente</label>
                                            <select class="form-control" id="company_id" name="company_id">
                                                <option value="">Elija un Cliente</option>
                                                @foreach($clientes as $id=>$nombre)
                                                <option value="{{ $id }}">{{ $nombre}}</option>
                                                @endforeach
                                            </select>                                            
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="control-label mb-10 text-left">Patio</label>
                                            <select class="form-control" id="patio_id" name="patio_id">
                                                <option value="">Elija un Patio</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <hr>
                                    <div class="row mb-20">
                                        <div class="col-sm-6">
                                            <label class="control-label mb-10 text-left" for="password">Password *</label>
                                            <input type="text" class="form-control" id="password" name="password" required>                                              
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="control-label mb-10 text-left" for="password_confirmation">Confirme Password *</label>
                                            <input type="text" class="form-control" id="password_confirmation" name="password_confirmation" required>
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
        $("#company_id").change(function(event){
        $.get("{{ url('patios')}}"+"/"+event.target.value+"", function(response,state ){
            $("#patio_id").empty();
            for(i=0; i<response.length; i++){
            $("#patio_id").append("<option value='"+response[i].id+"'> "+response[i].nombre+"</option>");
            }
        });
        });
    </script>

@endsection