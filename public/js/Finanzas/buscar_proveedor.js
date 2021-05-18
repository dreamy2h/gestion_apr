$(document).ready(function() {
	var grid_buscar_proveedores = $("#grid_buscar_proveedores").DataTable({
		responsive: true,
		paging: true,
        destroy: true,
        order: [[ 2, "desc" ]],
        ajax: base_url + "/Finanzas/Ctrl_ingresos/datatable_buscar_proveedor",
        orderClasses: true,
        columns: [
            { "data": "id_proveedor" },
            { "data": "rut_proveedor" },
            { "data": "razon_social" },
            { "data": "giro" }
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

    $("#grid_buscar_proveedores tbody").on("dblclick", "tr", function () {
        var tr = $(this).closest('tr');
        if ($(tr).hasClass('child') ) {
            tr = $(tr).prev();  
        }

        var data = grid_buscar_proveedores.row(tr).data();
        var id_proveedor = data["id_proveedor"];
        var rut_proveedor = data["rut_proveedor"];
        var razon_social = data["razon_social"];

        $("#txt_id_proveedor").val(id_proveedor);
        $("#txt_rut_proveedor").val(rut_proveedor);
        $("#txt_razon_social").val(razon_social);

        $('#dlg_buscador').modal('hide');
    });
});