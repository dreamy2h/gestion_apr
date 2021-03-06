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

$(document).ready(function() {
	$("#btn_pagar").prop("disabled", true);
	$("#txt_total_pagar").prop("readonly", true);
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
    	var total_pagar = peso.quitar_formato($("#txt_total_pagar").val());
    	
    	if (parseInt(total_pagar) > 0) {
	    	var numero = peso.quitar_formato(this.value);
	    	this.value = peso.formateaNumero(numero);
    	} else {
    		this.value = 0;
    		alerta.aviso("alerta", "Seleccione deudas a pagar");
    	}
    });

	$("#txt_vuelto").on("blur", function() {
		var numero = peso.quitar_formato(this.value);
    	this.value = peso.formateaNumero(numero);
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
});