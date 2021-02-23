$(document).ready(function() {
	$("#archivos").fileinput({
		uploadUrl: "",
		language: "es",
		theme: "fas",
	    uploadAsync: false,
	    minFileCount: 1,
	    maxFileCount: 20,
		showUpload: false, 
		showRemove: true
		// initialPreview: inicio_preview,
		// initialPreviewAsData: true,
		// initialPreviewConfig: inicio_preview_config,
	}).on("filebatchselected", function(event, files) {
		$("#archivos").fileinput("upload");
		// setTimeout("location.reload()", 1000);
	});
});