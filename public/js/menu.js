var base_url = $("#txt_base_url").val();

function cargar_page(ruta) {
	$("#content").load(base_url + ruta);
}

$(document).ready(function() {
	$.ajax({
	    type: "POST",
	    dataType: "json",
	    url: base_url + "/Ctrl_menu/permisos_usuario",
	}).done( function(data) {
    	var menu = "";
    	var id_grupo;

        for (var i = 0; i < data.length; i++) {
        	if (id_grupo != data[i].id_grupo) {
        		if (i > 0) {
	            	menu += "</nav></div>"
	        	}
	        	menu += '<a class="nav-link collapsed" data-toggle="collapse" data-target="#' + data[i].collapse + '" aria-expanded="false" aria-controls="' + data[i].collapse + '">\
                            <div class="sb-nav-link-icon"><i class="' + data[i].icono_grupo + '"></i></div>\
                            ' + data[i].grupo + '\
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>\
                        </a>\
                        <div class="collapse" id="' + data[i].collapse + '" aria-labelledby="headingOne" data-parent="#sidenavAccordion">\
                        	<nav class="sb-sidenav-menu-nested nav">';
            	id_grupo = data[i].id_grupo;
        	}

        	menu += '<a class="nav-link" id="' + data[i].div_id + '" onclick="cargar_page(\'' + String(data[i].ruta) + '\')">\
                        <div class="sb-nav-link-icon"><i class="' + data[i].icono + '"></i></div> ' + data[i].permiso + '\
                    </a>';


        }

        $("#menu").html(menu);
	});

	// Formularios
	// $("#menu_socios").click(function() {
	// 	$("#content").load(base_url + "/Ctrl_menu/socios");
	// });

	// $("#menu_arranques").click(function() {
	// 	$("#content").load(base_url + "/Ctrl_menu/arranques");
	// });

	// $("#menu_sectores").click(function() {
	// 	$("#content").load(base_url + "/Ctrl_menu/sectores");
	// });

	// $("#menu_subsidios").click(function() {
	// 	$("#content").load(base_url + "/Ctrl_menu/subsidios");
	// });

	// $("#menu_convenios").click(function() {
	// 	$("#content").load(base_url + "/Ctrl_menu/convenios");
	// });

	// $("#menu_medidores").click(function() {
	// 	$("#content").load(base_url + "/Ctrl_menu/medidores");
	// });

	// // Consumo
	// $("#menu_metros").click(function() {
	// 	$("#content").load(base_url + "/Ctrl_menu/metros");
	// });

	// // Pagos
	// $("#menu_caja").click(function() {
	// 	$("#content").load(base_url + "/Ctrl_menu/caja");
	// });

	// $("#menu_hist_pago").click(function() {
	// 	$("#content").load(base_url + "/Ctrl_menu/historial_pagos");
	// });

	// $("#menu_boleta_electronica").click(function() {
	// 	$("#content").load(base_url + "/Ctrl_menu/boleta_electronica");
	// });

	// // Informes
	// $("#menu_socios_inf").click(function() {
	// 	$("#content").load(base_url + "/Ctrl_menu/informe_socios");
	// });

	// // Configuración
	// $("#menu_usuarios").click(function() {
	// 	$("#content").load(base_url + "/Ctrl_menu/usuarios");
	// });

	// $("#menu_apr").click(function() {
	// 	$("#content").load(base_url + "/Ctrl_menu/apr");
	// });

	// $("#menu_costo_metros").click(function() {
	// 	$("#content").load(base_url + "/Ctrl_menu/costo_metros");
	// });
});