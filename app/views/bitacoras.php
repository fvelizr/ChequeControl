<div class="col">
    <div class='row'>
        <br /><br /><br />
        <div class='col-md-3'>

        </div>
        <div class='col-md-6'>
            
            <h3 class="d-flex justify-content-center">LISTADO DE MOVIMIENTOS</h3>
            <br />
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Cheque</th>
                        <th scope="col">Cuenta</th>
                        <th scope="col">Banco</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Descripcion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($Cheques as $datos) { ?>
                        <tr>
                            <th scope="row"><?php echo $datos['CHEQUE']; ?></th>
                            <td><?php echo $datos['CUENTA']; ?></td>
                            <td><?php echo $datos['BANCO']; ?></td>
                            <td><?php echo $datos['USUARIO']; ?></td>
                            <td><?php echo $datos['FECHA']; ?></td>
                            <td><?php echo $datos['DESCRIPCION']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class='col-md-3'>

        </div>
    </div>
</div>