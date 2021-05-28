function frmCuentas(){

    $("#modal_cuenta_edit").modal('show');
    //document.getElementById('cui').disabled = false;
    //document.getElementById('id_usuario').disabled = false;
    document.getElementById('btnGuardarCuenta').setAttribute('onclick', 'crearCuenta()');

}


function crearCuenta(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            console.log(res);
            if(res.codigo == 200){
                //limpiarFrmUsuario();
                alert(res.codigo+': '+res.mensaje);
                setTimeout(location.href = '/cuentas', 10000);
            }else{
                alert('ERROR '+res.codigo+': '+res.mensaje);
            }
            
        }
    };
    console.log('id_banco=' + document.getElementById('id_banco').value+
    '&numero=' + document.getElementById('numero').value+
    '&cheque_inicial=' + document.getElementById('cheque_inicial').value+
    '&cheque_final=' + document.getElementById('cheque_final').value);
    xhttp.open('POST', '/cuentas', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(
        'id_banco=' + document.getElementById('id_banco').value+
        '&numero=' + document.getElementById('numero').value+
        '&cheque_inicial=' + document.getElementById('cheque_inicial').value+
        '&cheque_final=' + document.getElementById('cheque_final').value
    );
}



function cuentaEnForm(id){
    $("#modal_cuenta_edit").modal('show');
    document.getElementById('btnGuardarCuenta').setAttribute('onclick', 'guardarCuenta()');
    document.getElementById('numero').disabled = true;
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var res = JSON.parse(this.responseText);
            var objeto = res['objeto'];

            if(res.codigo == 200){
                console.log(res);
                console.log(objeto);
                //Usuario
                document.getElementById('numero').value = objeto.NUMERO;
                document.getElementById('id_banco').value = objeto.ID_BANCO;
                document.getElementById('cheque_inicial').value = objeto.CHEQUE_INICIAL;
                document.getElementById('cheque_final').value = objeto.CHEQUE_FINAL;
            }
        }
    };
    console.log(id);
    xhttp.open('GET', 'cuentas/'+id, true);
    xhttp.send();
}

function guardarCuenta(){
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            console.log(res);
            if(res.codigo == 200){
                //limpiarFrmUsuario();
                alert(res.codigo+': '+res.mensaje);
                setTimeout(location.href = '/cuentas', 10000);
            }else{
                alert('ERROR '+res.codigo+': '+res.mensaje);
            }
            
        }
    };

    console.log('');
    xhttp.open('PUT', '/cuentas', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(
        'id_banco=' + document.getElementById('id_banco').value+
        '&numero=' + document.getElementById('numero').value+
        '&cheque_inicial=' + document.getElementById('cheque_inicial').value+
        '&cheque_final=' + document.getElementById('cheque_final').value
    );
}