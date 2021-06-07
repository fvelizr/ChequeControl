<div class="col-md-12">
    <div class='row'>
        <br /><br /><br />
        <div class='col-md-3'>

        </div>

        <div class='col-md-6'>
            
            <h3 class="d-flex justify-content-center">LISTADO DE CUENTAS BANCARIAS</h3>
            <br />
            <div class="w-100 d-flex justify-content-left">
            <?php if($usr->obtenerPrivilegio($_SESSION['id_usuario'], 1030201)['PRIV'] > 0){ ?>
                <button type="button" class="btn btn-success w-10" data-toggle="modal" onclick="frmCuentas()">
                    <i class="bi bi-plus-circle-fill"></i>
                </button>
            <?php } ?>
            </div>
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Numero</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Apellidos</th>
						<th scope="col">Carnet</th>
						<th scope="col">Funcion</th>
                    </tr>
                </thead>
                <tbody>
					<tr>
					<th scope="row">1</th>
					<th scope="row">Emely Andrea</th>
					<th scope="row">Espinoza Pérez</th>
					<th scope="row">0908-16-7907</th>
					<th scope="row">FrontEnd Developer</th>
					<tr>
					<tr>
					<th scope="row">2</th>
					<th scope="row">Edmundo Abraham</th>
					<th scope="row">Guerrero Morataya</th>
					<th scope="row">2190-18-2840</th>
					<th scope="row">Coordinador</th>
					<tr>
					<tr>
					<th scope="row">3</th>
					<th scope="row">Erick Alberto</th>
					<th scope="row">Velásquez Castillo</th>
					<th scope="row">0908-06-13480</th>
					<th scope="row">BackEnd Developer</th>
					<tr>
					<tr>
					<th scope="row">4</th>
					<th scope="row">Felipe inocencio</th>
					<th scope="row">Veliz Rabanales</th>
					<th scope="row">0908-14-5057</th>
					<th scope="row">BackEnd y DataBase Developer</th>
					<tr>
                </tbody>
            </table>
        </div>
        <div class='col-md-3'>
        </div>
    </div>
</div>