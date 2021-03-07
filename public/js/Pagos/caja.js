var base_url = $("#txt_base_url").val();

function buscar_deuda() {
	var id_socio = $("#txt_id_socio").val();

	$("#grid_deuda").dataTable().fnReloadAjax(base_url + "/Pagos/ctrl_caja/datatable_deuda_socio/" + id_socio);

	setTimeout(function() {
		if ($("#grid_deuda").DataTable().data().count() > 0) {
			$("#btn_pagar").prop("disabled", false);
			$("#cmb_forma_pago").prop("disabled", false);
			$("#txt_entregado").prop("disabled", false);
			$("#txt_vuelto").prop("disabled", false);
		}
	}, 1000);
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

function sumar_deudas() {
    var total = 0;
    var datos = $("#grid_deuda").DataTable().rows(".selected").data();

    for (var i = 0; i < datos.length; i++) {
        total += parseInt(datos[i].deuda);
    }

    $("#txt_entregado").val(0);
    $("#txt_vuelto").val(0);
    $("#txt_total_pagar").val(peso.formateaNumero(total));
}

function calcular_vuelto() {
    var total_pagar = peso.quitar_formato($("#txt_total_pagar").val());
    var entregado = peso.quitar_formato($("#txt_entregado").val());
        
    if (parseInt(total_pagar) > 0) {
        if (parseInt(entregado) < parseInt(total_pagar)) {
            alerta.aviso("alerta", "Lo entregado no puede ser menor al total a pagar");
            $("#txt_entregado").val(0);
        } else {
            var vuelto = parseInt(entregado) - parseInt(total_pagar);
            $("#txt_vuelto").val(peso.formateaNumero(vuelto));

            var numero = peso.quitar_formato($("#txt_entregado").val());
            $("#txt_entregado").val(peso.formateaNumero(numero));
        }
    } else {
        $("#txt_entregado").val(0);
        alerta.aviso("alerta", "Seleccione deudas a pagar");
    }
}

function guardar_pago() {
    var total_pagar = peso.quitar_formato($("#txt_total_pagar").val());
    var entregado = peso.quitar_formato($("#txt_entregado").val());
    var vuelto = peso.quitar_formato($("#txt_vuelto").val());
    var id_socio = $("#txt_id_socio").val();

    if (parseInt(entregado) < parseInt(total_pagar)) {
        alerta.error("alerta", "Lo entregado no puede ser menor al total a pagar");
    } else {
        Swal.fire({
            title: "¿Efectuar Pago?",
            text: "¿Está seguro de efectuar el pago?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si",
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                var datos = $("#grid_deuda").DataTable().rows(".selected").data();
                var arr_ids_metros = [];

                for (var i = 0; i < datos.length; i++) {
                    arr_ids_metros.push(datos[i].id_metros);
                }

                $.ajax({
                    url: base_url + "/Pagos/ctrl_caja/guardar_pago",
                    type: "POST",
                    async: false,
                    data: {
                        id_socio: id_socio,
                        total_pagar: total_pagar,
                        entregado: entregado,
                        vuelto: vuelto,
                        arr_ids_metros: arr_ids_metros
                    },
                    success: function(respuesta) {
                        const OK = 1;
                        if (respuesta == OK) {
                            $("#txt_id_socio").val("");
                            $("#txt_rut_socio").val("");
                            $("#txt_rol").val("");
                            $("#txt_nombre_socio").val("");
                            $("#btn_pagar").prop("disabled", true);
                            $("#cmb_forma_pago").prop("disabled", true);
                            $("#txt_entregado").prop("disabled", true);
                            $("#txt_entregado").val("");
                            $("#txt_vuelto").prop("disabled", true);
                            $("#txt_vuelto").val("");
                            $("#txt_total_pagar").val("");

                            $("#grid_deuda").DataTable().clear().draw();

                            alerta.ok("alerta", "Pago guardado con éxito");
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
        });
    }
}

$(document).ready(function() {
    $("#txt_id_socio").prop("disabled", true);
    $("#txt_rut_socio").prop("disabled", true);
    $("#txt_rol").prop("disabled", true);
    $("#txt_nombre_socio").prop("disabled", true);
	$("#btn_pagar").prop("disabled", true);
	$("#txt_total_pagar").prop("readonly", true);
    $("#txt_vuelto").prop("readonly", true);
	$("#cmb_forma_pago").prop("disabled", true);
	$("#txt_entregado").prop("disabled", true);
	$("#txt_vuelto").prop("disabled", true);

	$("#btn_buscar_socio").on("click", function() {
        $("#divContenedorBuscarSocio").load(
            base_url + "/Formularios/ctrl_arranques/v_buscar_socio/ctrl_caja"
        ); 

        $('#dlg_buscar_socio').modal('show');
    });

    $("#txt_entregado").on("blur", function() {
    	calcular_vuelto();
    });

    $("#txt_entregado").on("keypress", function(e) {
        if (e.keyCode == 13) {
            this.blur();
        }
    });

    $("#txt_entregado").on("focus", function() {
        var entregado = peso.quitar_formato(this.value);
        if (entregado > 0) {
            this.value = entregado;
        } else {
            this.value = "";
        }
    });

	$("#txt_vuelto").on("blur", function() {
		var numero = peso.quitar_formato(this.value);
    	this.value = peso.formateaNumero(numero);
	});

    $("#btn_pagar").on("click", function() {
        guardar_pago();
    });

	var grid_deuda = $("#grid_deuda").DataTable({
		responsive: true,
        paging: true,
        destroy: true,
        // ajax: base_url + "/Formularios/ctrl_arranques/datatable_arranques",
        orderClasses: true,
        columns: [
            { "data": "id_metros" },
            { 
            	"data": "deuda",
            	"render": function(data, type, row) {
                    return peso.formateaNumero(data);
            	}
            },
            { "data": "fecha_vencimiento" }
        ],
        "columnDefs": [
            { "targets": [0], "visible": false, "searchable": false }
        ],
        select: "multi",
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
                "rows": "<br/>%d Deuda(s) seleccionada(s)"
            },
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Sig.",
                "previous": "Ant."
            }
        }
	});

    grid_deuda.on("select", function (e, dt, type, indexes) {
        sumar_deudas();
    }).on("deselect", function (e, dt, type, indexes) {
        sumar_deudas();
    });
});