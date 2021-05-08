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

        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="css/colors.css">
    </head>

    <body>

	<?php echo $contenido; ?>

	<script src="js/jquery-3.5.1.slim.min.js"
            integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/validacion.js"></script>
    </body>
</html>