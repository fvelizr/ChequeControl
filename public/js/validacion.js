document.onreadystatechange = function () { //Al cargar el documento

}

function prueba(){
    console.log('prueba');
}

function limpiarFrmUsuario(){
    document.getElementById('id_usuario').value = 0;
    document.getElementById('grupo').value = 0;
    document.getElementById('usuario').value = '';
    document.getElementById('contra').value = '';
    document.getElementById('monto').value = '';
    document.getElementById('cui').value = '';
    document.getElementById('nombre1').value = '';
    document.getElementById('nombre2').value = '';
    document.getElementById('nombre3').value = '';
    document.getElementById('apellido1').value = '';
    document.getElementById('apellido2').value = '';
    document.getElementById('fecha_nac').valu = '00-00-0000';
    document.getElementById('fecha_creacion').value = '00-00-0000';
}

function limpiarFrmProveedor(){
    /*document.getElementById('id_usuario').value = 0;
    document.getElementById('grupo').value = 0;
    document.getElementById('usuario').value = '';
    document.getElementById('contra').value = '';
    document.getElementById('monto').value = '';
    document.getElementById('cui').value = '';
    document.getElementById('nombre1').value = '';
    document.getElementById('nombre2').value = '';
    document.getElementById('nombre3').value = '';
    document.getElementById('apellido1').value = '';
    document.getElementById('apellido2').value = '';
    document.getElementById('fecha_nac').valu = '00-00-0000';
    document.getElementById('fecha_creacion').value = '00-00-0000';*/
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
                setTimeout(location.href = '/usuarios', 10000);
            }else{
                alerta.hidden = false;
                alerta.innerText = res.mensaje;
                alerta.className = 'alert alert-success';
                setTimeout(location.href = '/usuarios', 10000);
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

function frmUsuario(){
    limpiarFrmUsuario();
    $("#modal_usuario_edit").modal('show');
    document.getElementById('cui').disabled = false;
    document.getElementById('usuario').disabled = false;
    document.getElementById('btnGuardarUsuario').setAttribute('onclick', 'crearUsuario()');
}

/**
 * 
 * 
 * 
 */
 function crearUsuario(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            console.log(res);
            if(res.codigo == 200){
                limpiarFrmUsuario();
                alert(res.codigo+': '+res.mensaje);
                setTimeout(location.href = '/usuarios', 10000);
            }else{
                alert('ERROR '+res.codigo+': '+res.mensaje);
            }
            
        }
    };
    console.log('grupo=' + document.getElementById('grupo').value+
    '&usuario=' + document.getElementById('usuario').value+
    '&contra=' + document.getElementById('contra').value+
    '&monto=' + document.getElementById('monto').value+
    '&cui=' + document.getElementById('cui').value+
    '&nombre1=' + document.getElementById('nombre1').value+
    '&nombre2=' + document.getElementById('nombre2').value+
    '&nombre3=' + document.getElementById('nombre3').value+
    '&apellido1=' + document.getElementById('apellido1').value+
    '&apellido2=' + document.getElementById('apellido2').value+
    '&fecha_nac=' + document.getElementById('fecha_nac').value);
    xhttp.open('POST', '/usuarios', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(
        'grupo=' + document.getElementById('grupo').value+
        '&usuario=' + document.getElementById('usuario').value+
        '&contra=' + document.getElementById('contra').value+
        '&monto=' + document.getElementById('monto').value+
        '&cui=' + document.getElementById('cui').value+
        '&nombre1=' + document.getElementById('nombre1').value+
        '&nombre2=' + document.getElementById('nombre2').value+
        '&nombre3=' + document.getElementById('nombre3').value+
        '&apellido1=' + document.getElementById('apellido1').value+
        '&apellido2=' + document.getElementById('apellido2').value+
        '&fecha_nac=' + document.getElementById('fecha_nac').value
    );
}

