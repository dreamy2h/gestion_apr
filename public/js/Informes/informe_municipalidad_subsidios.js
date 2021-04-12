var base_url = $("#txt_base_url").val();

var peso = {
    validaEntero: function  ( value ) {
        var RegExPattern = /[0-9]+$/;
        return RegExPattern.test(value);
    },
    formateaNumero: function (value) {
        if (peso.validaEntero(value))  {  
            var retorno = '';
            value = value.toString().split('').reverse().join('');
            var i = value.length;
            while(i>0) retorno += ((i%3===0&&i!=value.length)?'.':'')+value.substring(i--,i);
            return retorno;
        }
        return 0;
    },
    quitar_formato : function(numero){
        numero = numero.split('.').join('');
        return numero;
    }
}

function buscar_subsidios() {
    var mes_consumo = $("#dt_mes_consumo").val();
	$("#grid_subsidios").dataTable().fnReloadAjax(base_url + "/Informes/Ctrl_informe_municipal/datatable_informe_municipal/" + mes_consumo);
}

$(document).ready(function() {
	$("#dt_mes_consumo").datetimepicker({
        format: "MM-YYYY",
        useCurrent: false,
        locale: moment.locale("es")
    }).on("dp.change", function() {
        buscar_subsidios();
    });

	var grid_subsidios = $("#grid_subsidios").DataTable({
		responsive: true,
        paging: false,
        destroy: true,
        select: {
            toggleable: false
        },
        orderClasses: true,
        dom: 'Bfrtilp',
        columns: [
            { "data": "id_metros" },
            { "data": "rut_socio" },
            { "data": "nombre_socio" },
            { "data": "mes_cubierto" },
            { 
                "data": "subsidio",
                "render": function(data, type, row) {
                    return peso.formateaNumero(data);
                }
            }
        ],
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();
            $( api.column(4).footer()).html(
                peso.formateaNumero(api.column(4, {page:'current'} ).data().sum())
            );
        },
        buttons: [ 
            {
                extend:    'excelHtml5',
                text:      '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success',
                title: "Informe Municipal",
                footer: true,
                exportOptions: {
                    modifier: {
                        page: 'current'
                    },
                    format: {
                        body: function ( data, row, column, node ) {
                            const SUBSIDIOS = 4; 

                            switch(column) {
                                case SUBSIDIOS:
                                    return peso.quitar_formato(data);
                                    break;
                                default:
                                    return data;
                                    break;
                            }
                        },
                        footer: function ( data, row, column, node ) {
                            return peso.quitar_formato(data);
                        }
                    }
                }
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                title: "Informe Municipal",
                pageSize: 'LETTER',
                footer: true,
                exportOptions: {
                    modifier: {
                        page: 'current'
                    }
                }
            },
            {
                extend:    'print',
                text:      '<i class="fa fa-print"></i> Imprimir',
                titleAttr: 'Imprimir',
                className: 'btn btn-info',
                title: "Informe Municipal",
                footer: true,
                exportOptions: {
                    modifier: {
                        page: 'current'
                    }
                }
            },
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