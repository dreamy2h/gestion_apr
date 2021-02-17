var base_url = $("#txt_base_url").val();
var datatable_enabled = true;

function des_habilitar(a, b) {
    $("#btn_nuevo").prop("disabled", b);
    $("#btn_modificar").prop("disabled", a);
    $("#btn_eliminar").prop("disabled", a);
    $("#btn_aceptar").prop("disabled", a);
    $("#btn_cancelar").prop("disabled", a);
    $("#btn_importar").prop("disabled", b);

    $("#txt_id_socio").prop("disabled", a);
    $("#txt_rut_socio").prop("disabled", a);
    $("#txt_rol").prop("disabled", a);
    $("#txt_nombre_socio").prop("disabled", a);
    $("#btn_buscar_socio").prop("disabled", a);
    $("#txt_id_arranque").prop("disabled", a);
    $("#txt_sector").prop("disabled", a);
    $("#txt_subsidio").prop("disabled", a);
    $("#txt_monto_subsidio").prop("disabled", a);
    $("#dt_fecha_ingreso").prop("disabled", a);
    $("#dt_fecha_vencimiento").prop("disabled", a);
    $("#txt_c_anterior").prop("disabled", a);
    $("#txt_c_actual").prop("disabled", a);
    $("#txt_metros").prop("disabled", a);
    $("#txt_total_metros").prop("disabled", a);
    $("#txt_subtotal").prop("disabled", a);
    $("#txt_multa").prop("disabled", a);
    $("#txt_total_servicios").prop("disabled", a);
    $("#txt_total_mes").prop("disabled", a);
}

function mostrar_datos_metros(data) {
    $("#txt_id_metros").val(data["id_subsidio"]);
    $("#txt_id_socio").val(data["id_subsidio"]);
    $("#txt_rut_socio").val(data["id_socio"]);
    $("#txt_rol").val(data["rut_socio"]);
    $("#txt_nombre_socio").val(data["rol_socio"]);
    $("#btn_buscar_socio").val(data["nombre_socio"]);
    $("#txt_id_arranque").val(data["n_decreto"]);
    $("#txt_sector").val(data["fecha_decreto"]);
    $("#txt_subsidio").val(data["fecha_caducidad"]);
    $("#txt_monto_subsidio").val(data["fecha_caducidad"]);
    $("#dt_fecha_ingreso").val(data["id_porcentaje"]);
    $("#dt_fecha_vencimiento").val(data["fecha_encuesta"]);
    $("#txt_c_anterior").val(data["puntaje"]);
    $("#txt_c_actual").val(data["n_unico"]);
    $("#txt_metros").val(data["d_unico"]);
    $("#txt_total_metros").val(data["d_unico"]);
    $("#txt_subtotal").val(data["d_unico"]);
    $("#txt_multa").val(data["d_unico"]);
    $("#txt_total_servicios").val(data["d_unico"]);
    $("#txt_total_mes").val(data["d_unico"]);
}

