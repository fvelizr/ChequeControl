document.onreadystatechange = function () { //Al cargar el documento

}

/**
 * 
 * @param {nombre de usuario} usuario 
 * @param {contraseña del usuario} contra 
 */
function validarIngreso(){
    var url = '<?php echo $url; ?>';
    var xhttp = new XMLHttpRequest();
    var usuario = document.getElementById('usuario');
    var contra = document.getElementById('contra');

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            var alerta = document.getElementById('ingreso_respuesta');
            console.log(res);
            if(res.codigo != 200){
                alerta.hidden = false;
                alerta.innerText = res.mensaje;
            }else{
                alerta.hidden = false;
                alerta.innerText = res.mensaje;
                alerta.className = 'alert alert-success';
                setTimeout(location.href = '/', 10000);
                //location.href = '/';
            }
            
        }
    };
    console.log('usuario='+usuario.value+
    '&contra='+contra.value);
    xhttp.open('POST', '/validarIngreso', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(
        'usuario='+usuario.value+
        '&contra='+contra.value
    );
}