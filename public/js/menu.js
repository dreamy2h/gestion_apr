$(document).ready(function() {
	var base_url = $("#txt_base_url").val();

	// Formularios
	$("#menu_socios").click(function() {
		$("#content").load(base_url + "/ctrl_menu/socios");
	});

	$("#menu_arranques").click(function() {
		$("#content").load(base_url + "/ctrl_menu/arranques");
	});

	$("#menu_sectores").click(function() {
		$("#content").load(base_url + "/ctrl_menu/sectores");
	});

	$("#menu_subsidios").click(function() {
		$("#content").load(base_url + "/ctrl_menu/subsidios");
	});

	$("#menu_convenios").click(function() {
		$("#content").load(base_url + "/ctrl_menu/convenios");
	});

	$("#menu_medidores").click(function() {
		$("#content").load(base_url + "/ctrl_menu/medidores");
	});

	// Consumo
	$("#menu_metros").click(function() {
		$("#content").load(base_url + "/ctrl_menu/metros");
	});

	// Pagos
	$("#menu_caja").click(function() {
		$("#content").load(base_url + "/ctrl_menu/caja");
	});

	$("#menu_hist_pago").click(function() {
		$("#content").load(base_url + "/ctrl_menu/historial_pagos");
	});

	$("#menu_boleta_electronica").click(function() {
		$("#content").load(base_url + "/ctrl_menu/boleta_electronica");
	});

	// Informes
	$("#menu_socios_inf").click(function() {
		$("#content").load(base_url + "/ctrl_menu/informe_socios");
	});

	// Configuración
	$("#menu_usuarios").click(function() {
		$("#content").load(base_url + "/ctrl_menu/usuarios");
	});

	$("#menu_apr").click(function() {
		$("#content").load(base_url + "/ctrl_menu/apr");
	});

	$("#menu_costo_metros").click(function() {
		$("#content").load(base_url + "/ctrl_menu/costo_metros");
	});
});