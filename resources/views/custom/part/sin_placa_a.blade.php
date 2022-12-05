<?php 
/*
    <div class="col-sm-3">
        <label class="control-label mb-10" for="valor_registro">Valor del servicio</label>
        <input type="text" style="background-color: white; border:solid; border-width: 1px;" class="form-control filled-input text-success" id="valor_registro" name="valor_registro"  value="{{ number_format(Miscellany::getValServicio($servicio->id), 2, ',', '.') }}">
    </div>
    <div class="col-sm-2">
        <label class="control-label mb-10" for="placa">Placa Vehículo</label>
        <input type="text" style="background-color: white; border:solid; border-width: 1px;" class="form-control filled-input" id="placa" name="placa"  value="{{ $servicio->placa }}">
    </div>
    <div class="col-sm-3">
        <label class="control-label mb-10" for="movil">Movil Vehículo</label>
        <input type="text" style="background-color: white; border:solid; border-width: 1px;" class="form-control filled-input" id="placa" name="placa"  value="{{ $servicio->movil }}">
    </div>
    <div class="col-sm-4">
        <label class="control-label mb-10" for="placa">Numero Documento</label>
        <input type="text" style="background-color: white; border:solid; border-width: 1px;" class="form-control filled-input" id="orden_trabajo" name="orden_trabajo"  value="{{ $servicio->numero_orden_trabajo }}">
    </div>
*/
?>

<!--OT: 260522-012, Toma de servicio no requiere PLACA del vehiculo-->
<div class="col-sm-4">
    <label class="control-label mb-10" for="valor_registro">Valor del servicio</label>
    <input type="text" style="background-color: white; border:solid; border-width: 1px;" class="form-control filled-input text-success" id="valor_registro" name="valor_registro"  value="{{ number_format(Miscellany::getValServicio($servicio->id), 2, ',', '.') }}">
</div>
<div class="col-sm-4">
    <label class="control-label mb-10" for="movil">Movil Vehículo</label>
    <input type="text" style="background-color: white; border:solid; border-width: 1px;" class="form-control filled-input" id="placa" name="placa"  value="{{ $servicio->movil }}">
</div>
<div class="col-sm-4">
    <label class="control-label mb-10" for="placa">Numero Documento</label>
    <input type="text" style="background-color: white; border:solid; border-width: 1px;" class="form-control filled-input" id="orden_trabajo" name="orden_trabajo"  value="{{ $servicio->numero_orden_trabajo }}">
</div>