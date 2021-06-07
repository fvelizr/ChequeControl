<div class="row">
    <div class='col-md-12' style="border-style:solid; background-color: powderblue">
        <center>
            <h1>GENERACION DE CHEQUES</h1>
        </center>

        <div class='row' style="margin-left: 10px; margin-right: 10px">
            <label style="width:7%; font-size:18px">Banco:</label>
            <input type="text" style="width:25%;" id="id_banco" value="<?php echo $cheques['BANCO']; ?>">

            
            <label style="width:10%; font-size:18px"> Cuenta:</label>
            <input type="text" style="width:20%;" id="cuentas_bancarias" value="<?php echo $cheques['CUENTA']; ?>">

            <label for="id">Numero</label>
            <input style="width:25%" type="number" name="lugar" id="numero" placeholder="" value="<?php echo $cheques['NUMERO']; ?>">
            
        </div>

        <div class='row' style="margin-left: 10px; margin-right: 10px">

            <label style="width:10%">Lugar:</label>
            <input style="width:20%" type="text" id="lugar" name="lugar" placeholder="Fecha" value="ESCUINTLA">
            <label style="width:10%">Fecha:</label>
            <input style="width:20%" type="date" id="fecha" name="lugar" placeholder="Fecha" pattern="[0-9]{2}/[0-9]{2}/[0-9]{2}" value="<?php echo $cheques['FECHA']; ?>">
            <label style="width:5%"> Q.</label>
            <input style="width:25%" type="number" id="total" value="<?php echo $cheques['MONTO']; ?>">

        </div>

        <div class='row' style="margin-left: 10px; margin-right: 10px">
            <label style="width:20%">Proveedor: </label>
            <input type="text" style="width:80%;" id="id_proveedor" value="<?php echo $cheques['ID_PROVEEDOR']; ?>">
        </div>

        <div class='row' style="margin-left: 10px; margin-right: 10px">
            <label style="width:15%">Paguese a: </label>
            <input style="width:85%" type="text" id="nombre" value="<?php echo $cheques['PROVEEDOR']; ?>">
        </div>

        <div class='row' style="margin-left: 10px; margin-right: 10px">

            <label style="width:30%;">La Suma de: </label>
            <input style="width:70%;" type="text" id="letras" placeholder="Ingrese la Cantidad en Letras" disabled>

        </div>
        <br /><br />
    </div>
</div>