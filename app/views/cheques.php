<div class="col">
    <div class='row'>
        <br /><br /><br />

        <div class='col-md-12'>
            
            <h3 class="d-flex justify-content-center">LISTADO DE CHEQUES</h3>
            <br />
            <div class="w-100 d-flex justify-content-left">
            <?php if($usr->obtenerPrivilegio($_SESSION['id_usuario'], 10401)['PRIV'] > 0){ ?>
                <button type="button" class="btn btn-success w-10" data-toggle="modal" onclick="frmCheques()">
                    <i class="bi bi-plus-circle-fill"></i>
                </button>
            <?php } ?>
            </div>
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Numero</th>
                        <th scope="col">Cuenta</th>
                        <th scope="col">Banco</th>
                        <th scope="col">Proveedor</th>
                        <th scope="col">Monto</th>
                        <th scope="col">Estado</th>
                        <!--th scope="col">Fecha<br>Creacion</th-->
                        <th scope="col">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($Cheques as $datos) { ?>
                        <tr>
                            <th scope="row"><?php echo $datos['NUMERO']; ?></th>
                            <td><?php echo $datos['CUENTA']; ?></td>
                            <td><?php echo $datos['BANCO']; ?></td>
                            <td><?php echo $datos['PROVEEDOR']; ?></td>
                            <td><?php echo $datos['MONTO']; ?></td>
                            <td><?php echo $datos['ESTADO']; ?></td>
                            <td>
                                <?php if($usr->obtenerPrivilegio($_SESSION['id_usuario'], 10402)['PRIV'] > 0){ ?>
                                    <button type="button" class="btn btn-success btn-lg active w-auto"
                                        style="font-size:11px" onclick="ChequeEnForm(<?php echo $datos['NUMERO']; ?>)">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                <?php } ?>
                                <?php if($datos['ESTADO'] == 'Creado' && $datos['MONTO'] >= $datos['AUDITORIA']
                                    && $usr->obtenerPrivilegio($_SESSION['id_usuario'], 1050100)['PRIV'] > 0){ ?>
                                    
                                    <button type="button" class="btn btn-success btn-lg active w-auto"
                                        style="font-size:11px" onclick="liberarAuditoria(<?php echo $datos['NUMERO']; ?>)">
                                        <i class="bi bi-file-earmark-break-fill"></i>
                                    </button>
                                <?php } ?>
                                <?php if(
                                    (
                                        
                                        (
                                            (($datos['ESTADO'] == 'Auditado' && $datos['MONTO'] >= $datos['AUDITORIA'])) 
                                            || 
                                            ($datos['ESTADO'] == 'Creado' && $datos['MONTO'] >= $datos['GERENCIA'] && $datos['MONTO'] < $datos['AUDITORIA'])
                                        )
                                        
                                    ) && $usr->obtenerPrivilegio($_SESSION['id_usuario'], 1060100)['PRIV'] > 0){ ?>
                                <button type="button" class="btn btn-success btn-lg active w-auto"
                                    style="font-size:11px" onclick="liberarGerencia(<?php echo $datos['NUMERO']; ?>)">
                                    <i class="bi bi-award-fill"></i>
                                </button>
                                <?php } ?>
                                <?php if(
                                        ($datos['ESTADO'] == 'Gerenciado' && $usr->obtenerPrivilegio($_SESSION['id_usuario'], 1070100)['PRIV'] > 0)
                                        ||
                                        ($datos['ESTADO'] == 'Creado' && $usr->obtenerPrivilegio($_SESSION['id_usuario'], 1070100)['PRIV'] > 0 && $datos['MONTO'] < $datos['AUDITORIA'] && $datos['MONTO'] < $datos['GERENCIA'])
                                    ){ ?>
                                <button type="button" class="btn btn-success btn-lg active w-auto"
                                    style="font-size:11px" onclick="imprimirCheque(<?php echo $datos['NUMERO']; ?>)">
                                    <i class="bi bi-printer-fill"></i>
                                </button>
                                <?php } ?>
                                <?php if($datos['ESTADO'] == 'Entregado'  && $usr->obtenerPrivilegio($_SESSION['id_usuario'], 1080100)['PRIV'] > 0){ ?>
                                <button type="button" class="btn btn-success btn-lg active w-auto"
                                    style="font-size:11px" onclick="entregarCheque(<?php echo $datos['NUMERO']; ?>)">
                                    <i class="bi bi-mailbox2"></i>
                                </button>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <div class="modal fade w-100" id="modal_Cheque_edit" tabindex="-1" aria-labelledby="modal_edit" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content w-100">
                                <div class="modal-header w-100">
                                    <h5 class="modal-title" id="modal_Cheque_edit">Cheques</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body w-100">
                                <div class="row">
                                    <div class='col-md-12' style="border-style:solid; background-color: powderblue">
                                        <center>
                                            <h1>GENERACION DE CHEQUES</h1>
                                        </center>

                                        <div class='row' style="margin-left: 10px; margin-right: 10px">
                                            <label style="width:7%; font-size:18px">Banco:</label>
                                            <select style="width:25%;" id="id_banco" onchange="cambiarCuentas()">
                                                <?php foreach($bancos as $datos) { ?>
                                                    <option value="<?php echo $datos['ID_BANCO']; ?>"><?php echo $datos['NOMBRE']; ?></option>
                                                <?php } ?>
                                            </select>

                                            
                                            <label style="width:10%; font-size:18px"> Cuenta:</label>
                                            <select style="width:20%;" id="cuentas_bancarias">
                                            </select>

                                            <label for="id">Numero</label>
                                            <input style="width:25%" type="number" name="lugar" id="numero" placeholder="">
                                            
                                        </div>

                                        <div class='row' style="margin-left: 10px; margin-right: 10px">

                                            <label style="width:10%">Lugar:</label>
                                            <input style="width:20%" type="text" id="lugar" name="lugar" placeholder="Fecha">
                                            <label style="width:10%">Fecha:</label>
                                            <input style="width:20%" type="date" id="fecha" name="lugar" placeholder="Fecha" pattern="[0-9]{2}/[0-9]{2}/[0-9]{2}">
                                            <label style="width:5%"> Q.</label>
                                            <input style="width:25%" type="number" id="total">

                                        </div>

                                        <div class='row' style="margin-left: 10px; margin-right: 10px">
                                            <label style="width:20%">Proveedor: </label>
                                            <select style="width:80%;" id="id_proveedor">
                                                <?php foreach($proveedores as $datos) { ?>
                                                    <option value="<?php echo $datos['ID_PROVEEDOR']; ?>"><?php echo $datos['NOMBRE']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class='row' style="margin-left: 10px; margin-right: 10px">
                                            <label style="width:15%">Paguese a: </label>
                                            <input style="width:85%" type="text" id="nombre" >
                                        </div>

                                        <div class='row' style="margin-left: 10px; margin-right: 10px">

                                            <label style="width:30%;">La Suma de: </label>
                                            <input style="width:70%;" type="text" id="letras" placeholder="Ingrese la Cantidad en Letras" disabled>

                                        </div>
                                        <br /><br />
                                    </div>
                                </div>
                                </div>
                                <div class="footer-modal">
                                    <div class="w-100 d-flex justify-content-center align-middle">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button id="btnGuardarCheque" type="button" class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </tbody>
            </table>
        </div>
    </div>
</div>