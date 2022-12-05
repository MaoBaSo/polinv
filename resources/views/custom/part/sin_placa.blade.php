<?php 
/*
    <div class="form-group">
        <label class="control-label mb-10 text-left" for="valor_registro">Valor del servicio</label>
        <input type="text" class="form-control" id="valor_registro" name="valor_registro" disabled value="{{ $valor_procedimiento }}">
    </div> 

    <div class="row mb-10">
        <div class="col-sm-6">
            <label class="control-label mb-10 text-left" for="placa">Placa Vehículo *</label>
            <input type="text" class="form-control" id="placa" name="placa" required>
        </div>
        <div class="col-sm-6">
            <label class="control-label mb-10 text-left" for="movil">Movil Vehículo *</label>
            <input type="text" class="form-control" id="movil" name="movil" required>
        </div>
    </div>

*/
?>
<!--OT: 260522-012, Toma de servicio no requiere PLACA del vehiculo-->
<div class="row mb-10">
    <div class="col-sm-6">
        <label class="control-label mb-10 text-left" for="valor_registro">Valor del servicio</label>
        <input type="text" class="form-control" id="valor_registro" name="valor_registro" disabled value="{{ $valor_procedimiento }}">    
    </div>
    <div class="col-sm-6">
        <label class="control-label mb-10 text-left" for="movil">Movil Vehículo *</label>
        <input type="text" class="form-control" id="movil" name="movil" required>
    </div>
</div>


