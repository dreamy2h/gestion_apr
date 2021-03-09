$(document).ready(function() {
    var origen = $("#txt_origen").val();

    var columnas = [
        { "data": "id_socio" },
        { "data": "rut" },
        { "data": "rol" },
        { "data": "nombre" },
        { "data": "fecha_entrada" }
    ];

    var columnasOcultas = false;

    if (origen == "ctrl_metros" || origen == "ctrl_caja") {
        columnas.push(
            {"data": "id_arranque"}, 
            {"data": "id_diametro"}, 
            {"data": "diametro"}, 
            {"data": "sector"}, 
            {"data": "subsidio"},
            {"data": "tope_subsidio"},
            {"data": "consumo_anterior"}, 
            {"data": "cargo_fijo"}
        );

        columnasOcultas = [
            { "targets": [5, 6, 7, 8, 9, 10 ,11, 12], "visible": false, "searchable": false }
        ];
        
        ruta = "/Consumo/ctrl_metros";
    } else if (origen == "ctrl_historial_pagos") {
        ruta = "/Pagos/" + origen;
    } else {
        ruta = "/Formularios/" + origen;
    }

	var grid_buscar_socio = $("#grid_buscar_socio").DataTable({
		responsive: true,
		paging: true,
        // scrollY: '50vh',
        // scrollCollapse: true,
        destroy: true,
        order: [[ 3, "desc" ]],
        ajax: base_url +  ruta + "/datatable_buscar_socio",
        orderClasses: true,
        columns: columnas,
        "columnDefs": columnasOcultas,
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
        $("#txt_rol").val(data["rol"]);
        $("#txt_nombre_socio").val(data["nombre"]);

        if (origen ==  "ctrl_metros") {
            if (data["consumo_anterior"] == 0) {
                Swal.fire({
                    title: 'Ingrese consumo anterior',
                    input: 'text',
                    inputPlaceholder: 'Ingreso un número',
                    showCancelButton: true,
                    inputValidator: (value) => {
                        return new Promise((resolve) => {
                            if (value >= 0) {
                                resolve()
                                $("#txt_id_arranque").val(data["id_arranque"]);
                                $("#txt_sector").val(data["sector"]);
                                $("#txt_subsidio").val(data["subsidio"]);
                                $("#txt_tope_subsidio").val(data["tope_subsidio"]);
                                $("#txt_c_anterior").val(value);
                                $("#txt_diametro").val(data["diametro"]);
                                $("#dt_fecha_ingreso").prop("readonly", false);
                                $("#dt_fecha_vencimiento").prop("readonly", false)
                                $("#grid_costo_metros").dataTable().fnReloadAjax(base_url + "/Consumo/ctrl_metros/datatable_costo_metros/0/" + data["id_diametro"]);
                                $('#dlg_buscar_socio').modal('hide');
                            } else {
                                resolve("Ingrese un número válido")
                            }
                        })
                    }
                });
            } else {
                $("#txt_id_arranque").val(data["id_arranque"]);
                $("#txt_sector").val(data["sector"]);
                $("#txt_subsidio").val(data["subsidio"]);
                $("#txt_c_anterior").val(data["consumo_anterior"]);
                $("#txt_diametro").val(data["diametro"]);
                $("#dt_fecha_ingreso").prop("readonly", false);
                $("#dt_fecha_vencimiento").prop("readonly", false);
                $("#grid_costo_metros").dataTable().fnReloadAjax(base_url + "/Consumo/ctrl_metros/datatable_costo_metros/0/" + data["id_diametro"]);
                $('#dlg_buscar_socio').modal('hide');
            }
        } else if (origen == "ctrl_caja") {
            buscar_deuda();
            $('#dlg_buscar_socio').modal('hide');
        } else if (origen == "ctrl_historial_pagos") {
            buscar_pagos();
            $('#dlg_buscar_socio').modal('hide');
        } else {
            $('#dlg_buscar_socio').modal('hide');
        }
    });
});