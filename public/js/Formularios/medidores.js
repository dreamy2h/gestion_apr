var base_url = $("#txt_base_url").val();
var datatable_enabled = true;

function des_habilitar(a, b) {
    $("#btn_nuevo").prop("disabled", b);
    $("#btn_modificar").prop("disabled", a);
    $("#btn_eliminar").prop("disabled", a);
    $("#btn_aceptar").prop("disabled", a);
    $("#btn_cancelar").prop("disabled", a);
    $("#btn_reciclar").prop("disabled", b);

    $("#txt_numero").prop("disabled", a);
    $("#cmb_diametro").prop("disabled", a);
}

function mostrar_datos_medidor(data) {
    $("#txt_id_medidor").val(data["id_medidor"]);
    $("#txt_numero").val(data["numero"]);
    $("#cmb_diametro").val(data["id_diametro"]);
}

function guardar_medidor() {
    var id_medidor = $("#txt_id_medidor").val();
    var numero = $("#txt_numero").val();
    var id_diametro = $("#cmb_diametro").val();

    $.ajax({
        url: base_url + "/Formularios/Ctrl_medidores/guardar_medidor",
        type: "POST",
        async: false,
        data: {
            id_medidor: id_medidor,
            numero: numero,
            id_diametro: id_diametro
        },
        success: function(respuesta) {
            const OK = 1;
            if (respuesta == OK) {
                $("#grid_medidores").dataTable().fnReloadAjax(base_url + "/Formularios/Ctrl_medidores/datatable_medidores");
                $("#form_medidor")[0].reset();
                des_habilitar(true, false);
                alerta.ok("alerta", "Medidor guardado con éxito");
                $("#datosMedidor").collapse("hide");
                datatable_enabled = true;
            } else {
                alerta.error("alerta", respuesta);
            }
        },
        error: function(error) {
            respuesta = JSON.parse(error["responseText"]);
            alerta.error("alerta", respuesta.message);
        }
    });
}

function eliminar_medidor(opcion, observacion, id_medidor) {
    if (opcion == "eliminar") { var estado = 0; } else { var estado = 1; }
    
    $.ajax({
        url: base_url + "/Formularios/Ctrl_medidores/eliminar_medidor",
        type: "POST",
        async: false,
        data: { 
            id_medidor: id_medidor,
            observacion: observacion,
            estado: estado
        },
        success: function(respuesta) {
            const OK = 1;

            if (respuesta == OK) {
                if (opcion == "eliminar") {
                    alerta.ok("alerta", "Medidor eliminado con éxito");
                } else {
                    $('#dlg_reciclar').modal('hide');
                    alerta.ok("alerta", "Medidor reciclado con éxito");
                }

                $("#grid_medidores").dataTable().fnReloadAjax(base_url + "/Formularios/Ctrl_medidores/datatable_medidores");
            } else {
                alerta.error("alerta", respuesta);
            }
        },
        error: function(error) {
            respuesta = JSON.parse(error["responseText"]);
            alerta.error("alerta", respuesta.message);
        }
    });
}

function convertirMayusculas(texto) {
    var text = texto.toUpperCase().trim();
    return text;
}

function llenar_cmb_diametro() {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: base_url + "/Formularios/Ctrl_medidores/llenar_cmb_diametro",
    }).done( function(data) {
        $("#cmb_diametro").html('');

        var opciones = "<option value=\"\">Seleccione un diámetro</option>";
        
        for (var i = 0; i < data.length; i++) {
            opciones += "<option value=\"" + data[i].id + "\">" + data[i].diametro + "</option>";
        }

        $("#cmb_diametro").append(opciones);
    }).fail(function(error){
        respuesta = JSON.parse(error["responseText"]);
        alerta.error("alerta", respuesta.message);
    });
}

