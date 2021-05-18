var base_url = $("#txt_base_url").val();
var datatable_enabled = true;

function des_habilitar(a, b) {
    $("#btn_nuevo").prop("disabled", b);
    $("#btn_modificar").prop("disabled", a);
    $("#btn_anular").prop("disabled", a);
    $("#btn_aceptar").prop("disabled", a);
    $("#btn_cancelar").prop("disabled", a);

    $("#txt_monto").prop("disabled", a);
    $("#dt_fecha_egreso").prop("disabled", a);
    $("#cmb_tipo_egreso").prop("disabled", a);
    $("#btn_buscar_proveedor").prop("disabled", a);
    $("#btn_buscar_motivo").prop("disabled", a);
    $("#txt_observaciones").prop("disabled", a);
    $("#txt_id_proveedor").prop("disabled", a);
    $("#txt_rut_proveedor").prop("disabled", a);
    $("#txt_razon_social").prop("disabled", a);
    $("#txt_id_motivo").prop("disabled", a);
    $("#txt_motivo").prop("disabled", a);
    if (a) { $("#cmb_categorias").multiselect("disable"); } else { $("#cmb_categorias").multiselect("enable"); }
    $("#txt_id_cuenta").prop("disabled", a);
    $("#txt_banco").prop("disabled", a);
    $("#txt_tipo_cuenta").prop("disabled", a);
    $("#txt_n_cuenta").prop("disabled", a);
    $("#txt_rut").prop("disabled", a);
    $("#txt_nombre").prop("disabled", a);
    $("#txt_n_transaccion").prop("disabled", a);
    $("#btn_buscar_cuenta").prop("disabled", a);
}

function mostrar_datos_egreso(data) {
    if (data["id_egreso"] != null) { $("#txt_id_egreso").val(data["id_egreso"]); }
    if (data["monto"] != null) { $("#txt_monto").val(peso.formateaNumero(data["monto"])); }
    if (data["fecha_egreso"] != null) { $("#dt_fecha_egreso").val(data["fecha_egreso"]); }
    if (data["id_tipo_egreso"] != null) { $("#cmb_tipo_egreso").val(data["id_tipo_egreso"]); }

    switch (data["tipo_entidad"]) {
        case "Proveedor":
            $("#rd_proveedor").prop("checked", true);
            break;
        case "Funcionario":
            $("#rd_funcionario").prop("checked", true);
            break;
        case "Socio":
            $("#rd_socio").prop("checked", true);
            break;
    }

    if (data["id_entidad"] != null) { $("#txt_id_proveedor").val(data["id_entidad"]); }
    if (data["rut_entidad"] != null) { $("#txt_rut_proveedor").val(data["rut_entidad"]); }
    if (data["nombre_entidad"] != null) { $("#txt_razon_social").val(data["nombre_entidad"]); }
    if (data["id_motivo"] != null) { $("#txt_id_motivo").val(data["id_motivo"]); }
    if (data["motivo"] != null) { $("#txt_motivo").val(data["motivo"]); }
    if (data["observaciones"] != null) { $("#txt_observaciones").val(data["observaciones"]); }
}

