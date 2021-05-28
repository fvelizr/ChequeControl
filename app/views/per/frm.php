<form id="frm-per">
    <div class="form-group">
        <label for="cui">CUI</label>
        <select class="form-control" id='id_persona'>
            <option values="0">Crear</option>
            <?php
                foreach($personas AS $datos){
                    ?><option value="<?php echo $datos['ID_PERSONA']; ?>"><?php echo $datos['CUI']; ?></option><?php
                }
            ?>
            <input id="cui" name="cui" type="number" class="form-control" aria-describedby="cui"
            placeholder="Ej. 3134599910501">        
        </select>
    </div>
    <div class="form-group">
        <label for="primer_nombre">Primer Nombre</label>
        <input id="primer_nombre" name="primer_nombre" type="text" class="form-control" aria-describedby="primer_nombre"
        placeholder="Ej. Edmundo">
    </div>
    <div class="form-group">
        <label for="segundo_nombre">Segundo Nombre</label>
        <input id="segundo_nombre" name="segundo_nombre" type="text" class="form-control" aria-describedby="segundo_nombre"
        placeholder="Ej. Abraham">
    </div>
    <div class="form-group">
        <label for="otro_nombre">Otro Nombre</label>
        <input id="otro_nombre" name="otro_nombre" type="text" class="form-control" aria-describedby="otro_nombre"
        placeholder="Ej. ">
    </div>
    <div class="form-group">
        <label for="primer_apellido">Primer Apellido</label>
        <input id="apelliprimer_apellidoo1" name="primer_apellido" type="text" class="form-control" aria-describedby="primer_apellido"
        placeholder="Ej. Guerrero">
    </div>
    <div class="form-group">
        <label for="segundo_apellido">Primer Apellido</label>
        <input id="segundo_apellido" name="segundo_apellido" type="text" class="form-control" aria-describedby="segundo_apellido"
        placeholder="Ej. Guerrero">
    </div>
    <div class="form-group">
        <label for="fecha_nac">Fecha de Nacimiento</label>
        <input id="fecha_nac" name="fecha_nac" type="date" class="form-control" aria-describedby="fecha_nac"
        placeholder="" pattern="[0-9]{2}/[0-9]{2}/[0-9]{2}">
    </div>
    <hr />
</form>