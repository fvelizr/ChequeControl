<div class="container-fluid">
        <div class="row">
            <div class="col col-md-12 px-0">
                <nav class="navbar navbar-expand-lg navbar navbar-dark navbar-fixed-top">
                    <a class="navbar-brand" href="#"><img style='height:30px' alt=""/></a>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                        </ul> 
                    </div>
                </nav>
                <br>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col col-md-4">
                <h1 class="d-flex justify-content-center">INICIO DE SESION</h1>
                <br>
                <form id='ingreso-form'>
                    <hr>
                    <div class="form-group">
                        <label for="usuario" >INGRESE USUARIO</label>
                        <input name="usuario" id="usuario"  type="text" class="form-control"  aria-describedby="emailHelp" placeholder="Nombre de usuario:">
                    </div>

                    <div class="form-group">
                        <label for="contra" >INGRESE LA CONTRASEÑA</label>
                        <input type="password" name="contra" id="contra" class="form-control" id="exampleInputPassword1" placeholder="Contraseña">
                    </div>

                    <hr>
                    
                </form>
                <div class="d-flex justify-content-center">
                    <button onclick="validarIngreso()" type="button" name="saldos"  class="btn btn-success btn-lg w-100" role="button" aria-pressed="true">Ingresar</button>
                    <button type="submit" name="registro" class="btn btn-danger btn-lg w-100" role="button" aria-pressed="true">Ayuda</button>
                </div>
                <div class="alert alert-danger" role="alert" id='ingreso_respuesta' hidden>
                
                </div>
                <br><br>
            </div>
        </div>
    </div>
</div>