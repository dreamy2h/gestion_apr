var base_url = $("#txt_base_url").val();
var datatable_enabled = true;

function des_habilitar(a, b) {
    $("#btn_nuevo").prop("disabled", b);
    $("#btn_modificar").prop("disabled", a);
    $("#btn_aceptar").prop("disabled", a);
    $("#btn_cancelar").prop("disabled", a);

    $("#txt_rut_apr").prop("disabled", a);
    $("#txt_nombre_apr").prop("disabled", a);
    $("#txt_hash_sii").prop("disabled", a);
    $("#txt_codigo_comercio").prop("disabled", a);
    $("#cmb_region").prop("disabled", a);
    $("#cmb_provincia").prop("disabled", a);
    $("#cmb_comuna").prop("disabled", a);
    $("#txt_calle").prop("disabled", a);
    $("#txt_numero").prop("disabled", a);
    $("#txt_resto_direccion").prop("disabled", a);
    $("#txt_tope_subsidio").prop("disabled", a);
}

function mostrar_datos_apr(data) {
    $("#txt_id_apr").val(data["id_apr"]);
    $("#txt_rut_apr").val(data["rut_apr"]);
    $("#txt_nombre_apr").val(data["nombre_apr"]);
    $("#txt_hash_sii").val(data["hash_sii"]);
    $("#txt_codigo_comercio").val(data["codigo_comercio"]);
    $("#cmb_region").val(data["id_region"]);
    $("#cmb_provincia").val(data["id_provincia"]);
    $("#cmb_comuna").val(data["id_comuna"]);
    $("#txt_calle").val(data["calle"]);
    $("#txt_numero").val(data["numero"]);
    $("#txt_resto_direccion").val(data["resto_direccion"]);
    $("#txt_tope_subsidio").val(data["tope_subsidio"]);
}

function llenar_cmb_region() {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: base_url + "/Configuracion/Ctrl_usuarios/llenar_cmb_region",
    }).done( function(data) {
        $("#cmb_region").html('');

        opciones_region = "<option value=\"\">Seleccione una region</option>";
        
        for (var i = 0; i < data.length; i++) {
            opciones_region += "<option value=\"" + data[i].id + "\">" + data[i].region + "</option>";
        }

        $("#cmb_region").append(opciones_region);
    }).fail(function(error){
        respuesta = JSON.parse(error["responseText"]);
        alerta.error("alerta", respuesta.message);
    });
}

function llenar_cmb_provincia() {
    var id_region = $("#cmb_region").val();

    $.ajax({
        type: "GET",
        dataType: "json",
        url: base_url + "/Configuracion/Ctrl_usuarios/llenar_cmb_provincia/" + id_region,
    }).done( function(data) {
        $("#cmb_provincia").html('');

        var opciones = "<option value=\"\">Seleccione una provincia</option>";
        
        for (var i = 0; i < data.length; i++) {
            opciones += "<option value=\"" + data[i].id + "\">" + data[i].provincia + "</option>";
        }

        $("#cmb_provincia").append(opciones);
    }).fail(function(error){
        respuesta = JSON.parse(error["responseText"]);
        alerta.error("alerta", respuesta.message);
    });
}

function llenar_cmb_comuna() {
    var id_provincia = $("#cmb_provincia").val();

    $.ajax({
        type: "GET",
        dataType: "json",
        url: base_url + "/Configuracion/Ctrl_usuarios/llenar_cmb_comuna/" + id_provincia,
    }).done( function(data) {
        $("#cmb_comuna").html('');

        var opciones = "<option value=\"\">Seleccione una comuna</option>";
        
        for (var i = 0; i < data.length; i++) {
            opciones += "<option value=\"" + data[i].id + "\">" + data[i].comuna + "</option>";
        }

        $("#cmb_comuna").append(opciones);
    }).fail(function(error){
        respuesta = JSON.parse(error["responseText"]);
        alerta.error("alerta", respuesta.message);
    });
}

