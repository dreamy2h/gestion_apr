$(document).ready(function() {
    var origen = $("#txt_origen").val();

	var grid_buscar_socio = $("#grid_buscar_socio").DataTable({
		responsive: true,
		paging: true,
        scrollY: '50vh',
        scrollCollapse: true,
        destroy: true,
        order: [[ 3, "desc" ]],
        ajax: base_url + "/Formularios/" + origen + "/datatable_buscar_socio",
        orderClasses: true,
        columns: [
            { "data": "id_socio" },
            { "data": "rut" },
            { "data": "rol" },
            { "data": "nombre" },
            { "data": "fecha_entrada" }
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

    $("#grid_buscar_socio tbody").on("dblclick", "tr", function () {
        var data = grid_buscar_socio.row($(this)).data();
        $("#txt_id_socio").val(data["id_socio"]);
        $("#txt_rut_socio").val(data["rut"]);
        $("#txt_rol_socio").val(data["rol"]);
        $("#txt_nombre_socio").val(data["nombre"]);

        $('#dlg_buscar_socio').modal('hide');
    });
});