function frmCheques(){

    $("#modal_Cheque_edit").modal('show');
    //document.getElementById('cui').disabled = false;
    //document.getElementById('id_usuario').disabled = false;
    document.getElementById('btnGuardarCheque').setAttribute('onclick', 'crearCheque()');

}


function crearCheque(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var res = JSON.parse(this.responseText);
            console.log(res);
            if(res.codigo == 200){
                //limpiarFrmUsuario();
                alert(res.codigo+': '+res.mensaje);
                setTimeout(location.href = '/cheques', 10000);
            }else{
                alert('ERROR '+res.codigo+': '+res.mensaje);
            }
            
        }
    };
    console.log('id_banco=' + document.getElementById('id_banco').value+
    '&cuentas_bancarias=' + document.getElementById('cuentas_bancarias').value+
    '&numero=' + document.getElementById('numero').value+
    '&lugar=' + document.getElementById('lugar').value+
    '&fecha=' + document.getElementById('fecha').value+
    '&total=' + document.getElementById('total').value+
    '&id_proveedor=' + document.getElementById('id_proveedor').value+
    '&nombre=' + document.getElementById('nombre').value+
    '&letras=' + document.getElementById('letras').value);

    xhttp.open('POST', '/cheques', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(
        'id_banco=' + document.getElementById('id_banco').value+
        '&cuentas_bancarias=' + document.getElementById('cuentas_bancarias').value+
        '&numero=' + document.getElementById('numero').value+
        '&lugar=' + document.getElementById('lugar').value+
        '&fecha=' + document.getElementById('fecha').value+
        '&total=' + document.getElementById('total').value+
        '&id_proveedor=' + document.getElementById('id_proveedor').value+
        '&nombre=' + document.getElementById('nombre').value
    );
}


function cambiarCuentas(){
    var id = document.getElementById("id_banco").value;
    document.getElementById('cuentas_bancarias').innerHTML = '';
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
                $.each(objeto,function(index, value){
                    var option = document.createElement('option');
                    option.setAttribute('value',value['NUMERO']);
                    option.innerText = value['NUMERO'];
                    document.getElementById('cuentas_bancarias').appendChild(option);
                });
            }
        }
    };
    console.log(id);
    xhttp.open('GET', 'cheques/cuentas/'+id, true);
    xhttp.send();
}



function ChequeEnForm(id){
    $("#modal_Cheque_edit").modal('show');
    document.getElementById('btnGuardarCheque').setAttribute('onclick', 'guardarCheque()');
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
                document.getElementById('id_banco').value = objeto.BANCO;
                cambiarCuentas();
                document.getElementById('cuentas_bancarias').value = objeto.CUENTA;
                document.getElementById('nombre').value = objeto.PROVEEDOR;
                document.getElementById('id_proveedor').value = objeto.ID_PROVEEDOR;
                //document.getElementById('lugar').value = objeto.LUGAR;
                document.getElementById('fecha').value = objeto.FECHA;
                document.getElementById('total').value = objeto.MONTO;
                //document.getElementById('cheque_inicial').value = objeto.CHEQUE_INICIAL;
                //document.getElementById('cheque_final').value = objeto.CHEQUE_FINAL;
            }
        }
    };
    console.log(id);
    xhttp.open('GET', 'cheques/'+id, true);
    xhttp.send();
}

function guardarCheque(){
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            console.log(res);
            if(res.codigo == 200){
                //limpiarFrmUsuario();
                alert(res.codigo+': '+res.mensaje);
                setTimeout(location.href = '/cheques', 10000);
            }else{
                alert('ERROR '+res.codigo+': '+res.mensaje);
            }
            
        }
    };

    xhttp.open('PUT', 'cheques/', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(
        'id_banco=' + document.getElementById('id_banco').value+
        '&cuentas_bancarias=' + document.getElementById('cuentas_bancarias').value+
        '&numero=' + document.getElementById('numero').value+
        '&lugar=' + document.getElementById('lugar').value+
        '&fecha=' + document.getElementById('fecha').value+
        '&total=' + document.getElementById('total').value+
        '&id_proveedor=' + document.getElementById('id_proveedor').value+
        '&nombre=' + document.getElementById('nombre').value
    );
}