$(document).ready(function() {
    $("#txt_id_medidor").prop("disabled", true);
    des_habilitar(true, false);
    llenar_cmb_diametro();

    $("#btn_nuevo").on("click", function() {
        des_habilitar(false, true);
        $("#form_medidor")[0].reset();

        $("#btn_modificar").prop("disabled", true);
        $("#btn_eliminar").prop("disabled", true);
        $("#datosMedidor").collapse("show");
    });

    $("#btn_modificar").on("click", function() {
        des_habilitar(false, true);
        $("#btn_modificar").prop("disabled", true);
        $("#btn_eliminar").prop("disabled", true);
        datatable_enabled = false;
        $("#datosMedidor").collapse("show");
    });

    $("#btn_eliminar").on("click", function() {
        var numero = $("#txt_numero").val();
        
        Swal.fire({
            title: "¿Eliminar Medidor?",
            text: "¿Está seguro de eliminar el medidor " + numero + "?",
            input: 'text',
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si",
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                var id_medidor = $("#txt_id_medidor").val();
                eliminar_medidor("eliminar", result.value, id_medidor);
            }
        });
    });

    $("#btn_aceptar").on("click", function() {
        if ($("#form_medidor").valid()) {
            guardar_medidor();
        }
    });

    $("#btn_cancelar").on("click", function() {
        $("#form_medidor")[0].reset();
        des_habilitar(true, false);
        datatable_enabled = true;
        $("#datosMedidor").collapse("hide");
    });

    $("#btn_reciclar").on("click", function() {
        $("#divContenedorReciclarMedidor").load(
            base_url + "/Formularios/Ctrl_medidores/v_medidor_reciclar"
        ); 

        $('#dlg_reciclar').modal('show');
    });

    $("#form_medidor").validate({
        debug: true,
        errorClass: "my-error-class",
        highlight: function (element, required) {
            $(element).fadeOut(function () {
                $(element).fadeIn();
                $(element).css('border', '2px solid #FDADAF');
            });
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).css('border', '1px solid #CCC');
        },
        rules:  {
            txt_numero: {
                required: true,
                digits: true,
                maxlength: 20
            },
            cmb_diametro: {
                required: true
            }
        },
        messages: {
            txt_numero: {
                required: "El número del medidor es obligatorio",
                letras: "Solo puede ingresar números",
                maxlength: "Máximo 11 caracteres"
            },
            cmb_diametro: {
                required: "Seleccione un diámetro"
            }
        }
    });

    var grid_medidores = $("#grid_medidores").DataTable({
		responsive: true,
        paging: true,
        // scrollY: '50vh',
        // scrollCollapse: true,
        destroy: true,
        select: {
            toggleable: false
        },
        ajax: base_url + "/Formularios/Ctrl_medidores/datatable_medidores",
        orderClasses: true,
        columns: [
            { "data": "id_medidor" },
            { "data": "numero" },
            { "data": "id_diametro" },
            { "data": "diametro" },
            { "data": "estado" },
            { "data": "usuario" },
            { "data": "fecha" },
            { 
                "data": "id_medidor",
                "render": function(data, type, row) {
                    return "<button type='button' class='traza_medidor btn btn-warning' title='Traza Medidor'><i class='fas fa-shoe-prints'></i></button>";
                }
            }
        ],
        "columnDefs": [
            { "targets": [2, 4], "visible": false, "searchable": false }
        ],
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "select": {
                "rows": "<br/>%d Perfiles Seleccionados"
            },
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Sig.",
                "previous": "Ant."
            }
        }
	});

    $("#grid_medidores tbody").on("click", "tr", function () {
        if (datatable_enabled) {
            var data = grid_medidores.row($(this)).data();
            mostrar_datos_medidor(data);
            des_habilitar(true, false);
            $("#btn_modificar").prop("disabled", false);
            $("#btn_eliminar").prop("disabled", false);
            $("#datosMedidor").collapse("hide");
        }
    });

    $("#grid_medidores tbody").on("click", "button.traza_medidor", function () {
        if (datatable_enabled) {
            $("#divContenedorTrazaMedidor").load(
                base_url + "/Formularios/Ctrl_medidores/v_medidor_traza"
            ); 

            $('#dlg_traza_medidor').modal('show');
        }
    });
});