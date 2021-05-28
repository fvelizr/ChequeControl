<div class="col-md-12">
    <div class='row'>
        <br /><br /><br />
        <div class='col-md-3'>

        </div>

        <div class='col-md-6'>
            
            <h3 class="d-flex justify-content-center">LISTADO DE PROVEEDORES</h3>
            <br />
            <div class="w-100 d-flex justify-content-left">
                <button type="button" class="btn btn-success w-10" data-toggle="modal" onclick="frmProveedor()">
                    <i class="bi bi-plus-circle-fill"></i>
                </button>
            </div>
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Proveedores</th>
                        <th scope="col">NIT</th>
                        <th scope="col">Contacto</th>
                        <th scope="col">Estado</th>
                        <!--th scope="col">Fecha<br>Creacion</th-->
                        <th scope="col">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <script>console.log(<?php echo $proveedores; ?>);</script>
                    <?php foreach($proveedores as $datos) { ?>
                        <tr>
                            <th scope="row"><?php echo $datos['ID_PROVEEDOR']; ?></th>
                            <td><?php echo $datos['NOMBRE']; ?></td>
                            <td><?php echo $datos['NIT']; ?></td>
                            <td><?php echo $datos['PRIMER_NOMBRE']; ?></td>
                            <td><?php echo 'Activo'; ?></td>
                            <!--td><?php echo $datos['FECHA_CREACION']; ?></td-->
                            <td>
                                <button type="button" class="btn btn-primary btn-lg active w-auto"
                                    style="font-size:11px" data-toggle="modal" onclick="proveedorEnForm(<?php echo $datos['ID_PROVEEDOR']; ?>)">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <!--button type="button" class="btn btn-danger btn-lg active w-auto"
                                    style="font-size:11px" data-toggle="modal" data-target="#modal_proveedor_elim" onclick="eliminarProveedor(<?php echo $datos['ID_PROVEEDOR']; ?>)">
                                    <i class="bi bi-trash-fill"></i>
                                </button-->
                            </td>
                        </tr>
                    <?php } ?>
                    <div class="modal fade" id="modal_proveedor_edit" tabindex="-1" aria-labelledby="modal_proveedor_edit" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal_proveedor_edit">Mantenimiento Proveedores</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <ul class="nav nav-tabs" id="proveedor_tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="proveedor-tab" data-toggle="tab" href="#proveedor" role="tab" aria-controls="proveedor" aria-selected="true">Proveedor</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="personal-tab" data-toggle="tab" href="#personal" role="tab" aria-controls="personal" aria-selected="false">Personal</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="proveedor_tab_contenido">
                                        <div class="tab-pane fade show active" id="proveedor" role="tabpanel" aria-labelledby="proveedor-tab">
                                            <form>
                                                <div class="form-group">
                                                    <label for="id">ID</label>
                                                    <input id='id_proveedor' name="id" type="number" class="form-control" aria-describedby="id_proveedor"
                                                    placeholder="Id de proveedores." disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nomproveedor">Nombre</label>
                                                    <input id="nomproveedor" name="nomproveedor" type="text" class="form-control" aria-describedby="nomproveedor"
                                                    placeholder="Ej. edmundo">
                                                </div>
                                                <div class="form-group">
                                                    <label for="nit">NIT</label>
                                                    <input id="nit" name="nit" type="text" class="form-control" aria-describedby="nit"
                                                    placeholder="Ej. edmundo">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade show" id="personal" role="tabpanel" aria-labelledby="usuarios-tab">
                                            <form>
                                                <div class="form-group">
                                                    <label for="cui">CUI</label>
                                                    <input id="cui" name="monto" type="number" class="form-control" aria-describedby="cui"
                                                    placeholder="Ej. 3134599910501">
                                                </div>
                                                <div class="form-group">
                                                    <label for="nombre1">Primer Nombre</label>
                                                    <input id="nombre1" name="nombre1" type="text" class="form-control" aria-describedby="nombre1"
                                                    placeholder="Ej. Edmundo">
                                                </div>
                                                <div class="form-group">
                                                    <label for="nombre2">Segundo Nombre</label>
                                                    <input id="nombre2" name="nombre1" type="text" class="form-control" aria-describedby="nombre2"
                                                    placeholder="Ej. Abraham">
                                                </div>
                                                <div class="form-group">
                                                    <label for="nombre3">Otro Nombre</label>
                                                    <input id="nombre3" name="nombre3" type="text" class="form-control" aria-describedby="nombre3"
                                                    placeholder="Ej. ">
                                                </div>
                                                <div class="form-group">
                                                    <label for="apellido1">Primer Apellido</label>
                                                    <input id="apellido1" name="apellido1" type="text" class="form-control" aria-describedby="apellido1"
                                                    placeholder="Ej. Guerrero">
                                                </div>
                                                <div class="form-group">
                                                    <label for="apellido2">Primer Apellido</label>
                                                    <input id="apellido2" name="apellido2" type="text" class="form-control" aria-describedby="apellido2"
                                                    placeholder="Ej. Guerrero">
                                                </div>
                                                <div class="form-group">
                                                    <label for="fecha_nac">Fecha de Nacimiento</label>
                                                    <input id="fecha_nac" name="fecha_nac" type="date" class="form-control" aria-describedby="fecha_nac"
                                                    placeholder="" pattern="[0-9]{2}/[0-9]{2}/[0-9]{2}">
                                                </div>
                                                <hr />
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer-modal">
                                    <div class="w-100 d-flex justify-content-center align-middle">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button id="btnGuardarProveedor" type="button" class="btn btn-primary">Guardar</button>
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