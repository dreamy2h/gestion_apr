<main>
    <div class="container-fluid">
        <h3 class="mt-4" align="center">APR</h3>
        <div class="alert alerta-fijo hidden" role="alert" id="alerta"></div>

        <div class="container-fluid">
        	<br>
	        <div class="card shadow mb-12">
	            <div class="card-body">
	                <div class="container-fluid">
	                    <center>
	                        <button type="button" name="btn_nuevo" id="btn_nuevo" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo</button>
	                        <button type="button" name="btn_modificar" id="btn_modificar" class="btn btn-primary"><i class="fas fa-edit"></i> Modificar</button>
	                        <button type="button" name="btn_aceptar" id="btn_aceptar" class="btn btn-success"><i class="fas fa-check"></i> Aceptar</button>
	                        <button type="button" name="btn_cancelar" id="btn_cancelar" class="btn btn-danger"><i class="fas fa-ban"></i> Cancelar</button>
	                    </center>
	                </div>
	            </div>
	        </div>
	        <br>
	        <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                	<div class="card mb-4">
	                	<div class="card-header" data-toggle="collapse" data-target="#datosAPR" aria-expanded="false" aria-controls="datosAPR">
	                		<i class="fas fa-house-user mr-1"></i> Datos APR
	                	</div>
	                	<div class="card shadow mb-12 collapse" id="datosAPR">
				            <div class="card-body">
				            	<div class="container-fluid">
				                	<form id="form_APR" name="form_APR" encType="multipart/form-data">
										
				                		<div class="row">
				                			<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
				                				<div class="form-group">
					                                <label class="small mb-1" for="txt_id_apr">Identificador</label>
					                                <input type="text" class="form-control" name="txt_id_apr" id="txt_id_apr" />
					                            </div>
					                        </div>
				                			<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
					                        	<div class="form-group">
					                                <label class="small mb-1" for="txt_rut_apr">RUT APR</label>
					                                <input type='text' class="form-control" id='txt_rut_apr' name="txt_rut_apr" />
					                            </div>
					                        </div>
				                			<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
				                				<div class="form-group">
					                                <label class="small mb-1" for="txt_nombre_apr">Nombre APR</label>
					                                <input type='text' class="form-control" id='txt_nombre_apr' name="txt_nombre_apr" />
					                            </div>
					                        </div>
					                    </div>
					                    <div class="row">
					                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
					                        	<div class="form-group">
					                                <label class="small mb-1" for="txt_hash_sii">Hash SII</label>
					                                <input type='text' class="form-control" id='txt_hash_sii' name="txt_hash_sii" />
					                            </div>
					                        </div>
					                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
					                        	<div class="form-group">
					                                <label class="small mb-1" for="txt_codigo_comercio">Código Comercio</label>
					                                <input type='text' class="form-control" id='txt_codigo_comercio' name="txt_codigo_comercio" />
					                            </div>
					                        </div>
				                		</div>
				                		<div class="row">
				                			<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
				                				<div class="form-group">
					                                <label class="small mb-1" for="cmb_region">Región</label>
					                                <select id="cmb_region" name="cmb_region" class="form-control"></select>
					                            </div>
					                        </div>
					                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
					                            <div class="form-group">
					                                <label class="small mb-1" for="cmb_provincia">Provincia</label>
					                                <select id="cmb_provincia" name="cmb_provincia" class="form-control"></select>
					                            </div>
				                			</div>
				                			<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
					                            <div class="form-group">
					                                <label class="small mb-1" for="cmb_comuna">Comuna</label>
					                                <select id="cmb_comuna" name="cmb_comuna" class="form-control"></select>
					                            </div>
				                			</div>
				                		</div>
				                		<div class="row">
				                			<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
				                				<div class="form-group">
					                                <label class="small mb-1" for="txt_calle">Calle</label>
					                                <input type='text' class="form-control" id='txt_calle' name="txt_calle" />
					                            </div>
					                        </div>
					                        <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12">
					                            <div class="form-group">
					                                <label class="small mb-1" for="txt_numero">Número</label>
					                                <input type='text' class="form-control" id='txt_numero' name="txt_numero" />
					                            </div>
				                			</div>
				                			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
					                            <div class="form-group">
					                                <label class="small mb-1" for="txt_resto_direccion">Resto Dirección</label>
					                                <textarea class="form-control" id="txt_resto_direccion" name="txt_resto_direccion"></textarea>
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
			<br>
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                	<div class="card mb-4">
	                	<div class="card-header"><i class="fas fa-house-user mr-1"></i> Listado de APRs</div>
	                	<div class="card shadow mb-12">
				            <div class="card-body">
				            	<div class="container-fluid">
				            		<div class="table-responsive">
					                    <table id="grid_apr" class="table table-bordered" width="100%">
					                        <thead class="thead-dark">
					                            <tr>
					                            	<th width="0%">id_apr</th>
					                                <th width="10%">RUT APR</th>
					                                <th width="20%">Nombre APR</th>
					                                <th width="0%">hash_sii</th>
					                                <th width="0%">codigo_comercio</th>
					                                <th width="0%">id_region</th>
					                                <th width="0%">id_provincia</th>
					                                <th width="0%">id_comuna</th>
					                                <th width="20%">Comuna</th>
					                                <th width="20%">Calle</th>
					                                <th width="5%">Número</th>
					                                <th width="0%">resto_direccion</th>
					                                <th width="10%">Usuarios Reg</th>
					                                <th width="10%">Fecha</th>
					                                <th width="5%">Traza</th>
					                            </tr>
					                        </thead>
					                    </table> 
					                </div>
				            	</div>
				            </div>
				        </div>
				    </div>
				</div>
			</div>
	        <div id="dlg_traza_apr" class="modal fade" role="dialog">
	            <div class="modal-dialog modal-xl">
	                <div class="modal-content">
	                    <div class="modal-header">
	                        <h4 class="modal-title">Trazabilidad de la APR</h4>
	                    </div>
	                    <div class="modal-body">
	                        <div id="divContenedorTrazaAPR"></div>
	                    </div>
	                    <div class="modal-footer">
	                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</main>
<script type="text/javascript" src="<?php echo base_url(); ?>/js/Configuracion/apr.js"></script>