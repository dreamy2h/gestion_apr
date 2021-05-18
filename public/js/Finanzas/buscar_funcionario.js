$(document).ready(function() {
	var grid_buscar_funcionario = $("#grid_buscar_funcionario").DataTable({
		responsive: true,
		paging: true,
        destroy: true,
        order: [[ 2, "desc" ]],
        ajax: base_url + "/Finanzas/Ctrl_ingresos/datatable_buscar_funcionario",
        orderClasses: true,
        columns: [
            { "data": "id_funcionario" },
            { "data": "rut_funcionario" },
            { "data": "nombre_funcionario" }
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

    $("#grid_buscar_funcionario tbody").on("dblclick", "tr", function () {
        var tr = $(this).closest('tr');
        if ($(tr).hasClass('child') ) {
            tr = $(tr).prev();  
        }

        var data = grid_buscar_funcionario.row(tr).data();
        var id_funcionario = data["id_funcionario"];
        var rut_funcionario = data["rut_funcionario"];
        var nombre_funcionario = data["nombre_funcionario"];

        $("#txt_id_proveedor").val(id_funcionario);
        $("#txt_rut_proveedor").val(rut_funcionario);
        $("#txt_razon_social").val(nombre_funcionario);

        $('#dlg_buscador').modal('hide');
    });
});