function guardarUsuario(){
    var xhttp = new XMLHttpRequest();
    var modulos = '';
    var datamod = '';
    var privilegios = '';
    var datapriv = '';

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            console.log(res);
            if(res.codigo == 200){
                limpiarFrmUsuario();
                alert(res.codigo+': '+res.mensaje);
                setTimeout(location.href = '/usuarios', 10000);
            }else{
                alert('ERROR '+res.codigo+': '+res.mensaje);
            }
            
        }
    };
    
    modulos = document.getElementById('modulos');
    console.log(modulos.children[0].length);

    for (var i = 0; i < modulos.children[0].length; i++) {
        console.log(modulos.childNodes[0][i]);
        var data = modulos.childNodes[0][i];
        if(data.checked == true) datamod += data.value+'|';
    }

    privilegios = document.getElementById('privilegios');
    console.log(privilegios.children[0].length);

    for (var i = 0; i < privilegios.children[0].length; i++) {
        console.log(privilegios.childNodes[0][i]);
        var data = privilegios.childNodes[0][i];
        if(data.checked == true) datapriv += data.value+'|';
    }

    console.log(
    '&usuario=' + document.getElementById('usuario').value+
    '&contra=' + document.getElementById('contra').value+
    '&monto=' + document.getElementById('monto').value+
    '&cui=' + document.getElementById('cui').value+
    '&nombre1=' + document.getElementById('nombre1').value+
    '&nombre2=' + document.getElementById('nombre2').value+
    '&nombre3=' + document.getElementById('nombre3').value+
    '&apellido1=' + document.getElementById('apellido1').value+
    '&apellido2=' + document.getElementById('apellido2').value+
    '&fecha_nac=' + document.getElementById('fecha_nac').value+'$info='+datapriv);
    xhttp.open('PUT', '/usuarios', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(
        'usuario=' + document.getElementById('usuario').value+ 
        '&id_usuario=' + document.getElementById('id_usuario').value+
        '&grupo=' + document.getElementById('grupo').value+
        '&contra=' + document.getElementById('contra').value+
        '&monto=' + document.getElementById('monto').value+
        '&nombre1=' + document.getElementById('nombre1').value+
        '&nombre2=' + document.getElementById('nombre2').value+
        '&nombre3=' + document.getElementById('nombre3').value+
        '&apellido1=' + document.getElementById('apellido1').value+
        '&apellido2=' + document.getElementById('apellido2').value+
        '&fecha_nac=' + document.getElementById('fecha_nac').value+
        '&mod=' + datamod+
        '&priv=' + datapriv
    );
}

function eliminarUsuario(id){
    var xhttp = new XMLHttpRequest();


    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            console.log(res);
            if(res.codigo == 200){
                limpiarFrmUsuario();
                alert(res.codigo+': '+res.mensaje);
                setTimeout(location.href = '/usuarios', 10000);
            }else{
                alert('ERROR '+res.codigo+': '+res.mensaje);
            }
            
        }
    };
    
    console.log(id);
    xhttp.open('DELETE', '/usuarios', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(
        'id_usuario=' + id
    );
}