function guardar_metros() {
    var id_metros = $("#txt_id_metros").val();
    var id_socio = $("#txt_id_socio").val();
    var monto_subsidio = peso.quitar_formato($("#txt_monto_subsidio").val());
    var fecha_ingreso = $("#dt_fecha_ingreso").val();
    var fecha_vencimiento = $("#dt_fecha_vencimiento").val();
    var consumo_anterior = $("#txt_c_anterior").val();
    var consumo_actual = $("#txt_c_actual").val();
    var metros = $("#txt_metros").val();
    var subtotal = peso.quitar_formato($("#txt_subtotal").val());
    var multa = peso.quitar_formato($("#txt_multa").val());
    var total_servicios = peso.quitar_formato($("#txt_total_servicios").val());
    var total_mes = peso.quitar_formato($("#txt_total_mes").val());

    $.ajax({
        url: base_url + "/Consumo/ctrl_metros/guardar_metros",
        type: "POST",
        async: false,
        data: {
            id_metros: id_metros,
            id_socio: id_socio,
            monto_subsidio: monto_subsidio,
            fecha_ingreso: fecha_ingreso,
            fecha_vencimiento: fecha_vencimiento,
            consumo_anterior: consumo_anterior,
            consumo_actual: consumo_actual,
            metros: metros,
            subtotal: subtotal,
            multa: multa,
            total_servicios: total_servicios,
            total_mes: total_mes
        },
        success: function(respuesta) {
            const OK = 1;
            if (respuesta == OK) {
                $("#grid_metros").dataTable().fnReloadAjax(base_url + "/Consumo/ctrl_metros/datatable_metros");
                $("#form_metros")[0].reset();
                des_habilitar(true, false);
                alerta.ok("alerta", "Consumo de metros, guardado con éxito");
                $("#datosMetros").collapse();
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

function eliminar_metros(observacion, id_metros) {
    $.ajax({
        url: base_url + "/Consumo/ctrl_metros/eliminar_metros",
        type: "POST",
        async: false,
        data: { 
            id_metros: id_metros,
            observacion: observacion,
            estado: estado
        },
        success: function(respuesta) {
            const OK = 1;

            if (respuesta == OK) {
                alerta.ok("alerta", "Consumo de metros, eliminado con éxito");
                $("#grid_metros").dataTable().fnReloadAjax(base_url + "/Consumo/ctrl_metros/datatable_metros");
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

function habilita_consumo_actual() {
    if ($("#dt_fecha_ingreso").valid()  && $("#dt_fecha_vencimiento").valid()) {
        $("#txt_c_actual").prop("readonly", false);
    } else {
        $("#txt_c_actual").val("");
        $("#txt_c_actual").prop("readonly", true);
    }
}

function calcular_total_servicios() {
    var fecha_vencimiento = $("#dt_fecha_vencimiento").val();
    var id_socio = $("#txt_id_socio").val();

    $.ajax({
        url: base_url + "/Consumo/ctrl_metros/calcular_total_servicios",
        type: "POST",
        async: false,
        data: { 
            fecha_vencimiento: fecha_vencimiento,
            id_socio: id_socio
        },
        success: function(respuesta) {
            if (respuesta >= 0) {
                $("#txt_total_servicios").val(peso.formateaNumero(respuesta));
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

function calcular_montos() {
    var consumo_anterior = $("#txt_c_anterior").val();
    var consumo_actual = $("#txt_c_actual").val();
    if (parseInt(consumo_actual) >= parseInt(consumo_anterior)) {
        var metros_consumidos = consumo_actual - consumo_anterior;
        $("#txt_metros").val(metros_consumidos);
        var resto_metros = metros_consumidos;
        var i = 0;
        var subtotal = 0;

        $("#grid_costo_metros").DataTable().rows().data().each(function (value) {
            var cantidad = value.hasta - value.desde;
            if (resto_metros > cantidad) {
                resto_metros -= (cantidad + 1);
                cantidad += 1;
                var total = cantidad * value.costo;
                subtotal += total; 
                this.cell({row: i, column: 1}).data(cantidad);
            } else {
                var total = resto_metros * value.costo;
                subtotal += total;
                this.cell({row: i, column: 1}).data(resto_metros);
                resto_metros = 0;
            }

            i++;
        });

        $("#txt_subtotal").val(peso.formateaNumero(subtotal));
        var subsidio_arr = $("#txt_subsidio").val().split("%");
        var subsidio = parseInt(subsidio_arr[0]);
        var monto_subsidio = subtotal * subsidio / 100;
        $("#txt_monto_subsidio").val(peso.formateaNumero(monto_subsidio));
        calcular_total();
    } else {
        $("#txt_c_actual").val("");
        alerta.aviso("alerta", "El <strong>connsumo actual</strong>, no puede ser menor al <strong>consumo anterior</strong>");
    }
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

function calcular_total() {
    var subtotal = $("#txt_subtotal").val();
    var multa = $("#txt_multa").val();
    var total_servicios = $("#txt_total_servicios").val();
    var monto_subsidio = $("#txt_monto_subsidio").val();

    if (subtotal == "") { subtotal = 0; } else { subtotal = peso.quitar_formato(subtotal); }
    if (multa == "") { multa = 0; } else { multa = peso.quitar_formato(multa); }
    if (total_servicios == "") { total_servicios = 0; } else { total_servicios = peso.quitar_formato(total_servicios); }
    if (monto_subsidio == "") { monto_subsidio = 0; } else { monto_subsidio = peso.quitar_formato(monto_subsidio); }

    var total_mes = parseInt(subtotal) + parseInt(multa) + parseInt(total_servicios) - parseInt(monto_subsidio);
    $("#txt_total_mes").val(peso.formateaNumero(total_mes));
}

$(document).ready(function() {
    $("#txt_id_metros").prop("disabled", true);
    $("#txt_id_socio").prop("readonly", true);
    $("#txt_rut_socio").prop("readonly", true);
    $("#txt_rol").prop("readonly", true);
    $("#txt_nombre_socio").prop("readonly", true);
    $("#txt_id_arranque").prop("readonly", true);
    $("#txt_sector").prop("readonly", true);
    $("#txt_subsidio").prop("readonly", true);
    $("#txt_monto_subsidio").prop("readonly", true);
    $("#txt_c_anterior").prop("readonly", true);
    $("#txt_metros").prop("readonly", true);
    $("#txt_subtotal").prop("readonly", true);
    $("#txt_total_servicios").prop("readonly", true);
    $("#txt_total_mes").prop("readonly", true);
    $("#txt_c_actual").prop("readonly", true);
    $("#dt_fecha_ingreso").prop("readonly", true);
    $("#dt_fecha_vencimiento").prop("readonly", true);

    des_habilitar(true, false);

    $("#btn_nuevo").on("click", function() {
        des_habilitar(false, true);
        $("#form_metros")[0].reset();

        $("#btn_modificar").prop("disabled", true);
        $("#btn_eliminar").prop("disabled", true);
        $("#datosMetros").collapse("show");
    });

    $("#btn_modificar").on("click", function() {
        des_habilitar(false, true);
        $("#btn_modificar").prop("disabled", true);
        $("#btn_eliminar").prop("disabled", true);
        datatable_enabled = false;
        $("#datosMetros").collapse("show");
    });

    $("#btn_eliminar").on("click", function() {
        Swal.fire({
            title: "¿Eliminar consumo de metros?",
            text: "¿Está seguro de eliminar el consumo de metros?",
            input: 'text',
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si",
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                var id_metros = $("#txt_id_metros").val();
                eliminar_metros(result.value, id_metros);
            }
        });
    });

    $("#btn_aceptar").on("click", function() {
        if ($("#form_metros").valid()) {
            guardar_metros();
        }
    });

    $("#btn_cancelar").on("click", function() {
        $("#form_metros")[0].reset();
        des_habilitar(true, false);
        datatable_enabled = true;
        $("#datosMetros").collapse("hide");
    });

    $("#btn_buscar_socio").on("click", function() {
        $("#divContenedorBuscarSocio").load(
            base_url + "/Formularios/ctrl_arranques/v_buscar_socio/ctrl_metros"
        ); 

        $('#dlg_buscar_socio').modal('show');
    });

    $("#dt_fecha_ingreso").datetimepicker({
        format: "DD-MM-YYYY"
    }).on("dp.change", function() {
        habilita_consumo_actual();
    });

    $("#dt_fecha_vencimiento").datetimepicker({
        format: "DD-MM-YYYY"
    }).on("dp.change", function() {
        habilita_consumo_actual();
        calcular_total_servicios();
    });

    $("#txt_c_actual").on("blur", function() {
        calcular_montos();
    });

    $("#txt_c_actual").keypress(function(event) {
        if(event.keyCode==13){
           this.blur();
        }
    });

    $("#txt_multa").on("blur", function() {
        this.value = peso.formateaNumero(this.value);
        calcular_montos();
    });

    $("#txt_multa").keypress(function(event) {
        if(event.keyCode==13){
           this.blur();
        }
    });

    $("#form_metros").validate({
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
            txt_id_socio: {
                required: true
            },
            dt_fecha_ingreso: {
                required: true
            },
            dt_fecha_vencimiento: {
                required: true
            },
            txt_c_anterior: {
                required: true,
                digits: true,
                maxlength: 11
            },
            txt_c_actual: {
                required: true,
                digits: true,
                maxlength: 11
            },
            txt_multa: {
                number: true,
                maxlength: 11
            }
        },
        messages: {
            txt_id_socio: {
                required: "Seleccione un socio, botón buscar"
            },
            dt_fecha_ingreso: {
                required: "Ingrese fecha de ingreso"
            },
            dt_fecha_vencimiento: {
                required: "Ingrese fecha de vencimiento"
            },
            txt_c_anterior: {
                required: "El consumo consumo_anterior es obligatorio",
                digits: "Solo números",
                maxlength: "Máximo 11 números"
            },
            txt_c_actual: {
                required: "El consumo actual es obligatorio",
                digits: "Solo números",
                maxlength: "Máximo 11 números"
            },
            txt_multa: {
                number: "Solo números",
                maxlength: "Máximo 11 números"
            }
        }
    });

    var grid_costo_metros = $("#grid_costo_metros").DataTable({
        responsive: true,
        paging: true,
        // scrollY: '50vh',
        // scrollCollapse: true,
        destroy: true,
        order: [[ 2, "asc" ]],
        ajax: base_url + "/Consumo/ctrl_metros/datatable_costo_metros/0",
        orderClasses: true,
        columns: [
            { "data": "id_costo_metros" },
            { "data": "metros" },
            { "data": "desde" },
            { "data": "hasta" },
            { "data": "costo" }
        ],
        "columnDefs": [
            { "targets": [0], "visible": false, "searchable": false }
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

    var grid_metros = $("#grid_metros").DataTable({
		responsive: true,
        paging: true,
        // scrollY: '50vh',
        // scrollCollapse: true,
        destroy: true,
        select: {
            toggleable: false
        },
        ajax: base_url + "/Consumo/ctrl_metros/datatable_metros",
        orderClasses: true,
        columns: [
            { "data": "id_metros" },
            { "data": "id_socio" },
            { "data": "rut_socio" },
            { "data": "rol_socio" },
            { "data": "nombre_socio" },
            { "data": "id_arranque" },
            { "data": "sector" },
            { "data": "monto_subsidio" },
            { "data": "fecha_ingreso" },
            { "data": "fecha_vencimiento" },
            { "data": "consumo_anterior" },
            { "data": "consumo_actual" },
            { "data": "metros" },
            { "data": "subtotal" },
            { "data": "multa" },
            { "data": "total_servicios" },
            { "data": "total_mes" },
            { "data": "usuario" },
            { "data": "fecha" },
            { 
                "data": "id_metros",
                "render": function(data, type, row) {
                    return "<button type='button' class='traza_metros btn btn-warning' title='Traza Metros'><i class='fas fa-shoe-prints'></i></button>";
                }
            }
        ],
        "columnDefs": [
            { "targets": [1, 2, 3, 5, 6, 8, 9, 10, 11], "visible": false, "searchable": false }
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

    $("#grid_metros tbody").on("click", "tr", function () {
        if (datatable_enabled) {
            var data = grid_metros.row($(this)).data();
            mostrar_datos_metros(data);
            des_habilitar(true, false);
            $("#btn_modificar").prop("disabled", false);
            $("#btn_eliminar").prop("disabled", false);
            $("#datosMetros").collapse("hide");
        }
    });

    $("#grid_metros tbody").on("click", "button.traza_metros", function () {
        if (datatable_enabled) {
            $("#divContenedorTrazaSubsidio").load(
                base_url + "/Consumo/ctrl_metros/v_metros_traza"
            ); 

            $('#dlg_traza_metros').modal('show');
        }
    });
});