function guardar_egreso() {
    var id_egreso = $("#txt_id_egreso").val();
    var monto = peso.quitar_formato($("#txt_monto").val());
    var fecha_egreso = $("#dt_fecha_egreso").val();
    var id_tipo_egreso = $("#cmb_tipo_egreso").val();
    var id_entidad = $("#txt_id_proveedor").val();
    var id_motivo = $("#txt_id_motivo").val();
    var observaciones = $("#txt_observaciones").val();

    if ($("#rd_proveedor").is(":checked")) {
        var tipo_entidad = "Proveedor";
    } else if ($("#rd_funcionario").is(":checked")) {
        var tipo_entidad = "Funcionario";
    } else if ($("#rd_socio").is(":checked")) {
        var tipo_entidad = "Socio";
    }

    $.ajax({
        url: base_url + "/Finanzas/Ctrl_egresos/guardar_egreso",
        type: "POST",
        async: false,
        data: {
            id_egreso: id_egreso,
            monto: monto,
            fecha_egreso: fecha_egreso,
            id_tipo_egreso: id_tipo_egreso,
            tipo_entidad: tipo_entidad,
            id_entidad: id_entidad,
            id_motivo: id_motivo,
            observaciones: observaciones
        },
        success: function(respuesta) {
            const OK = 1;
            if (respuesta == OK) {
                $("#grid_egresos").dataTable().fnReloadAjax(base_url + "/Finanzas/Ctrl_egresos/datatable_egresos");
                $("#form_egresos")[0].reset();
                des_habilitar(true, false);
                alerta.ok("alerta", "Egreso guardado con éxito");
                $("#datosegreso").collapse("hide");
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

function convertirMayusculas(texto) {
    var text = texto.toUpperCase().trim();
    return text;
}

function anular_egreso(observacion, id_egreso) {
    $.ajax({
        url: base_url + "/Finanzas/Ctrl_egresos/anular_egreso",
        type: "POST",
        async: false,
        data: {
            id_egreso: id_egreso,
            observacion: observacion
        },
        success: function(respuesta) {
            const OK = 1;
            if (respuesta == OK) {
                $("#grid_egresos").dataTable().fnReloadAjax(base_url + "/Finanzas/Ctrl_egresos/datatable_egresos");
                $("#form_egresos")[0].reset();
                des_habilitar(true, false);
                alerta.ok("alerta", "egreso anulado con éxito");
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

var peso = {
    validaEntero: function  ( value ) {
        var RegExPattern = /[0-9]+$/;
        return RegExPattern.test(value);
    },
    formateaNumero: function (value) {
        if (peso.validaEntero(value))  {  
            var retorno = '';
            value = value.toString().split('').reverse().join('');
            var i = value.length;
            while(i>0) retorno += ((i%3===0&&i!=value.length)?'.':'')+value.substring(i--,i);
            return retorno;
        }
        return 0;
    },
    quitar_formato : function(numero){
        numero = numero.split('.').join('');
        return numero;
    }
}

function llenar_cmb_tipo_egreso() {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: base_url + "/Finanzas/Ctrl_egresos/llenar_cmb_tipo_egreso",
    }).done( function(data) {
        $("#cmb_tipo_egreso").html('');

        var opciones = "<option value=\"\">Seleccione un tipo de egreso</option>";
        
        for (var i = 0; i < data.length; i++) {
            opciones += "<option value=\"" + data[i].id + "\">" + data[i].tipo_egreso + "</option>";
        }

        $("#cmb_tipo_egreso").append(opciones);
    }).fail(function(error){
        respuesta = JSON.parse(error["responseText"]);
        alerta.error("alerta", respuesta.message);
    });
}

$(document).ready(function() {
    $("#txt_id_egreso").prop("disabled", true);
    $("#txt_id_proveedor").prop("readonly", true);
    $("#txt_rut_proveedor").prop("readonly", true);
    $("#txt_razon_social").prop("readonly", true);
    $("#txt_id_motivo").prop("readonly", true);
    $("#txt_motivo").prop("readonly", true);
    des_habilitar(true, false);
    // llenar_cmb_tipo_egreso();

    $("#btn_nuevo").on("click", function() {
        des_habilitar(false, true);
        $("#form_egresos")[0].reset();

        $("#btn_modificar").prop("disabled", true);
        $("#btn_anular").prop("disabled", true);
        $("#datosegreso").collapse("show");
    });

    $("#btn_modificar").on("click", function() {
        des_habilitar(false, true);
        $("#btn_modificar").prop("disabled", true);
        $("#btn_anular").prop("disabled", true);
        datatable_enabled = false;
        $("#datosegreso").collapse("show");
    });

    $("#btn_anular").on("click", function() {
        var id_egreso = $("#txt_id_egreso").val();

        Swal.fire({
            title: "¿Anular egreso?",
            text: "¿Está seguro de anular el egreso " + id_egreso + "?",
            input: 'text',
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si",
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                var id_egreso = $("#txt_id_egreso").val();
                anular_egreso(result.value, id_egreso);
            }
        });
    });

    $("#btn_aceptar").on("click", function() {
        if ($("#form_egresos").valid()) {
            guardar_egreso();
        }
    });

    $("#btn_cancelar").on("click", function() {
        $("#form_egresos")[0].reset();
        des_habilitar(true, false);
        datatable_enabled = true;
        $("#datosegreso").collapse("hide");
    });

    $("#txt_monto").on("blur", function() {
        var numero = peso.quitar_formato($(this).val());
        $(this).val(peso.formateaNumero(numero));
    });

    $("#dt_fecha_egreso").datetimepicker({
        format: "DD-MM-YYYY",
        useCurrent: false,
        locale: moment.locale("es")
    });

    $("#cmb_categorias").multiselect({
        buttonWidth: '100%',
        maxHeight: 400,
        dropRight:true,
        enableFiltering: true,
        filterPlaceholder: 'Buscar por glosa...',
        onChange: function(option, checked, select) {
            mostrar_permisos_grupo(option[0].value, checked);
        },
        buttonText: function(options) {
            if (options.length === 0) {
                return 'Nada seleccionado';
            } else if (options.length > 3) {
                return options.length + ' seleccionados';
            } else {
                var selected = [];
                options.each(function() {
                    selected.push([$(this).text(), $(this).data('order')]);
                });

                selected.sort(function(a, b) {
                    return a[1] - b[1];
                });

                var text = '';
                for (var i = 0; i < selected.length; i++) {
                    text += selected[i][0] + ', ';
                }

                return text.substr(0, text.length -2);
            }
        },
        disableIfEmpty: true
    });

    $("#btn_buscar_proveedor").on("click", function() {
        $("#divContenedorBuscador").html("");

        if ($("#rd_proveedor").is(":checked")) {
            $("#tlt_buscador").text("Buscar Proveedor");
            var url_buscador = base_url + "/Finanzas/Ctrl_egresos/v_buscar_proveedor";
        } else if ($("#rd_funcionario").is(":checked")) {
            $("#tlt_buscador").text("Buscar Funcionario");
            var url_buscador = base_url + "/Finanzas/Ctrl_egresos/v_buscar_funcionario";
        } else if ($("#rd_socio").is(":checked")) {
            $("#tlt_buscador").text("Buscar Socio");
            var url_buscador = base_url + "/Finanzas/Ctrl_egresos/v_buscar_socio";
        }

        $("#divContenedorBuscador").load(url_buscador);
        $('#dlg_buscador').modal('show');
    });

    $("#btn_buscar_cuenta").on("click", function() {
        $("#tlt_buscador").text("Buscar Cuenta");
        $("#divContenedorBuscador").html("");
        $("#divContenedorBuscador").load(
            base_url + "/Finanzas/Ctrl_egresos/v_buscar_cuenta"
        ); 

        $('#dlg_buscador').modal('show');
    });

    $("#btn_buscar_motivo").on("click", function() {
        $("#tlt_buscador").text("Buscar Motivo");
        $("#divContenedorBuscador").html("");
        $("#divContenedorBuscador").load(
            base_url + "/Finanzas/Ctrl_egresos/v_buscar_motivo"
        ); 

        $('#dlg_buscador').modal('show');
    });

    $.validator.addMethod("charspecial", function(value, element) {
        return this.optional(element) || /^[^;\"'{}\[\]^<>=]+$/.test(value);
    });

    $("#form_egresos").validate({
        debug: true,
        errorClass: "my-error-class",
        highlight: function (element, required) {
            $(element).css('border', '2px solid #FDADAF');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).css('border', '1px solid #CCC');
        },
        rules:  {
            cmb_tipo_egreso: {
                required: true
            },
            txt_monto: {
                required: true,
                number: true,
                maxlength: 12
            },
            dt_fecha_egreso: {
                required: true
            },
            txt_id_proveedor: {
                required: true
            },
            txt_id_motivo: {
                required: true
            },
            txt_observaciones: {
                charspecial: true,
                maxlength: 200
            }
        },
        messages: {
            cmb_tipo_egreso: {
                required: "El tipo de egreso es obligatorio"
            },
            txt_monto: {
                required: "El monto es obligatorio",
                number: "Solo números",
                maxlength: "Máximo 12 caracteres"
            },
            dt_fecha_egreso: {
                required: "La fecha es obligatoria"
            },
            txt_id_proveedor: {
                required: "Id Proveedor es obligatorio"
            },
            txt_id_motivo: {
                required: "Id Motivo es obligatorio"
            },
            txt_observaciones: {
                charspecial: "Caracteres no permitidos",
                maxlength: "Máximo 200 caracteres"
            }
        }
    });

    var grid_egresos = $("#grid_egresos").DataTable({
		responsive: true,
        paging: true,
        destroy: true,
        select: {
            toggleable: false
        },
        // ajax: base_url + "/Finanzas/Ctrl_egresos/datatable_egresos",
        orderClasses: true,
        columns: [
            { "data": "id_egreso" },
            { 
                "data": "monto",
                "render": function(data, type, row) {
                    return peso.formateaNumero(data);
                }
            },
            { "data": "fecha_egreso" },
            { "data": "id_tipo_egreso" },
            { "data": "tipo_egreso" },
            { "data": "tipo_entidad" },
            { "data": "id_entidad" },
            { "data": "rut_entidad" },
            { "data": "nombre_entidad" },
            { "data": "id_motivo" },
            { "data": "motivo" },
            { "data": "observaciones" },
            { "data": "usuario" },
            { "data": "fecha" },
            { 
                "data": "id_egreso",
                "render": function(data, type, row) {
                    return "<button type='button' class='traza_egreso btn btn-warning' title='Traza egreso'><i class=\"fas fa-shoe-prints\"></i></button>";
                }
            }
        ],
        "columnDefs": [
            { "targets": [0, 3, 6, 7, 9], "visible": false, "searchable": false }
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
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Sig.",
                "previous": "Ant."
            }
        }
	});

    $("#grid_egresos tbody").on("click", "tr", function () {
        if (datatable_enabled) {
            var tr = $(this).closest('tr');
            if ($(tr).hasClass('child') ) {
                tr = $(tr).prev();  
            }

            var data = grid_egresos.row(tr).data();
            mostrar_datos_egreso(data);
            des_habilitar(true, false);
            $("#btn_modificar").prop("disabled", false);
            $("#btn_anular").prop("disabled", false);
            $("#datosegreso").collapse("hide");
        }
    });

    $("#grid_egresos tbody").on("click", "button.traza_egreso", function () {
        if (datatable_enabled) {
            $("#divContenedorTrazaegreso").load(
                base_url + "/Finanzas/Ctrl_egresos/v_egresos_traza"
            ); 

            $('#dlg_traza_egresos').modal('show');
        }
    });
});