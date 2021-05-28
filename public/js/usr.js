function frmUsuario(){
    $("#modal_usuario_edit").modal('show');
    document.getElementById('btnGuardarUsuario').setAttribute('onclick', 'agregarUsuario()');
}

function agregarUsuario(){
    $.ajax({
        type: "POST",
        url: 'usr',
        data: $('#frm-usr').serialize(),
        success: function(response)
        {
            alert(response);
        }
    });
}
