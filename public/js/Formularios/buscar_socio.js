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

    if (origen == "Ctrl_metros" || origen == "Ctrl_caja") {
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
        
        ruta = "/Consumo/Ctrl_metros";
    } else if (origen == "Ctrl_historial_pagos" || origen == "Ctrl_informe_socios" || origen == "Ctrl_boleta_electronica") {
        ruta = "/Pagos/Ctrl_historial_pagos";
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

        if (origen ==  "Ctrl_metros") {
            if (data["consumo_anterior"] == 0) {
                Swal.fire({
                    title: 'Ingrese consumo anterior',
                    input: 'text',
                    inputPlaceholder: 'Ingreso un número',
                    showCancelButton: true,
                    inputValidator: (value) => {
                        return new Promise((resolve) => {
                            if (value >= 0 && value != "") {
                                resolve()
                                $("#txt_id_arranque").val(data["id_arranque"]);
                                $("#txt_sector").val(data["sector"]);
                                $("#txt_subsidio").val(data["subsidio"]);
                                $("#txt_tope_subsidio").val(data["tope_subsidio"]);
                                $("#txt_c_anterior").val(value);
                                $("#txt_diametro").val(data["diametro"]);
                                $("#txt_cargo_fijo").val(peso.formateaNumero(data["cargo_fijo"]));
                                $("#dt_fecha_ingreso").prop("readonly", false);
                                $("#dt_fecha_vencimiento").prop("readonly", false);
                                $("#grid_costo_metros").dataTable().fnReloadAjax(base_url + "/Consumo/Ctrl_metros/datatable_costo_metros/0/" + data["id_diametro"]);
                                $('#dlg_buscar_socio').modal('hide');
                            } else {
                                resolve("Ingrese un número válido");
                            }
                        })
                    }
                });
            } else {
                $("#txt_id_arranque").val(data["id_arranque"]);
                $("#txt_sector").val(data["sector"]);
                $("#txt_subsidio").val(data["subsidio"]);
                $("#txt_tope_subsidio").val(data["tope_subsidio"]);
                $("#txt_c_anterior").val(data["consumo_anterior"]);
                $("#txt_diametro").val(data["diametro"]);
                $("#txt_cargo_fijo").val(peso.formateaNumero(data["cargo_fijo"]));
                $("#dt_fecha_ingreso").prop("readonly", false);
                $("#dt_fecha_vencimiento").prop("readonly", false);
                $("#grid_costo_metros").dataTable().fnReloadAjax(base_url + "/Consumo/Ctrl_metros/datatable_costo_metros/0/" + data["id_diametro"]);
                $('#dlg_buscar_socio').modal('hide');
            }
        } else if (origen == "Ctrl_caja") {
            buscar_deuda();
            $('#dlg_buscar_socio').modal('hide');
        } else if (origen == "Ctrl_historial_pagos") {
            buscar_pagos();
            $('#dlg_buscar_socio').modal('hide');
        } else if (origen == "Ctrl_informe_socios") {
            buscar_socios();
            $('#dlg_buscar_socio').modal('hide');
        } else if (origen == "Ctrl_boleta_electronica") { 
            buscar_boletas();
            $('#dlg_buscar_socio').modal('hide');
        } else {
            $('#dlg_buscar_socio').modal('hide');
        }
    });

    setTimeout(function() {
        $('#grid_buscar_socio_filter input[type=search]').focus();    
    }, 500);
    
});