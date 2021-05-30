<div class="col-md-12">
    <div class='row'>
        <br /><br /><br />
        <div class='col-md-3'>

        </div>

        <div class='col-md-6'>
            
            <h3 class="d-flex justify-content-center">LISTADO DE CUENTAS BANCARIAS</h3>
            <br />
            <div class="w-100 d-flex justify-content-left">
                <button type="button" class="btn btn-success w-10" data-toggle="modal" onclick="frmCuentas()">
                    <i class="bi bi-plus-circle-fill"></i>
                </button>
            </div>
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Numero</th>
                        <th scope="col">Banco</th>
                        <th scope="col">Estado</th>
                        <!--th scope="col">Fecha<br>Creacion</th-->
                        <th scope="col">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <script>console.log(<?php echo $cuentaes; ?>);</script>
                    <?php foreach($cuentas as $datos) { ?>
                        <tr>
                            <th scope="row"><?php echo $datos['NUMERO']; ?></th>
                            <td><?php echo $datos['NOMBRE']; ?></td>
                            <td><?php echo 'Activo'; ?></td>
                            <td>
                                <button type="button" class="btn btn-primary btn-lg active w-auto"
                                    style="font-size:11px" data-toggle="modal" onclick="cuentaEnForm(<?php echo $datos['NUMERO']; ?>)">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                    <div class="modal fade" id="modal_cuenta_edit" tabindex="-1" aria-labelledby="modal__edit" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal_cuenta_edit">Mantenimiento Cuentas Bancarias</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <ul class="nav nav-tabs" id="cuenta_tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="cuenta-tab" data-toggle="tab" href="#cuenta" role="tab" aria-controls="cuenta" aria-selected="true">cuenta</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="cuenta_tab_contenido">
                                        <div class="tab-pane fade show active" id="cuenta" role="tabpanel" aria-labelledby="cuenta-tab">
                                            <form>
                                                <div class="form-group">
                                                    <label for="id">Numero de cuenta</label>
                                                    <input id='numero' name="id" type="number" class="form-control" aria-describedby="numero"
                                                    placeholder="Numero de cuentaes.">
                                                </div>
                                                <div class="form-group">
                                                    <label for="grupo">Banco</label>
                                                    <select class="form-control" id="id_banco">
                                                    <?php foreach($bancos as $datos) { ?>
                                                        <option value="<?php echo $datos['ID_BANCO']; ?>"><?php echo $datos['NOMBRE']; ?></option>
                                                    <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="cheque_inicial">Maximo sin autorizacion auditoria</label>
                                                    <input id="cheque_inicial" name="cheque_inicial" type="number" class="form-control" aria-describedby="cheque_inicial"
                                                    >
                                                </div>
                                                <div class="form-group">
                                                    <label for="cheque_final">Maximo sin autorizacion gerencia</label>
                                                    <input id="cheque_final" name="cheque_final" type="number" class="form-control" aria-describedby="cheque_final"
                                                    >
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer-modal">
                                    <div class="w-100 d-flex justify-content-center align-middle">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button id="btnGuardarCuenta" type="button" class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </tbody>
            </table>
        </div>
        <div class='col-md-3'>
        </div>
    </div>
</div>