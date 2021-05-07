<!-- Este una plantilla super sencilla solo para pruebas. Adjuntar con el html-->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	
</head>
<body>
	<script>
		function iniciarSesion() {
			var url = '<?php echo $url; ?>';
			var xhttp = new XMLHttpRequest();
			var loginForm = document.forms['form-test'];
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					console.log(this.responseText);
					if(this.responseText == 'permitido') location.href = '/';
					//console.log(this.responseText);
				}
			};
			xhttp.open("GET", '/verificarDatos', true);
			xhttp.send();
		}	
	</script>
	<form id="form-test">
		<input type="text" name="username">
		<input type="password" name="password">
	</form>
	<button onclick="iniciarSesion()">Enviar</button>
	
</body>
</html>