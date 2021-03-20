var base_url = $("#txt_base_url").val();

function buscar_socios() {
    var id_socio = $("#txt_id_socio").val();
    var desde_entrada = $("#dt_desde_entrada").val();
    var hasta_entrada = $("#dt_hasta_entrada").val();
    var desde_nac = $("#dt_desde_nac").val();
    var hasta_nac = $("#dt_hasta_nac").val();
    var calle = $("#txt_calle").val();
    var n_casa = $("#txt_n_casa").val();
    var resto_direccion = $("#txt_resto_direccion").val();
    var id_sexo = $("#cmb_sexo").val();
    var estado = $("#cmb_estado").val();

    var datosBusqueda = [id_socio, desde_entrada, hasta_entrada, desde_nac, hasta_nac, calle, n_casa, resto_direccion, id_sexo, estado];

    $("#grid_socios").dataTable().fnReloadAjax(base_url + "/Informes/ctrl_informe_socios/datatable_informe_socios/" + datosBusqueda);
}

function exportar_excel() {
    var id_socio = $("#txt_id_socio").val();
    var desde_entrada = $("#dt_desde_entrada").val();
    var hasta_entrada = $("#dt_hasta_entrada").val();
    var desde_nac = $("#dt_desde_nac").val();
    var hasta_nac = $("#dt_hasta_nac").val();
    var calle = $("#txt_calle").val();
    var n_casa = $("#txt_n_casa").val();
    var resto_direccion = $("#txt_resto_direccion").val();
    var id_sexo = $("#cmb_sexo").val();
    var estado = $("#cmb_estado").val();

    var datosBusqueda = [id_socio, desde_entrada, hasta_entrada, desde_nac, hasta_nac, calle, n_casa, resto_direccion, id_sexo, estado];

    var url = base_url + "/Informes/ctrl_informe_socios/exportar_excel/" + datosBusqueda;
    window.open(url, target = "medio", "width=1200,height=800,location=0,scrollbars=yes,");
}

$(document).ready(function() {
    $("#txt_id_socio").prop("readonly", true);
    $("#txt_rut_socio").prop("readonly", true);
    $("#txt_rol").prop("readonly", true);
    $("#txt_nombre_socio").prop("readonly", true);

    $("#btn_buscar_socio").on("click", function() {
        $("#divContenedorBuscarSocio").load(
            base_url + "/Formularios/ctrl_arranques/v_buscar_socio/ctrl_informe_socios"
        ); 

        $('#dlg_buscar_socio').modal('show');
    });

    $("#dt_desde_entrada").datetimepicker({
        format: "DD-MM-YYYY",
        useCurrent: false,
        locale: moment.locale("es")
    });

    $("#dt_hasta_entrada").datetimepicker({
        format: "DD-MM-YYYY",
        useCurrent: false,
        locale: moment.locale("es")
    });

    $("#dt_desde_nac").datetimepicker({
        format: "DD-MM-YYYY",
        useCurrent: false,
        locale: moment.locale("es")
    });

    $("#dt_hasta_nac").datetimepicker({
        format: "DD-MM-YYYY",
        useCurrent: false,
        locale: moment.locale("es")
    });

    $("#btn_buscar").on("click", function() {
        if ($("#form_informe_socios").valid()) {
            buscar_socios();
        }
    });

    $("#btn_excel").on("click", function() {
        exportar_excel();
    });

    var datosBusqueda = ["", "", "", "", "", "", "", "", "", ""];

    var grid_socios = $("#grid_socios").DataTable({
		responsive: true,
        scrollCollapse: true,
        destroy: true,
        ajax: base_url + "/Informes/ctrl_informe_socios/datatable_informe_socios/" + datosBusqueda,
        orderClasses: true,
        columns: [
            { "data": "id_socio" },
            { "data": "rut" },
            { "data": "rol" },
            { "data": "nombre_completo" },
            { "data": "fecha_entrada" },
            { "data": "fecha_nacimiento" },
            { "data": "sexo" },
            { "data": "calle" },
            { "data": "numero" },
            { "data": "resto_direccion" },
            { "data": "comuna" },
            { "data": "estado" }
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
});