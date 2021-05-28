<form id="frm-usr">
    <div class="form-group">
        <label for="id">ID</label>
        <input id='id_usuario' name="id" type="number" class="form-control" aria-describedby="id_usuario"
        placeholder="Id del usuarios." disabled>
    </div>
    <div class="form-group">
        <label for="grupo">Grupo Asignado</label>
        <select class="form-control" id="id_grupo">

        <?php foreach($grupos as $datos) { ?>
            <option value="<?php echo $datos['ID_GRUPO']; ?>"><?php echo $datos['NOMBRE']; ?></option>
        <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="nombre_usuario">Nombre de Usuarios</label>
        <input id="nombre_usuario" name="nombre_usuario" type="text" class="form-control" aria-describedby="nombre_usuario"
        placeholder="Ej. edmundo">
    </div>
    <div class="form-group">
        <label for="contra">Contraseña</label>
        <input id="contra" name="contra" type="password" class="form-control" aria-describedby="contra"
        placeholder="">
    </div>
    <div class="form-group">
        <label for="fecha_creacion">Fecha de Creacion</label>
        <input id="fecha_creacion" name="fecha_creacion" type="date" class="form-control" aria-describedby="fecha_creacion"
        placeholder="" disabled pattern="[0-9]{2}/[0-9]{2}/[0-9]{2}">
    </div>
    <div class="form-group">
        <label for="max_monto_cheque">Monto Maximo</label>
        <input id="max_monto_cheque" name="max_monto_cheque" type="number" class="form-control" aria-describedby="max_monto_cheque"
        placeholder="Ej. 10.00">
    </div>
</form>