<!-- Vista básica, las vistan deben tener el mínimo de php o nulo
Solo se utilizan para mostrar la información procesada por los
controladores. 
Recibe los datos del controlador Home y rendereados por
la Clase Template
-->
<!DOCTYPE html>
<html>

    <head>
        <title><?php echo $titulo; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        
        <link rel="stylesheet" href="css/bootstrap.css?v=<?php echo time();?>" />
        <link rel="stylesheet" type="text/css" href="css/colors.css?v=<?php echo time();?>">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css?v=<?php echo time();?>">
        <link rel="stylesheet" type="text/css" href="css/select.css?v=<?php echo time();?>">


        
        
    </head>

    <body>

	<?php echo $contenido; ?>

	    <script src="js/jquery-3.5.1.slim.min.js?v=<?php echo time();?>"
            crossorigin="anonymous"></script>
        <script src="js/bootstrap.js?v=<?php echo time();?>"></script>
        <script src="js/validacion.js?v=<?php echo time();?>"></script>
        <script src="js/cuentas.js?v=<?php echo time();?>"></script>
        <script src="js/cheques.js?v=<?php echo time();?>"></script>
        
    </body>
</html>