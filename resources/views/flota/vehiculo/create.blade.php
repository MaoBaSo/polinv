{{-- **************************************** --}}
{{-- ***GESTION DE VEHICULOS --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Noviembre de 2.022 --}}
{{-- **************************************** --}}

@extends('layouts.template')

@section('estilos')
    <!-- Bootstrap Dropify CSS -->
    <link rel="stylesheet" href="{{ asset('vendors/bower_components/dropify/dist/css/dropify.min.css' )}}">
@endsection


@section('menu')

    @include('layouts._menuAdministrador')

@endsection


@section('contenido')

    <!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Gestión de Vehículos</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Vehículos</a></li>
                <li><a href="#"><span>FLT. Gestión Vehículos</span></a></li>
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
                        <h6 class="panel-title txt-dark">Nuevo Vehículo</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <form method="POST" action="{{ route('flota.store') }}" ccept-charset="UTF-8"  enctype="multipart/form-data">
                                @csrf

                                <div class="row mb-15">
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left">Cliente *</label>
                                        <select class="form-control" id="cliente_id" name="cliente_id">
                                            <option value="">Elija un Cliente</option>
                                            @foreach($clientes as $id=>$nombre)
                                            <option value="{{ $id }}">{{ $nombre}}</option>
                                            @endforeach
                                        </select>                                            
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left">Patio *</label>
                                        <select class="form-control" id="patio_id" name="patio_id">
                                            <option value="">Elija un Patio</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-15">
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="placa">Placa *</label>
                                        <input type="text" class="form-control" id="placa" name="placa" required value="{{ old('placa') }}">                                               
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="numero_motor">Número Motor</label>
                                        <input type="text" class="form-control" id="numero_motor" name="numero_motor" value="{{ old('numero_motor') }}">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="numero_chasis">Número Chasis</label>
                                        <input type="text" class="form-control" id="numero_chasis" name="numero_chasis"  value="{{ old('numero_chasis') }}">
                                    </div>
                                </div> 

                                <div class="row mb-15">
                                    <div class="col-sm-3">
                                        <!--Tipo combustible-->
                                        <label class="control-label mb-10 text-left">Tipo Combustible *</label>
                                        <select class="form-control" id="tipo_combustible" name="tipo_combustible" required>
                                            <option value="">Elija Tipo</option>
                                            @foreach( $tipo_combustible as $key => $value )
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <!--Tipo combustible-->
                                    </div>
                                    <div class="col-sm-3">
                                        <!--Tipo servicio-->
                                        <label class="control-label mb-10 text-left">Tipo Servicio *</label>
                                        <select class="form-control" id="tipo_servicio" name="tipo_servicio" required>
                                            <option value="">Elija Tipo</option>
                                            @foreach( $tipo_servicio as $key => $value )
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <!--CTipo servicio-->
                                    </div>
                                    <div class="col-sm-3">
                                        <!--Tipo Vehículo-->
                                        <label class="control-label mb-10 text-left">Tipo Vehículo *</label>
                                        <select class="form-control" id="tipo_vehiculo" name="tipo_vehiculo" required>
                                            <option value="">Elija Tipo</option>
                                            @foreach( $tipo_vehiculo as $key => $value )
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <!--CTipo Vehículo-->
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label mb-10 text-left" for="valor_inventario">valor inventario</label>
                                        <input type="text" class="form-control" id="valor_inventario" name="valor_inventario">                                               
                                    </div>
                                </div> 

                                <div class="row mb-15">
                                    <div class="col-sm-3">
                                        <label class="control-label mb-10 text-left" for="modelo">Modelo</label>
                                        <input type="text" class="form-control" id="modelo" name="modelo" value="{{ old('modelo') }}">                                               
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label mb-10 text-left" for="cilindrada">Cilindrada</label>
                                        <input type="cilindrada" class="form-control" id="cilindrada" name="cilindrada" value="{{ old('cilindrada') }}">
                                    </div>

                                    <div class="col-sm-3">
                                        <label class="control-label mb-10 text-left" for="color">Color</label>
                                        <input type="text" class="form-control" id="color" name="color">
                                    </div>

                                    <div class="col-sm-3">
                                        <label class="control-label mb-10 text-left" for="movil">Número Móvil</label>
                                        <input type="text" class="form-control" id="movil" name="movil">
                                    </div>
                                </div> 

                                <div class="row mb-15">
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="capacidad_toneladas">Capacidad Toneladas</label>
                                        <input type="text" class="form-control" id="capacidad_toneladas" name="capacidad_toneladas">                                               
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="cantidad_ejes">Cantidad de ejes</label>
                                        <input type="text" class="form-control" id="cantidad_ejes" name="cantidad_ejes">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="capacidad_pasajeros">Capacidad de pasajeros</label>
                                        <input type="text" class="form-control" id="capacidad_pasajeros" name="capacidad_pasajeros">
                                    </div>
                                </div> 

                                <div class="row mb-15">
                                    <div class="col-sm-6">
                                        <!--Ciudad matricula-->
                                        <label class="control-label mb-10 text-left">Ciudad Matricula</label>
                                        <select class="form-control" id="ciudad_matricula" name="ciudad_matricula">
                                            <option value="">Elija una ciudad</option>
                                            @foreach( $ciudades as $key => $value )
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <!--Ciudad-->
                                    </div>
                                    <div class="col-sm-6">
                                        <!--Ciudad Rodamiento-->
                                        <label class="control-label mb-10 text-left">Ciudad Rodamiento</label>
                                        <select class="form-control" id="ciudad_rodamiento" name="ciudad_rodamiento">
                                            <option value="">Elija una ciudad</option>
                                            @foreach( $ciudades as $key => $value )
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <!--Ciudad-->
                                    </div>
                                </div> 

                                <div class="row mb-15">
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10" for="vencimiento_impuesto">vencimiento impuesto *</label>
                                        <input type="date" class="form-control" id="vencimiento_impuesto" name="vencimiento_impuesto" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10" for="vencimiento_tm">vencimiento tm *</label>
                                        <input type="date" class="form-control" id="vencimiento_tm" name="vencimiento_tm" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10" for="vencimiento_soat">vencimiento soat *</label>
                                        <input type="date" class="form-control" id="vencimiento_soat" name="vencimiento_soat" required>
                                    </div>
                                </div> 

                                <div class="row mb-15">
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10" for="vencimiento_seguro_1">vencimiento seguro 1</label>
                                        <input type="date" class="form-control" id="vencimiento_seguro_1" name="vencimiento_seguro_1">
                                    </div>

                                    <div class="col-sm-4">
                                        <label class="control-label mb-10" for="vencimiento_seguro_2">vencimiento seguro 2</label>
                                        <input type="date" class="form-control" id="vencimiento_seguro_2" name="vencimiento_seguro_2">
                                    </div>

                                    <div class="col-sm-4">
                                        <label class="control-label mb-10" for="vencimiento_seguro_3">vencimiento seguro 3</label>
                                        <input type="date" class="form-control" id="vencimiento_seguro_3" name="vencimiento_seguro_3">
                                    </div>
                                </div> 

                                <!--Carga de imagenes-->
                                <!-- Row -->
                                <br>
                                <div class="row mt-30 mb-30" >
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input class="dropify"  data-max-file-size="10M" data-allowed-file-extensions="jpg jpeg" data name="files[]" type="file">
                                            </div>
                                            <div class="col-sm-6">
                                                <input class="dropify"  data-max-file-size="10M" data-allowed-file-extensions="jpg jpeg" data name="files[]" type="file">
                                            </div>
                                        </div>
                                    </div>	
                                </div>
                                <!-- /Row -->
                                <div class="row mt-30 mb-30" >
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input class="dropify"  data-max-file-size="10M" data-allowed-file-extensions="jpg jpeg" data name="files[]" type="file">
                                            </div>
                                            <div class="col-sm-6">
                                                <input class="dropify"  data-max-file-size="10M" data-allowed-file-extensions="jpg jpeg" data name="files[]" type="file">
                                            </div>
                                        </div>
                                    </div>	
                                </div>
                                <!-- /Row -->
                                
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left">Notas</label>
                                    <textarea class="form-control" rows="4" id="notas" name="notas"></textarea>
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

    <script src="{{ asset('vendors/bower_components/dropify/dist/js/dropify.min.js' )}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
        $('.dropify').dropify({

            messages: {
                'default': 'Arrastra la imagen o da clic para elegir',
                'replace': 'Arrastra la imagen o da clic para reemplazar',
                'remove':  'Eliminar',
                'error':   'Ooops, hay un problema con tu imagen.'
            }

        });
        });
    </script>

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