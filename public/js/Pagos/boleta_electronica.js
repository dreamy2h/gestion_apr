var base_url = $("#txt_base_url").val();

function llenar_cmb_sector() {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: base_url + "/Formularios/ctrl_arranques/llenar_cmb_sector",
    }).done( function(data) {
        $("#cmb_sector").html('');

        var opciones = "<option value=\"\">Seleccione un sector</option>";
        
        for (var i = 0; i < data.length; i++) {
            opciones += "<option value=\"" + data[i].id + "\">" + data[i].sector + "</option>";
        }

        $("#cmb_sector").append(opciones);
    }).fail(function(error){
        respuesta = JSON.parse(error["responseText"]);
        alerta.error("alerta", respuesta.message);
    });
}

function buscar_boletas() {
	var id_socio = $("#txt_id_socio").val();
	var mes_año = $("#dt_mes_año").val();
	var id_sector = $("#cmb_sector").val();

	if (id_socio != "" || mes_año != "" || id_sector != "") {
		var datosBusqueda = [id_socio, mes_año, id_sector];

		$("#grid_boletas").dataTable().fnReloadAjax(base_url + "/Pagos/ctrl_boleta_electronica/datatable_boleta_electronica/" + datosBusqueda);
	} else {
		alerta.aviso("alerta", "Debe seleccionar un items");
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

function seleccionardp() {
   
}

$(document).ready(function() {
	$("#txt_id_socio").prop("readonly", true);
    $("#txt_rut_socio").prop("readonly", true);
    $("#txt_rol").prop("readonly", true);
    $("#txt_nombre_socio").prop("readonly", true);

    llenar_cmb_sector();

	$("#btn_buscar_socio").on("click", function() {
        $("#divContenedorBuscarSocio").load(
            base_url + "/Formularios/ctrl_arranques/v_buscar_socio/ctrl_boleta_electronica"
        ); 

        $('#dlg_buscar_socio').modal('show');
    });

    $("#dt_mes_año").datetimepicker({
        format: "MM-YYYY",
        useCurrent: false,
        locale: moment.locale("es")
    });

    $("#btn_buscar").on("click", function() {
		buscar_boletas();
    });

    $("#btn_limpiar").on("click", function() {
    	$("#form_boleta_electronica")[0].reset();
    });

    $("#btn_emitir").on("click", function() {
    	var arr_boletas = [];
	    $("#grid_boletas tr").each(function(value) {
	        if ($(this).closest("tr").hasClass("selected")) {
	            var fila = $(this).closest("tr");
	            var id_metros = fila[0].id_metros;
	            arr_boletas.push(id_metros);
	        }
	    });

	    alert(arr_boletas);
    });

	var grid_boletas = $("#grid_boletas").DataTable({
		responsive: true,
        paging: true,
        destroy: true,
        select: {
            style: "multi"
        },
        orderClasses: true,
        columns: [
            { "data": "id_metros" },
            { "data": "id_socio" },
            { "data": "rut_socio" },
            { "data": "rol_socio" },
            { "data": "nombre_socio" },
            { "data": "id_arranque" },
            { "data": "subsidio" },
            { 
                "data": "monto_subsidio",
                "render": function(data, type, row) {
                    return peso.formateaNumero(data);
                }
            },
            { "data": "sector" },
            { "data": "id_diametro" },
            { "data": "diametro" },
            { "data": "fecha_ingreso" },
            { "data": "fecha_vencimiento" },
            { "data": "consumo_anterior" },
            { "data": "consumo_actual" },
            { "data": "metros" },
            { 
                "data": "subtotal",
                "render": function(data, type, row) {
                    return peso.formateaNumero(data);
                }
            },
            { 
                "data": "multa",
                "render": function(data, type, row) {
                    return peso.formateaNumero(data);
                }
            },
            { 
                "data": "total_servicios",
                "render": function(data, type, row) {
                    return peso.formateaNumero(data);
                }
            },
            { 
                "data": "total_mes",
                "render": function(data, type, row) {
                    return peso.formateaNumero(data);
                }
            },
            { 
                "data": "id_metros",
                "render": function(data, type, row) {
                    return "<button type='button' class='detalle_metros btn btn-light' title='Detalle del Consumo de Metros'><i class='fas fa-tint'></i> </button>";
                }
            }
        ],
        "columnDefs": [
            { "targets": [0, 1, 2, 3, 5, 6, 7, 8, 9, 10, 11, 13, 14, 16, 17, 18], "visible": false, "searchable": false }
        ],
        dom: 'Bfrtip',
        buttons: [
            'selectAll',
            'selectNone',
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
                "rows": "<br/>%d Boletas Seleccionadas"
            },
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Sig.",
                "previous": "Ant."
            }
        }
	});
});