/**
 * 
 * Usuario formulario, muestra el formulario del usuario para ser editado.
 * 
 */

 function usuarioEnForm(id){
    limpiarFrmUsuario();
    $("#modal_usuario_edit").modal('show');
    document.getElementById('btnGuardarUsuario').setAttribute('onclick', 'guardarUsuario()');
    document.getElementById('cui').disabled = true;
    document.getElementById('usuario').disabled = true;
    var url = '<?php echo $url; ?>';
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            var objeto = (res.objeto[0])['informacion'];
            var modulos = (res.objeto[0])['modulos'];
            var privilegios = (res.objeto[0])['privilegios'];

            if(res.codigo == 200){
                console.log(res);
                console.log(objeto);
                //Usuario
                document.getElementById('id_usuario').value = objeto.ID_USUARIO;
                document.getElementById('grupo').value = objeto.ID_GRUPO;
                document.getElementById('usuario').value = objeto.NOMBRE_USUARIO;
                document.getElementById('contra').value = '';
                document.getElementById('fecha_creacion').value = objeto.FECHA_CREACION;
                document.getElementById('monto').value = objeto.MONTO;

                //Personal
                document.getElementById('cui').value = objeto.CUI;
                document.getElementById('nombre1').value = objeto.PRIMER_NOMBRE;
                document.getElementById('nombre2').value = objeto.SEGUNDO_NOMBRE;
                document.getElementById('nombre3').value = objeto.OTRO_NOMBRE;
                document.getElementById('apellido1').value = objeto.PRIMER_APELLIDO;
                document.getElementById('apellido2').value = objeto.SEGUNDO_APELLIDO;
                document.getElementById('fecha_nac').value = objeto.FECHA_NAC;

                //Modulos
                var frm = document.createElement('form');
                $.each(modulos,function(index, value){
                    var input = document.createElement('input');
                    if(value['PERMISO'] > 0) input.checked = true;
                    input.id = value['ID_MODULO'];
                    input.name = value['ID_MODULO'];
                    input.setAttribute('type','checkbox');
                    input.className = 'form-control';
                    input.value = value['ID_MODULO'];

                    var colint = document.createElement('div');
                    colint.className = 'col';
                    colint.appendChild(input);

                    var lbl = document.createElement('label');
                    lbl.setAttribute('for',value['ID_MODULO']);
                    lbl.innerText = value['NOMBRE'];

                    var collbl = document.createElement('div');
                    collbl.className = 'col';
                    collbl.appendChild(lbl);

                    var row = document.createElement('div');
                    row.className = 'row';
                    row.appendChild(collbl);
                    row.appendChild(colint);

                    var frmg = document.createElement('div');
                    frmg.className = 'form-group';
                    frmg.appendChild(row);
                    frm.appendChild(frmg);
                });
                document.getElementById('modulos').innerHTML = '';
                document.getElementById('modulos').appendChild(frm);
                

                //Privilegios
                frm = document.createElement('form');
                $.each(privilegios,function(index, value){
                    var input = document.createElement('input');
                    if(value['PERMISO'] > 0) input.checked = true;
                    input.id = value['ID_PRIVILEGIO'];
                    input.name = value['ID_PRIVILEGIO'];
                    input.setAttribute('type','checkbox');
                    input.className = 'form-control';
                    input.value = value['ID_PRIVILEGIO'];

                    var colint = document.createElement('div');
                    colint.className = 'col';
                    colint.appendChild(input);

                    var lbl = document.createElement('label');
                    lbl.setAttribute('for',value['ID_PRIVILEGIO']);
                    lbl.innerText = value['NOMBRE'];

                    var collbl = document.createElement('div');
                    collbl.className = 'col';
                    collbl.appendChild(lbl);

                    var row = document.createElement('div');
                    row.className = 'row';
                    row.appendChild(collbl);
                    row.appendChild(colint);

                    var frmg = document.createElement('div');
                    frmg.className = 'form-group';
                    frmg.appendChild(row);
                    frm.appendChild(frmg);
                });
                document.getElementById('privilegios').innerHTML = '';
                document.getElementById('privilegios').appendChild(frm);
            }else{
                
            }
        }
    };
    console.log(id);
    xhttp.open('GET', 'usuarios/'+id, true);
    xhttp.send();
}


function frmProveedor(){
    $("#modal_proveedor_edit").modal('show');
    document.getElementById('cui').disabled = false;
    //document.getElementById('id_usuario').disabled = false;
    document.getElementById('btnGuardarProveedor').setAttribute('onclick', 'crearProveedor()');
}

