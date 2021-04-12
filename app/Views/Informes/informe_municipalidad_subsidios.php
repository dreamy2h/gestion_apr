<main>
    <div class="container-fluid">
        <h3 class="mt-4" align="center"><i class="fas fa-file-invoice mr-1"></i> Informe Municipal de Subsidios</h3>
        <div class="alert alerta-fijo hidden" role="alert" id="alerta"></div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            	<div class="card mb-4">
                	<div class="card-header" data-toggle="collapse" data-target="#informeMunicipal" aria-expanded="false" aria-controls="informeMunicipal">
                		<i class="fas fa-file-invoice mr-1"></i> Buscar
                	</div>
                	<div class="card shadow mb-12 collapse" id="informeMunicipal">
			            <div class="card-body">
			            	<div class="container-fluid">
			            		<form id="form_histPagos" name="form_histPagos" encType="multipart/form-data">
				                    <div class="row">
				                    	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
				                    		<div class="form-group">
				                    			<label class="small mb-1" for="dt_mes_consumo">Mes Consumo</label>
				                                <input type='text' class="form-control" id='dt_mes_consumo' name="dt_mes_consumo" />
				                    		</div>
				                    	</div>
				                    </div>
				                </form>
			            	</div>
			            </div>
			        </div>
			    </div>
			</div>
		</div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            	<div class="card mb-4">
                	<div class="card-header" data-toggle="collapse" data-target="#listaMunicipal" aria-expanded="false" aria-controls="listaMunicipal">
                		<i class="fas fa-file-invoice mr-1"></i> Historial de Pagos (Doble click, Ver Detalle)
                	</div>
                	<div class="card shadow mb-12" id="listaMunicipal">
			            <div class="card-body">
			            	<div class="container-fluid">
					        	<div class="table-responsive">
				                    <table id="grid_subsidios" class="table table-bordered" width="100%">
				                        <thead class="thead-dark">
				                            <tr>
				                            	<th>Folio Mt.</th>
				                            	<th>RUT Socio</th>
				                            	<th>Nombre Socio</th>
				                            	<th>Mes Cubierto</th>
				                            	<th>Subsidio</th>
				                            </tr>
				                        </thead>
				                        <tfoot>
				                            <tr>
				                            	<th></th>
				                            	<th></th>
				                            	<th></th>
				                            	<th></th>
				                            	<th></th>
				                            </tr>
				                        </tfoot>
				                    </table> 
				                </div>
				            </div>
				        </div>
				    </div>
				</div>
            </div>
	    </div>
	</div>
</main>
<script type="text/javascript" src="<?php echo base_url(); ?>/js/Informes/informe_municipalidad_subsidios.js"></script>