function guardar_apr() {
    var id_apr = $("#txt_id_apr").val();
    var rut_apr = $("#txt_rut_apr").val().split(".").join("");
    var nombre_apr = $("#txt_nombre_apr").val();
    var hash_sii = $("#txt_hash_sii").val();
    var codigo_comercio = $("#txt_codigo_comercio").val();
    var id_comuna = $("#cmb_comuna").val();
    var calle = $("#txt_calle").val();
    var numero = $("#txt_numero").val();
    var resto_direccion = $("#txt_resto_direccion").val();
    var tope_subsidio = $("#txt_tope_subsidio").val();

    $.ajax({
        url: base_url + "/Configuracion/Ctrl_apr/guardar_apr",
        type: "POST",
        async: false,
        data: {
            id_apr: id_apr,
            rut_apr: rut_apr,
            nombre_apr: nombre_apr,
            hash_sii: hash_sii,
            codigo_comercio: codigo_comercio,
            id_comuna: id_comuna,
            calle: calle,
            numero: numero,
            resto_direccion: resto_direccion,
            tope_subsidio: tope_subsidio
        },
        success: function(respuesta) {
            const OK = 1;
            if (respuesta == OK) {
                $("#grid_apr").dataTable().fnReloadAjax(base_url + "/Configuracion/Ctrl_apr/datatable_apr");
                $("#form_APR")[0].reset();
                des_habilitar(true, false);
                alerta.ok("alerta", "APR guardada con éxito");
                $("#datosAPR").collapse();
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

var Fn = {
    // Valida el rut con su cadena completa "XXXXXXXX-X"
    validaRut : function (rutCompleto) {
        var rutCompleto_ =  rutCompleto.replace(/\./g, "");

        if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test( rutCompleto_ ))
            return false;
        var tmp     = rutCompleto_.split('-');
        var digv    = tmp[1]; 
        var rut     = tmp[0];
        if ( digv == 'K' ) digv = 'k' ;
        return (Fn.dv(rut) == digv );
    },
    dv : function(T){
        var M=0,S=1;
        for(;T;T=Math.floor(T/10))
            S=(S+T%10*(9-M++%6))%11;
        return S?S-1:'k';
    },
    formatear : function(rut){
        var tmp = this.quitar_formato(rut);
        var rut = tmp.substring(0, tmp.length - 1), f = "";
        while(rut.length > 3) {
            f = '.' + rut.substr(rut.length - 3) + f;
            rut = rut.substring(0, rut.length - 3);
        }
        return ($.trim(rut) == '') ? '' : rut + f + "-" + tmp.charAt(tmp.length-1);
    },
    quitar_formato : function(rut){
        rut = rut.split('-').join('').split('.').join('');
        return rut;
    }
}


$(document).ready(function() {
    $("#txt_id_apr").prop("disabled", true);
    des_habilitar(true, false);
    llenar_cmb_region();
    llenar_cmb_provincia();
    llenar_cmb_comuna();

    $("#btn_nuevo").on("click", function() {
        des_habilitar(false, true);
        $("#form_APR")[0].reset();

        $("#btn_modificar").prop("disabled", true);
        $("#datosAPR").collapse("show");
    });

    $("#btn_modificar").on("click", function() {
        des_habilitar(false, true);
        $("#btn_modificar").prop("disabled", true);
        datatable_enabled = false;
        $("#datosAPR").collapse("show");
    });

    $("#btn_aceptar").on("click", function() {
        if ($("#form_APR").valid()) {
            guardar_apr();
        }
    });

    $("#btn_cancelar").on("click", function() {
        $("#form_APR")[0].reset();
        des_habilitar(true, false);
        datatable_enabled = true;
        $("#datosAPR").collapse("hide");
    });

    $("#txt_rut_apr").on("blur", function() {
        if (Fn.validaRut(Fn.formatear(this.value))) {
            $("#txt_rut_apr").val(convertirMayusculas(Fn.formatear(this.value)));
        } else {
            alerta.error("alerta", "RUT incorrecto");
            $("#txt_rut_apr").val("");
            setTimeout(function() { $("#txt_rut_apr").focus(); }, 100);
        }
    });

    $("#cmb_region").on("change", function() {
        llenar_cmb_provincia();
    });

    $("#cmb_provincia").on("change", function() {
        llenar_cmb_comuna();
    });

    $("#txt_nombre_apr").on("blur", function() {
        this.value = convertirMayusculas(this.value);
    });

    $("#txt_calle").on("blur", function() {
        this.value = convertirMayusculas(this.value);
    });

    $("#txt_resto_direccion").on("blur", function() {
        this.value = convertirMayusculas(this.value);
    });

    $.validator.addMethod("letras", function(value, element) {
        return this.optional(element) || /^[a-zA-ZñÑáÁéÉíÍóÓúÚ ]*$/.test(value);
    });

    $.validator.addMethod("charspecial", function(value, element) {
        return this.optional(element) || /^[^;\"'{}\[\]^<>=]+$/.test(value);
    });

    $.validator.addMethod("rut", function(value, element) {
        return this.optional(element) || /^[0-9-.Kk]*$/.test(value);
    });

    $.validator.addMethod("maxnumero", function(value, element) {
        if (value > 100) { return false; } else { return true; }
    })

    $("#form_APR").validate({
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
            txt_rut_apr: {
                rut: true,
                required: true,
                maxlength: 12
            },
            txt_nombre_apr: {
                required: true,
                letras: true,
                maxlength: 45
            },
            txt_hash_sii: {
                maxlength: 200 
            },
            txt_codigo_comercio: {
                maxlength: 200
            },
            cmb_region: {
                required: true
            },
            cmb_provincia: {
                required: true
            },
            cmb_comuna: {
                required: true
            },
            txt_calle: {
                letras: true,
                maxlength: 60
            },
            txt_numero: {
                digits: true,
                maxlength: 6
            },
            txt_resto_direccion: {
                charspecial: true,
                maxlength: 200
            },
            txt_tope_subsidio: {
                digits: true,
                maxlength: 3,
                maxnumero: true
            }
        },
        messages: {
            txt_rut_apr: {
                rut: "Solo números o k",
                required: "El RUT de la APR es obligatorio",
                maxlength: "Máximo 10 caracteres"
            },
            txt_nombre_apr: {
                required: "El nombre de la APR es obligatorio",
                letras: "Solo puede ingresar letras",
                maxlength: "Máximo 45 caracteres"
            },
            txt_hash_sii: {
                maxlength: "Máximo 200 caracteres"
            },
            txt_codigo_comercio: {
                maxlength: "Máximo 200 caracteres"
            },
            cmb_region: {
                required: "La región es obligatoria"
            },
            cmb_provincia: {
                required: "La provincia es obligatoria"
            },
            cmb_comuna: {
                required: "La comuna es obligatoria"
            },
            txt_calle: {
                letras: "Solo puede ingresar letras",
                maxlength: "Máximo 60 caracteres"
            },
            txt_numero: {
                digits: "Solo números",
                maxlength: "Máximo 6 digitos"
            },
            txt_resto_direccion: {
                charspecial: "Tiene caracteres no permitidos",
                maxlength: "Máximo 200 caracteres"
            },
            txt_tope_subsidio: {
                digits: "Solo números",
                maxlength: "Máximo 3 números",
                maxnumero: "Máximo hasta 100"
            }
        }
    });

    var grid_apr = $("#grid_apr").DataTable({
		responsive: true,
        paging: true,
        scrollY: '50vh',
        scrollCollapse: true,
        destroy: true,
        select: {
            toggleable: false
        },
        ajax: base_url + "/Configuracion/Ctrl_apr/datatable_apr",
        orderClasses: true,
        columns: [
            { "data": "id_apr" },
            { "data": "rut_apr" },
            { "data": "nombre_apr" },
            { "data": "hash_sii" },
            { "data": "codigo_comercio" },
            { "data": "tope_subsidio" },
            { "data": "id_region" },
            { "data": "id_provincia" },
            { "data": "id_comuna" },
            { "data": "comuna" },
            { "data": "calle" },
            { "data": "numero" },
            { "data": "resto_direccion" },
            { "data": "usuario" },
            { "data": "fecha" },
            { 
                "data": "id_apr",
                "render": function(data, type, row) {
                    return "<button type='button' class='traza_apr btn btn-warning' title='Traza APR'><i class='fas fa-shoe-prints'></i></button>";
                }
            }
        ],
        "columnDefs": [
            { "targets": [0, 3, 4, 5, 6, 7, 8, 12], "visible": false, "searchable": false }
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

    $("#grid_apr tbody").on("click", "tr", function () {
        if (datatable_enabled) {
            var data = grid_apr.row($(this)).data();
            mostrar_datos_apr(data);
            des_habilitar(true, false);
            $("#btn_modificar").prop("disabled", false);
            $("#datosAPR").collapse("hide");
        }
    });

    $("#grid_apr tbody").on("click", "button.traza_apr", function () {
        if (datatable_enabled) {
            $("#divContenedorTrazaAPR").load(
                base_url + "/Configuracion/Ctrl_apr/v_apr_traza"
            ); 

            $('#dlg_traza_apr').modal('show');
        }
    });
});