function crearProveedor(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            console.log(res);
            if(res.codigo == 200){
                //limpiarFrmUsuario();
                alert(res.codigo+': '+res.mensaje);
                setTimeout(location.href = '/proveedores', 10000);
            }else{
                alert('ERROR '+res.codigo+': '+res.mensaje);
            }
            
        }
    };
    console.log('nomproveedor=' + document.getElementById('nomproveedor').value+
    '&nit=' + document.getElementById('nit').value+
    '&cui=' + document.getElementById('cui').value+
    '&nombre1=' + document.getElementById('nombre1').value+
    '&nombre2=' + document.getElementById('nombre2').value+
    '&nombre3=' + document.getElementById('nombre3').value+
    '&apellido1=' + document.getElementById('apellido1').value+
    '&apellido2=' + document.getElementById('apellido2').value+
    '&fecha_nac=' + document.getElementById('fecha_nac').value);
    xhttp.open('POST', '/proveedores', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(
        'nomproveedor=' + document.getElementById('nomproveedor').value+
        '&nit=' + document.getElementById('nit').value+
        '&cui=' + document.getElementById('cui').value+
        '&nombre1=' + document.getElementById('nombre1').value+
        '&nombre2=' + document.getElementById('nombre2').value+
        '&nombre3=' + document.getElementById('nombre3').value+
        '&apellido1=' + document.getElementById('apellido1').value+
        '&apellido2=' + document.getElementById('apellido2').value+
        '&fecha_nac=' + document.getElementById('fecha_nac').value
    );
}


function guardarProveedor(){
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            console.log(res);
            if(res.codigo == 200){
                //limpiarFrmUsuario();
                alert(res.codigo+': '+res.mensaje);
                setTimeout(location.href = '/proveedores', 10000);
            }else{
                alert('ERROR '+res.codigo+': '+res.mensaje);
            }
            
        }
    };

    console.log('');
    xhttp.open('PUT', '/proveedores', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(
        'id_proveedor=' + document.getElementById('id_proveedor').value+ 
        '&nomproveedor=' + document.getElementById('nomproveedor').value+
        '&nit=' + document.getElementById('nit').value+
        '&nombre1=' + document.getElementById('nombre1').value+
        '&nombre2=' + document.getElementById('nombre2').value+
        '&nombre3=' + document.getElementById('nombre3').value+
        '&apellido1=' + document.getElementById('apellido1').value+
        '&apellido2=' + document.getElementById('apellido2').value+
        '&fecha_nac=' + document.getElementById('fecha_nac').value
    );
}

function proveedorEnForm(id){
    //limpiarFrmProveedor();
    $("#modal_proveedor_edit").modal('show');
    document.getElementById('btnGuardarProveedor').setAttribute('onclick', 'guardarProveedor()');
    document.getElementById('cui').disabled = true;
    //document.getElementById('nit').disabled = true;
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var res = JSON.parse(this.responseText);
            var objeto = res['objeto'][0];

            if(res.codigo == 200){
                console.log(res);
                console.log(objeto);
                //Usuario
                document.getElementById('id_proveedor').value = objeto.ID_PROVEEDOR;
                document.getElementById('nomproveedor').value = objeto.NOMBRE;
                console.log(document.getElementById('nomproveedor'));
                document.getElementById('nit').value = objeto.NIT;

                //Personal
                document.getElementById('cui').value = objeto.CUI;
                document.getElementById('nombre1').value = objeto.PRIMER_NOMBRE;
                document.getElementById('nombre2').value = objeto.SEGUNDO_NOMBRE;
                document.getElementById('nombre3').value = objeto.OTRO_NOMBRE;
                document.getElementById('apellido1').value = objeto.PRIMER_APELLIDO;
                document.getElementById('apellido2').value = objeto.SEGUNDO_APELLIDO;
                document.getElementById('fecha_nac').value = objeto.FECHA_NAC;
            }
        }
    };
    console.log(id);
    xhttp.open('GET', 'proveedores/'+id, true);
    xhttp.send();
}