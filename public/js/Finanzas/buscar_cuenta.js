$(document).ready(function() {
	var grid_buscar_cuentas = $("#grid_buscar_cuentas").DataTable({
		responsive: true,
		paging: true,
        destroy: true,
        order: [[ 2, "desc" ]],
        ajax: base_url + "/Finanzas/Ctrl_ingresos/datatable_buscar_cuenta",
        orderClasses: true,
        columns: [
            { "data": "id_cuenta" },
            { "data": "rut_cuenta" },
            { "data": "nombre_cuenta" },
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

    $("#grid_buscar_cuentas tbody").on("dblclick", "tr", function () {
        var tr = $(this).closest('tr');
        if ($(tr).hasClass('child') ) {
            tr = $(tr).prev();  
        }

        var data = grid_buscar_cuentas.row(tr).data();
        var id_cuenta = data["id_cuenta"];
        var rut_cuenta = data["rut_cuenta"];
        var nombre_cuenta = data["nombre_cuenta"];

        $("#txt_id_cuenta").val(id_cuenta);
        $("#txt_rut_cuenta").val(rut_cuenta);
        $("#txt_nombre_cuenta").val(nombre_cuenta);

        $('#dlg_buscador').modal('hide');
    });
});