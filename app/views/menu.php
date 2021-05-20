<nav class="navbar navbar-expand-lg navbar navbar-dark navbar-fixed-top">
    <a class="navbar-brand" href="http://www.umg.edu.gt"><img style='height:30px' src="img/umg.png" alt="" /></a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="">INICIO<span class="sr-only">(current)</span></a>
            </li>
            <?php $padre = false; ?>
            <?php foreach($modulos AS $datos){?>
                <?php if($datos['PADRE'] == 0 && substr($datos['ID_MODULO'], -1) == 0){ ?>
                    <?php if($padre == true){ $padre = false; ?>
                            </div>
                        </li>
                    <?php } ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?php echo $datos['RUTA']; ?>"><?php echo $datos['NOMBRE']; ?><span class="sr-only">(current)</span></a>
                    </li>
                <?php }else{?>
                    <?php if($datos['PADRE'] == 1) { $padre = true;?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $datos['NOMBRE']; ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php }else{?>
                            <a name="CreaCheques" class="dropdown-item" href="<?php echo $datos['RUTA']; ?>"><?php echo $datos['NOMBRE']; ?></a>
                            <?php if(substr($datos['ID_MODULO'], -1) != 0) $padre = false; ?>
                    <?php } ?>
                <?php }?>
            <?php } ?>
            <li class="nav-item active">
                <a class="nav-link" href="salir">CERRAR SESION<span class="sr-only">(current)</span></a>
            </li>

        </ul>

    </div>
</nav>