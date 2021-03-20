<main>
    <div class="container-fluid">
        <h3 class="mt-4" align="center"><i class="fas fa-male"></i> Informe de Socios</h3>
        <div class="alert alerta-fijo hidden" role="alert" id="alerta"></div>
        <div class="container-fluid">
        	<br>
	        <div class="card shadow mb-12">
	            <div class="card-body">
	                <div class="container-fluid">
	                    <center>
	                        <button type="button" name="btn_excel" id="btn_excel" class="btn btn-success"><i class="fas fa-file-excel"></i> Exportar a XLSX</button>
	                        <button type="button" name="btn_pdf" id="btn_pdf" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Exportar a PDF</button>
	                        <button type="button" name="btn_imprimir" id="btn_imprimir" class="btn btn-primary"><i class="fas fa-print"></i> Imprimir</button>
	                    </center>
	                </div>
	            </div>
	        </div>
	        <br>
	        <div class="row">
	            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
	            	<div class="card mb-4">
	                	<div class="card-header" data-toggle="collapse" data-target="#datosBuscarSocios" aria-expanded="false" aria-controls="datosBuscarSocios">
	                		<i class="fas fa-male"></i> Buscar
	                	</div>
	                	<div class="card shadow mb-12 collapse" id="datosBuscarSocios">
				            <div class="card-body">
				            	<div class="container-fluid">
				            		<form id="form_informe_socios" name="form_informe_socios" encType="multipart/form-data">
				                		<div class="row">
				                			<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
					                        	<div class="form-group">
					                                <label class="small mb-1" for="txt_id_socio">Id. Socio</label>
					                                <input type='text' class="form-control" id='txt_id_socio' name="txt_id_socio" />
					                            </div>
					                        </div>
					                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
					                        	<div class="form-group">
					                                <label class="small mb-1" for="txt_rut_socio">RUT Socio</label>
					                                <input type='text' class="form-control" id='txt_rut_socio' name="txt_rut_socio" />
					                            </div>
					                        </div>
					                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
					                        	<div class="form-group">
					                                <label class="small mb-1" for="txt_rol">ROL Socio</label>
					                                <input type='text' class="form-control" id='txt_rol' name="txt_rol" />
					                            </div>
					                        </div>
					                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
					                        	<div class="form-group">
					                                <label class="small mb-1" for="btn_buscar_socio"></label>
					                                <button type="button" name="btn_buscar_socio" id="btn_buscar_socio" class="btn btn-dark form-control"><i class="fas fa-search"></i> Buscar Socio</button>
					                            </div>
					                        </div>
					                    </div>
					                    <div class="row">
					                    	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
					                        	<div class="form-group">
					                                <label class="small mb-1" for="txt_nombre_socio">Nombre Socio</label>
					                                <input type='text' class="form-control" id='txt_nombre_socio' name="txt_nombre_socio" />
					                            </div>
					                        </div>
					                    </div>
					                    <div class="row">
					                    	<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
					                    		<div class="form-group">
					                    			<label class="small mb-1" for="dt_desde_entrada">Desde (Fecha Entrada)</label>
					                                <input type='text' class="form-control" id='dt_desde_entrada' name="dt_desde_entrada" />
					                    		</div>
					                    	</div>
					                    	<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
					                    		<div class="form-group">
					                    			<label class="small mb-1" for="dt_hasta_entrada">Hasta (Fecha Entrada)</label>
					                                <input type='text' class="form-control" id='dt_hasta_entrada' name="dt_hasta_entrada" />
					                    		</div>
					                    	</div>
					                    	<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
					                    		<div class="form-group">
					                    			<label class="small mb-1" for="dt_desde_nac">Desde (Fecha Nacimiento)</label>
					                                <input type='text' class="form-control" id='dt_desde_nac' name="dt_desde_nac" />
					                    		</div>
					                    	</div>
					                    	<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
					                    		<div class="form-group">
					                    			<label class="small mb-1" for="dt_hasta_nac">Hasta (Fecha Nacimiento)</label>
					                                <input type='text' class="form-control" id='dt_hasta_nac' name="dt_hasta_nac" />
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
					                    			<label class="small mb-1" for="txt_n_casa">N° Casa</label>
					                                <input type='text' class="form-control" id='txt_n_casa' name="txt_n_casa" />
					                    		</div>
					                    	</div>
					                    	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
					                    		<div class="form-group">
					                    			<label class="small mb-1" for="txt_resto_direccion">Resto Dirección</label>
					                                <input type='text' class="form-control" id='txt_resto_direccion' name="txt_resto_direccion" />
					                    		</div>
					                    	</div>
					                    </div>
					                    <div class="row">
					                    	<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
					                    		<div class="form-group">
					                    			<label class="small mb-1" for="cmb_sexo">Sexo</label>
					                                <select id="cmb_sexo" name="cmb_sexo" class="form-control">
					                                	<option value="">Seleccionar sexo</option>
					                                	<option value="1">Masculino</option>
					                                	<option value="2">Femenino</option>
					                                </select>
					                    		</div>
					                    	</div>
				                			<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
					                            <div class="form-group">
					                                <label class="small mb-1" for="cmb_estado">Estado</label>
					                                <select id="cmb_estado" name="cmb_estado" class="form-control">
					                                	<option value="">Seleccionar estado</option>
					                                	<option value="1">Activado</option>
					                                	<option value="2">Desactivado</option>
					                                </select>
					                            </div>
				                			</div>
				                		</div>
					                    <div class="row">
					                    	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						                    	<div class="card shadow mb-12 bg-dark">
			            							<div class="card-body bg-light">
			            								<center>
					                    					<button type="button" class="btn btn-success" id="btn_buscar"><i class="fas fa-search"></i> Buscar</button>
					                    					<button type="button" class="btn btn-primary" id="btn_limpiar"><i class="fas fa-broom"></i> Limpiar Formulario</button>
					                    				</center>
					                    			</div>
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
	                	<div class="card-header" data-toggle="collapse" data-target="#datosListadoSocios" aria-expanded="false" aria-controls="datosListadoSocios">
	                		<i class="fas fa-male"></i> Listado de socios
	                	</div>
	                	<div class="card shadow mb-12" id="datosListadoSocios">
				            <div class="card-body">
				            	<div class="container-fluid">
						        	<div class="table-responsive">
					                    <table id="grid_socios" class="table table-bordered" width="100%">
					                        <thead class="thead-dark">
					                            <tr>
					                            	<th>Id.</th>
					                            	<th>RUT</th>
					                            	<th>ROL</th>
					                            	<th>Nombre</th>
					                            	<th>Fecha Entrada</th>
					                            	<th>Fecha Nacimiento</th>
					                            	<th>Sexo</th>
					                            	<th>Calle</th>
					                            	<th>N° Casa</th>
					                            	<th>Resto Dirección</th>
					                            	<th>Comuna</th>
					                            	<th>Estado</th>
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
		</div>
	</div>
    <div id="dlg_buscar_socio" class="modal fade" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Buscar Socio (Doble click, para seleccionar)</h4>
                </div>
                <div class="modal-body">
                    <div id="divContenedorBuscarSocio"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript" src="<?php echo base_url(); ?>/js/Informes/informe_socios.js"></script>