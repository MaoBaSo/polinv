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
                        <h6 class="panel-title txt-dark">Editar Vehículo</h6>
                    </div>

                    <div class="pull-right">

                        <form action="{{ route('flota.destroy', $vehiculo->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            
                            <div class="form-group text-center">
                                <button type="button" class="inline-block btn btn-danger btn-rounded btn-sm" data-toggle="modal" data-target="#confirmar" data-whatever="@getbootstrap">Eliminar Vehículo</button>
                            </div>
    
                            <div class="modal fade" id="confirmar" tabindex="-1" role="dialog" aria-labelledby="confirmarLabel1">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h5 class="modal-title" id="confirmarLabel1">Confirmar proceso</h5>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Confirma la eliminación del registro?</p>
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
                            <form method="POST" action="{{ route('flota.update', $vehiculo->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="row mb-15">
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left">Cliente *</label>
                                        <select class="form-control" id="cliente_id" name="cliente_id">
                                            <option value="">Elija un Cliente</option>
                                            @foreach($clientes as $id=>$nombre)
                                                @if($vehiculo->cliente_id == $id)
                                                    <option value="{{ $id }}" selected>{{ $nombre}}</option>
                                                @endif 
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label mb-10 text-left">Patio *</label>
                                        <select class="form-control" id="patio_id" name="patio_id">
                                            @foreach($patios as $id=>$nombre)
                                                @if($vehiculo->patio_id == $id)
                                                    <option value="{{ $id }}" selected>{{ $nombre}}</option>
                                                @endif 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-15">
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="placa">Placa *</label>
                                        <input type="text" class="form-control" id="placa" name="placa" required value="{{ old('placa', $vehiculo->placa) }}">                                               
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="numero_motor">Número Motor</label>
                                        <input type="text" class="form-control" id="numero_motor" name="numero_motor" value="{{ old('numero_motor', $vehiculo->numero_motor) }}">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="numero_chasis">Número Chasis</label>
                                        <input type="text" class="form-control" id="numero_chasis" name="numero_chasis"  value="{{ old('numero_chasis', $vehiculo->numero_chasis) }}">
                                    </div>
                                </div> 

                                <div class="row mb-15">
                                    <div class="col-sm-3">
                                        <!--Tipo combustible-->
                                        <label class="control-label mb-10 text-left">Tipo Combustible *</label>
                                        <select class="form-control" id="tipo_combustible" name="tipo_combustible" required>
                                            <option value="">Elija Tipo</option>
                                            @foreach( $tipo_combustible as $key => $value )
                                                @if($vehiculo->tipo_combustible == $key)
                                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                                @else
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endif 
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
                                                @if($vehiculo->tipo_servicio == $key)
                                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                                @else
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endif 
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
                                                @if($vehiculo->tipo_vehiculo == $key)
                                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                                @else
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endif 
                                            @endforeach
                                        </select>
                                        <!--CTipo Vehículo-->
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label mb-10 text-left" for="valor_inventario">valor inventario</label>
                                        <input type="text" class="form-control" id="valor_inventario" name="valor_inventario"  value="{{ old('valor_inventario', $vehiculo->valor_inventario) }}">                                               
                                    </div>
                                </div> 

                                <div class="row mb-15">
                                    <div class="col-sm-3">
                                        <label class="control-label mb-10 text-left" for="modelo">Modelo</label>
                                        <input type="text" class="form-control" id="modelo" name="modelo" value="{{ old('modelo', $vehiculo->modelo) }}">                                               
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label mb-10 text-left" for="cilindrada">Cilindrada</label>
                                        <input type="cilindrada" class="form-control" id="cilindrada" name="cilindrada" value="{{ old('cilindrada', $vehiculo->cilindrada) }}">
                                    </div>

                                    <div class="col-sm-3">
                                        <label class="control-label mb-10 text-left" for="color">Color</label>
                                        <input type="text" class="form-control" id="color" name="color"  value="{{ old('color', $vehiculo->color) }}">
                                    </div>

                                    <div class="col-sm-3">
                                        <label class="control-label mb-10 text-left" for="movil">Número Móvil</label>
                                        <input type="text" class="form-control" id="movil" name="movil" value="{{ old('movil', $vehiculo->movil) }}">
                                    </div>
                                </div> 

                                <div class="row mb-15">
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="capacidad_toneladas">Capacidad Toneladas</label>
                                        <input type="text" class="form-control" id="capacidad_toneladas" name="capacidad_toneladas" value="{{ old('capacidad_toneladas', $vehiculo->capacidad_toneladas) }}">                                               
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="cantidad_ejes">Cantidad de ejes</label>
                                        <input type="text" class="form-control" id="cantidad_ejes" name="cantidad_ejes" value="{{ old('cantidad_ejes', $vehiculo->cantidad_ejes) }}">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10 text-left" for="capacidad_pasajeros">Capacidad de pasajeros</label>
                                        <input type="text" class="form-control" id="capacidad_pasajeros" name="capacidad_pasajeros" value="{{ old('capacidad_pasajeros', $vehiculo->capacidad_pasajeros) }}">
                                    </div>
                                </div> 

                                <div class="row mb-15">
                                    <div class="col-sm-6">
                                        <!--Ciudad matricula-->
                                        <label class="control-label mb-10 text-left">Ciudad Matricula</label>
                                        <select class="form-control" id="ciudad_matricula" name="ciudad_matricula">
                                            <option value="">Elija una ciudad</option>
                                            @foreach( $ciudades as $key => $value )
                                                @if($vehiculo->ciudad_matricula == $key)
                                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                                @else
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endif 
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
                                                @if($vehiculo->ciudad_rodamiento == $key)
                                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                                @else
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endif 
                                            @endforeach
                                        </select>
                                        <!--Ciudad-->
                                    </div>
                                </div> 

                                <div class="row mb-15">
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10" for="vencimiento_impuesto">vencimiento impuesto *</label>
                                        <input type="date" class="form-control" id="vencimiento_impuesto" name="vencimiento_impuesto" required value="{{ old('vencimiento_impuesto', $vehiculo->vencimiento_impuesto) }}">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10" for="vencimiento_tm">vencimiento tm *</label>
                                        <input type="date" class="form-control" id="vencimiento_tm" name="vencimiento_tm" required value="{{ old('vencimiento_tm', $vehiculo->vencimiento_tm) }}">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10" for="vencimiento_soat">vencimiento soat *</label>
                                        <input type="date" class="form-control" id="vencimiento_soat" name="vencimiento_soat" required value="{{ old('vencimiento_soat', $vehiculo->vencimiento_soat) }}">
                                    </div>
                                </div> 

                                <div class="row mb-15">
                                    <div class="col-sm-4">
                                        <label class="control-label mb-10" for="vencimiento_seguro_1">vencimiento seguro 1</label>
                                        <input type="date" class="form-control" id="vencimiento_seguro_1" name="vencimiento_seguro_1" value="{{ old('vencimiento_seguro_1', $vehiculo->vencimiento_seguro_1) }}">
                                    </div>

                                    <div class="col-sm-4">
                                        <label class="control-label mb-10" for="vencimiento_seguro_2">vencimiento seguro 2</label>
                                        <input type="date" class="form-control" id="vencimiento_seguro_2" name="vencimiento_seguro_2" value="{{ old('vencimiento_seguro_2', $vehiculo->vencimiento_seguro_2) }}">
                                    </div>

                                    <div class="col-sm-4">
                                        <label class="control-label mb-10" for="vencimiento_seguro_3">vencimiento seguro 3</label>
                                        <input type="date" class="form-control" id="vencimiento_seguro_3" name="vencimiento_seguro_3" value="{{ old('vencimiento_seguro_3', $vehiculo->vencimiento_seguro_3) }}">
                                    </div>
                                </div> 

                                <!--GESTION DE IMAGENES-->
                                <hr>
                                <!--Carga de imagenes actuales-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-default card-view">
                                            <div class="panel-heading">
                                                <div class="pull-left">
                                                    <h6 class="panel-title txt-dark">Imagenes Actuales</h6>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="panel-wrapper collapse in">
                                                <div class="panel-body">
                                                    <div class="gallery-wrap">
                                                        <div class="portfolio-wrap project-gallery">
                                                            <ul id="portfolio_1" class="portf auto-construct  project-gallery" data-col="4">

                                                                    @foreach($imagenes as $imagen)
                                                                        
                                                                        <li class="item" data-src="{{ asset($imagen->url . $imagen->nombre_archivo) }}" data-sub-html="
                                                                                <h6>Img: {{$imagen->nombre_archivo}}</h6>
                                                                                <p>                                                                        
                                                                                    <a href='{{ route('flota-imagen.delete', [$imagen->id,  $vehiculo->id] ) }}'>
                                                                                        <button class='btn btn-danger btn-anim'><i class='fa fa-trash-o'></i><span class='btn-text'>Borrar</span></button>
                                                                                    </a>
                                                                                </p>
                                                                                ">

                                                                            <a href="">
                                                                            <img class="img-responsive" src="{{ asset($imagen->url . $imagen->nombre_archivo) }}"  alt="Image description" />	
                                                                            <span class="hover-cap">{{$vehiculo->placa}}</span>
                                                                            </a>
                                                                        </li>
                                                                    @endforeach   

                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                         
                                <!--/Carga de imagenes actuales-->

                                <!--Sube Nueva Imagen-->
                                <div class="form-group">
                                    <button type="button" class="inline-block btn btn-primary btn-sm" data-toggle="modal" data-target="#nueva_img" data-whatever="@getbootstrap">Nueva Imagen</button>
                                </div>
                                <div class="modal fade" id="nueva_img" tabindex="-1" role="dialog" aria-labelledby="nueva_imgLabel1">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h5 class="modal-title" id="nueva_imgLabel1">Agregar Imagen</h5>
                                            </div>
                                            <div class="modal-body">

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

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/Sube Nueva Imagen-->
                                
                                <hr>
                                <!--/GESTION DE IMAGENES-->

                                <div class="form-group">
                                    <label class="control-label mb-10 text-left">Notas</label>
                                    <textarea class="form-control" rows="4" id="notas" name="notas">{{ $vehiculo->nota }}</textarea>
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

    <!-- Gallery JavaScript -->
    <script src="{{ asset('dist/js/isotope.js') }}"></script>
    <script src="{{ asset('dist/js/lightgallery-all.js') }}"></script>
    <script src="{{ asset('dist/js/froogaloop2.min.js') }}"></script>
    <script src="{{ asset('dist/js/gallery-data.js') }}"></script>

@endsection