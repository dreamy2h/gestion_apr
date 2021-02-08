var base_url = $("#txt_base_url").val();
var datatable_enabled = true;

function des_habilitar(a, b) {
    $("#btn_nuevo").prop("disabled", b);
    $("#btn_modificar").prop("disabled", a);
    $("#btn_eliminar").prop("disabled", a);
    $("#btn_aceptar").prop("disabled", a);
    $("#btn_cancelar").prop("disabled", a);

    $("#txt_desde").prop("disabled", a);
    $("#txt_hasta").prop("disabled", a);
    $("#txt_costo").prop("disabled", a);
}

function llenar_cmb_apr() {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: base_url + "/Configuracion/ctrl_usuarios/llenar_cmb_apr",
    }).done( function(data) {
        $("#cmb_apr").html('');

        var opciones_apr = "<option value=\"\">Seleccione una APR</option>";
        
        for (var i = 0; i < data.length; i++) {
            opciones_apr += "<option value=\"" + data[i].id + "\">" + data[i].apr + "</option>";
        }

        $("#cmb_apr").append(opciones_apr);
    }).fail(function(error){
        respuesta = JSON.parse(error["responseText"]);
        alerta.error("alerta", respuesta.message);
    });
}

function eliminar_costo_metros(observacion, id_costo_metros) {
    $.ajax({
        url: base_url + "/Configuracion/ctrl_costo_metros/eliminar_costo_metros",
        type: "POST",
        async: false,
        data: { 
            id_costo_metros: id_costo_metros,
            observacion: observacion
        },
        success: function(respuesta) {
            const OK = 1;
            
            if (respuesta == OK) {
                alerta.ok("alerta", "Costo eliminado con éxito");
                $("#grid_costo_metros").dataTable().fnReloadAjax(base_url + "/Configuracion/ctrl_costo_metros/datatable_costo_metros/" + $("#cmb_apr").val());
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

function guardar_costo_metros() {
    var id_costo_metros = $("#txt_id_costo_metros").val();
    var id_apr = $("#cmb_apr").val();
    var desde = $("#txt_desde").val();
    var hasta = $("#txt_hasta").val();
    var costo = $("#txt_costo").val();

    $.ajax({
        url: base_url + "/Configuracion/ctrl_costo_metros/guardar_costo_metros",
        type: "POST",
        async: false,
        data: {
            id_costo_metros: id_costo_metros,
            id_apr: id_apr,
            desde: desde,
            hasta: hasta,
            costo: costo
        },
        success: function(respuesta) {
            const OK = 1;
            if (respuesta == OK) {
                $("#grid_costo_metros").dataTable().fnReloadAjax(base_url + "/Configuracion/ctrl_costo_metros/datatable_costo_metros/" + $("#cmb_apr").val());
                limpiar();
                des_habilitar(true, false);
                alerta.ok("alerta", "Costo de metros, guardado con éxito");
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

function mostrar_datos_costo_metros(data) {
    $("#txt_id_costo_metros").val(data["id_costo_metros"]);
    $("#cmb_apr").val(data["id_apr"]);
    $("#txt_desde").val(data["desde"]);
    $("#txt_hasta").val(data["hasta"]);
    $("#txt_costo").val(data["costo"]);
}

function limpiar() {
	$("#txt_id_costo_metros").val("");
	$("#txt_desde").val("");
	$("#txt_hasta").val("");
	$("#txt_costo").val("");
}

$(document).ready(function() {
	$("#txt_id_costo_metros").prop("disabled", true);
	des_habilitar(true, false);
	llenar_cmb_apr();

	$("#btn_nuevo").on("click", function() {
        des_habilitar(false, true);
        limpiar();
        $("#btn_modificar").prop("disabled", true);
        $("#btn_eliminar").prop("disabled", true);
    });

    $("#btn_modificar").on("click", function() {
        des_habilitar(false, true);
        $("#btn_modificar").prop("disabled", true);
        $("#btn_eliminar").prop("disabled", true);
        datatable_enabled = false;
    });

    $("#btn_eliminar").on("click", function() {
        Swal.fire({
            title: "¿Eliminar costo de metros?",
            text: "¿Está seguro de eliminar costo de estos metros?",
            input: 'text',
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si",
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                var id_costo_metros = $("#txt_id_costo_metros").val();
                eliminar_costo_metros(result.value, id_costo_metros);
            }
        });
    });

    $("#btn_aceptar").on("click", function() {
        if ($("#form_costo_metros").valid()) {
            guardar_costo_metros();
        }
    });

    $("#btn_cancelar").on("click", function() {
        limpiar();
        des_habilitar(true, false);
        datatable_enabled = true;
    });

    $("#cmb_apr").on("change", function() {
    	$("#grid_costo_metros").dataTable().fnReloadAjax(base_url + "/Configuracion/ctrl_costo_metros/datatable_costo_metros/" + this.value);
    });

    $("#form_costo_metros").validate({
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
            cmb_apr: {
                required: true
            },
            txt_desde: {
                required: true,
                digits: true,
                maxlength: 11
            },
            txt_hasta: {
                required: true,
                digits: true,
                maxlength: 11
            },
            txt_costo: {
                required: true,
                digits: true,
                maxlength: 11
            }
        },
        messages: {
            cmb_apr: {
                required: "Seleccione APR"
            },
            txt_desde: {
                required: "Inicio de metros es obligatorio",
                digits: "Solo números",
                maxlength: "Máximo 11 caracteres"
            },
            txt_hasta: {
                required: "Fin de metros es obligatorio",
                digits: "Solo números",
                maxlength: "Máximo 11 caracteres"
            },
            txt_costo: {
                required: "Costo de metros es obligatorio",
                digits: "Solo números",
                maxlength: "Máximo 11 caracteres"
            }
        }
    });

    var grid_costo_metros = $("#grid_costo_metros").DataTable({
		responsive: true,
        paging: true,
        scrollY: '50vh',
        scrollCollapse: true,
        destroy: true,
        order: [[ 3, "asc" ]],
        select: {
            toggleable: false
        },
        // ajax: base_url + "/Configuracion/ctrl_costo_metros/datatable_costo_metros",
        orderClasses: true,
        columns: [
            { "data": "id_costo_metros" },
            { "data": "id_apr" },
            { "data": "apr" },
            { "data": "desde" },
            { "data": "hasta" },
            { "data": "costo" },
            { "data": "usuario" },
            { "data": "fecha" },
            { 
                "data": "id_costo_metros",
                "render": function(data, type, row) {
                    return "<button type='button' class='traza_costo_metros btn btn-warning' title='Traza Costo Metros'><i class='fas fa-shoe-prints'></i></button>";
                }
            }
        ],
        "columnDefs": [
            { "targets": [0, 1], "visible": false, "searchable": false }
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

	$("#grid_costo_metros tbody").on("click", "tr", function () {
		if (datatable_enabled) {
	        var data = grid_costo_metros.row($(this)).data();
	        mostrar_datos_costo_metros(data);
	        des_habilitar(true, false);
	        $("#btn_modificar").prop("disabled", false);
	        $("#btn_eliminar").prop("disabled", false);
    	}
    });

    $("#grid_costo_metros tbody").on("click", "button.traza_costo_metros", function () {
        if (datatable_enabled) {
	        $("#divContenedorTrazaCostoMetros").load(
	            base_url + "/Configuracion/ctrl_costo_metros/v_costo_metros_traza"
	        ); 

	        $('#dlg_traza_costo_metros').modal('show');
	    }
    });
});