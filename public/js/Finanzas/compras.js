function llenar_cmb_tipo_documento() {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: base_url + "/Formularios/Ctrl_arranques/llenar_cmb_tipo_documento",
    }).done( function(data) {
        $("#cmb_tipo_documento").html('');

        var opciones = "<option value=\"\">Seleccione tipo de documento</option>";
        
        for (var i = 0; i < data.length; i++) {
            opciones += "<option value=\"" + data[i].id + "\">" + data[i].tipo_documento + "</option>";
        }

        $("#cmb_tipo_documento").append(opciones);
    }).fail(function(error){
        respuesta = JSON.parse(error["responseText"]);
        alerta.error("alerta", respuesta.message);
    });
}

$(document).ready(function() {
	llenar_cmb_tipo_documento();

	$("#dt_fecha_documento").datetimepicker({
        format: "DD-MM-YYYY",
        useCurrent: false,
        locale: moment.locale("es")
    });

	var grid_productos_fac = $("#grid_productos_fac").DataTable({
		responsive: true,
        paging: false,
        destroy: true,
        select: {
            toggleable: false
        },
        orderClasses: true,
        searching: false,
        columns: [
            { "data": "id_producto" },
            { "data": "producto" },
            { "data": "cantidad" },
            { "data": "precio" },
            { 
                "data": "id_producto",
                "render": function(data, type, row) {
                    return "<button type='button' class='eliminar_producto btn btn-danger' title='Eliminar Producto'><i class=\"fas fa-trash\"></i></button>";
                }
            }
        ],
        "columnDefs": [
            { "targets": [0], "visible": false, "searchable": false }
        ],
        language: {
            "decimal": "",
            "emptyTable": "No ha ingresado productos",
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
});