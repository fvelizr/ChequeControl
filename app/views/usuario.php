<div class="col-md-12">
    <div class='row'>
        <br /><br /><br />
        <div class='col-md-3'>

        </div>

        <div class='col-md-6'>
            
            <h3 class="d-flex justify-content-center">LISTADO DE USUARIOS</h3>
            <br />
            <div class="w-100 d-flex justify-content-left">
                <button type="button" class="btn btn-success w-10" data-toggle="modal" onclick="frmUsuario()">
                    <i class="bi bi-plus-circle-fill"></i>
                </button>
            </div>
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Fecha<br>Creacion</th>
                        <th scope="col">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <script>console.log(<?php echo $usuarios; ?>);</script>
                    <?php foreach($usuarios as $datos) { ?>
                        <tr>
                            <th scope="row"><?php echo $datos['ID_USUARIO']; ?></th>
                            <td><?php echo $datos['NOMBRE_USUARIO']; ?></td>
                            <td><?php echo $datos['PRIMER_NOMBRE']; ?></td>
                            <td><?php echo $datos['PRIMER_APELLIDO']; ?></td>
                            <td><?php echo 'Activo'; ?></td>
                            <td><?php echo $datos['FECHA_CREACION']; ?></td>
                            <td>
                                <button type="button" class="btn btn-primary btn-lg active w-auto"
                                    style="font-size:11px" data-toggle="modal" onclick="usuarioEnForm(<?php echo $datos['ID_USUARIO']; ?>)">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <?php if($datos['ID_USUARIO'] != $_SESSION['id_usuario'] || $_SESSION['id_usuario'] != 1){ ?>
                                <button type="button" class="btn btn-danger btn-lg active w-auto"
                                    style="font-size:11px" data-toggle="modal" data-target="#modal_usuario_elim" onclick="eliminarUsuario(<?php echo $datos['ID_USUARIO']; ?>)">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <div class="modal fade" id="modal_usuario_edit" tabindex="-1" aria-labelledby="modal_usuario_edit" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal_usuario_edit">Mantenimiento Usuarios</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <ul class="nav nav-tabs" id="usuario_tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="usuarios-tab" data-toggle="tab" href="#usuarios" role="tab" aria-controls="usuarios" aria-selected="true">Usuario</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="personal-tab" data-toggle="tab" href="#personal" role="tab" aria-controls="personal" aria-selected="false">Personal</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="modulos-tab" data-toggle="tab" href="#modulos" role="tab" aria-controls="modulos" aria-selected="false">Modulos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="privilegios-tab" data-toggle="tab" href="#privilegios" role="tab" aria-controls="privilegios" aria-selected="false">Privilegios</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="usuario_tab_contenido">
                                        <div class="tab-pane fade show active" id="usuarios" role="tabpanel" aria-labelledby="usuarios-tab">
                                            <form>
                                                <div class="form-group">
                                                    <label for="id">ID</label>
                                                    <input id='id_usuario' name="id" type="number" class="form-control" aria-describedby="id_usuario"
                                                    placeholder="Id del usuarios." disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label for="grupo">Grupo Asignado</label>
                                                    <select class="form-control" id="grupo">
                                                    <?php foreach($grupos as $datos) { ?>
                                                        <option value="<?php echo $datos['ID_GRUPO']; ?>"><?php echo $datos['NOMBRE']; ?></option>
                                                    <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="usuario">Nombre de Usuarios</label>
                                                    <input id="usuario" name="usuario" type="text" class="form-control" aria-describedby="nombre_usuario"
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
                                                    <label for="monto">Monto Maximo</label>
                                                    <input id="monto" name="monto" type="number" class="form-control" aria-describedby="monto" maxlength="9"
                                                    placeholder="Ej. 10.00">
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
                                        <div class="tab-pane fade show" id="modulos" role="tabpanel" aria-labelledby="modulos-tab">
                                        </div>
                                        <div class="tab-pane fade show" id="privilegios" role="tabpanel" aria-labelledby="privilegios-tab">
                                        </div>
                                    </div>
                                </div>
                                <div class="footer-modal">
                                    <div class="w-100 d-flex justify-content-center align-middle">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button id="btnGuardarUsuario" type="button" class="btn btn-primary">Guardar</button>
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