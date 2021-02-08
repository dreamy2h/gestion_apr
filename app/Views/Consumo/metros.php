<main>
    <div class="container-fluid">
        <h3 class="mt-4" align="center"><i class="fas fa-tint mr-1"></i> Metros</h3>
        <div class="alert alerta-fijo hidden" role="alert" id="alerta"></div>

        <div class="container-fluid">
        	<br>
	        <div class="card shadow mb-12">
	            <div class="card-body">
	                <div class="container-fluid">
	                    <center>
	                        <button type="button" name="btn_nuevo" id="btn_nuevo" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo</button>
	                        <button type="button" name="btn_modificar" id="btn_modificar" class="btn btn-primary"><i class="fas fa-edit"></i> Modificar</button>
	                        <button type="button" name="btn_eliminar" id="btn_eliminar" class="btn btn-primary"><i class="fas fa-trash"></i> Eliminar</button>
	                        <button type="button" name="btn_aceptar" id="btn_aceptar" class="btn btn-success"><i class="fas fa-check"></i> Aceptar</button>
	                        <button type="button" name="btn_cancelar" id="btn_cancelar" class="btn btn-danger"><i class="fas fa-ban"></i> Cancelar</button>
	                        <button type="button" name="btn_importar" id="btn_importar" class="btn btn-info"><i class="fas fa-upload"></i> Importar Planilla</button>
	                    </center>
	                </div>
	            </div>
	        </div>
	        <br>
	        <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                	<div class="card mb-4">
	                	<div class="card-header" data-toggle="collapse" data-target="#datosMetros" aria-expanded="false" aria-controls="datosMetros">
	                		<i class="fas fa-tint mr-1"></i> Ingreso de Metros
	                	</div>
	                	<div class="card shadow mb-12 collapse" id="datosMetros">
				            <div class="card-body">
				            	<div class="container-fluid">
				            		<form id="form_metros" name="form_metros" encType="multipart/form-data">
				                		<div class="row">
				                			<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">
				                				<div class="row">
						                			<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
						                				<div class="form-group">
							                                <label class="small mb-1" for="txt_id_metros">Identificador</label>
							                                <input type="text" class="form-control" name="txt_id_metros" id="txt_id_metros" />
							                            </div>
							                        </div>
							                    </div>
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
							                    	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
							                        	<div class="form-group">
							                                <label class="small mb-1" for="txt_id_arranque">Id. Arranque</label>
							                                <input type='text' class="form-control" id='txt_id_arranque' name="txt_id_arranque" />
							                            </div>
							                        </div>
							                    
							                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
							                        	<div class="form-group">
							                                <label class="small mb-1" for="txt_subsidio">Subsidio %</label>
							                                <input type='text' class="form-control" id='txt_subsidio' name="txt_subsidio" />
							                            </div>
							                        </div>
							                    </div>
							                    <div class="row">
							                    	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
							                        	<div class="form-group">
							                                <label class="small mb-1" for="txt_sector">Sector</label>
							                                <input type='text' class="form-control" id='txt_sector' name="txt_sector" />
							                            </div>
							                        </div>
							                    </div>
						                        <div class="row">
						                        	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
							                         	<div class="form-group">
							                                <label class="small mb-1" for="dt_fecha_ingreso">Fecha Ingreso</label>
							                                <input type='text' class="form-control" id='dt_fecha_ingreso' name="dt_fecha_ingreso" />
							                            </div>
							                        </div>
							                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
							                         	<div class="form-group">
							                                <label class="small mb-1" for="dt_fecha_vencimiento">Fecha Vencimiento</label>
							                                <input type='text' class="form-control" id='dt_fecha_vencimiento' name="dt_fecha_vencimiento" />
							                            </div>
							                        </div>
							                    </div>
							                    <div class="row">
							                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
							                         	<div class="form-group">
							                                <label class="small mb-1" for="txt_c_anterior">Consumo Anterior</label>
							                                <input type='text' class="form-control" id='txt_c_anterior' name="txt_c_anterior" />
							                            </div>
							                        </div>
							                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
							                         	<div class="form-group">
							                                <label class="small mb-1" for="txt_c_actual">Consumo Actual</label>
							                                <input type='text' class="form-control" id='txt_c_actual' name="txt_c_actual" />
							                            </div>
							                        </div>
						                        </div>
						                        <div class="row">
						                        	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
							                         	<div class="form-group">
							                                <label class="small mb-1" for="txt_metros">Metros Consumidos</label>
							                                <input type='text' class="form-control" id='txt_metros' name="txt_metros" />
							                            </div>
							                        </div>
							                 
							                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
							                         	<div class="form-group">
							                                <label class="small mb-1" for="txt_subtotal">Subtotal</label>
							                                <input type='text' class="form-control" id='txt_subtotal' name="txt_subtotal" />
							                            </div>
							                        </div>
						                        </div>
						                        <div class="row">
						                        	<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
							                         	<div class="form-group">
							                                <label class="small mb-1" for="txt_multa">Multa</label>
							                                <input type='text' class="form-control" id='txt_multa' name="txt_multa" />
							                            </div>
							                        </div>
							                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
							                         	<div class="form-group">
							                                <label class="small mb-1" for="txt_total_servicios">Total Servicios</label>
							                                <input type='text' class="form-control" id='txt_total_servicios' name="txt_total_servicios" />
							                            </div>
							                        </div>
							                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
							                         	<div class="form-group">
							                                <label class="small mb-1" for="txt_saldo_aterior">Saldo Anterior</label>
							                                <input type='text' class="form-control" id='txt_saldo_aterior' name="txt_saldo_aterior" />
							                            </div>
							                        </div>
						                        </div>
				                			</div>
				                			<div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
				                				<div class="row align-items-end">
					                				<div class="container-fluid">
									            		<div class="table-responsive">
										                    <table id="grid_costo_metros" class="table table-bordered" width="100%">
										                        <thead class="thead-dark">
										                            <tr>
										                            	<th width="0%">id_costo_metros</th>
										                            	<th width="25%">Metros</th>
										                            	<th width="25%">Desde</th>
										                            	<th width="25%">Hasta</th>
										                                <th width="25%">Costo</th>
										                            </tr>
										                        </thead>
										                    </table> 
										                </div>
										            </div>
										        </div>
									            <div class="row bg-primary">
									            	<div class="container-fluid">
							                        	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
								                         	<div class="form-group">
								                                <label class="small mb-1" for="txt_total_mes" style="font-size: 200%;">Total del Mes</label>
								                                <input type='text' class="form-control bg-success" id='txt_total_mes' name="txt_total_mes" style="font-size: 200%;" />
								                            </div>
								                        </div>
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
	                	<div class="card-header"><i class="fas fa-tint mr-1"></i> Historial Metros</div>
	                	<div class="card shadow mb-12">
				            <div class="card-body">
				            	<div class="container-fluid">
				            		<div class="table-responsive">
					                    <table id="grid_metros" class="table table-bordered" width="100%">
					                        <thead class="thead-dark">
					                            <tr>
					                            	<th width="10%">Identificador</th>
					                            	<th width="0%">id_socio</th>
					                            	<th width="0%">rut_socio</th>
					                                <th width="0%">rol_socio</th>
					                                <th width="15%">Nombre Socio</th>
					                               	<th width="0%">id_Arranque</th>
					                                <th width="0%">Sector</th>
					                                <th width="0%">Subsidio</th>
					                                <th width="0%">Fecha Ingreso</th> 
					                                <th width="0%">Fecha Vencimiento</th>
					                                <th width="0%">Consumo Antetior</th>
					                                <th width="0%">Consumo Actual</th>
					                                <th width="10%">Metros</th>
					                                <th width="0%">Total Metros</th>
					                                <th width="10%">Subtotal</th>
					                                <th width="10%">Multa</th>
					                                <th width="10%">Total Servicios</th>
					                                <th width="0%">Saldo Anterior</th>
					                                <th width="10%">Total del Mes</th>
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
			<div id="dlg_traza_metros" class="modal fade" role="dialog">
	            <div class="modal-dialog modal-xl">
	                <div class="modal-content">
	                    <div class="modal-header">
	                        <h4 class="modal-title">Trazabilidad de los metros ingresados</h4>
	                    </div>
	                    <div class="modal-body">
	                        <div id="divContenedorTrazaMetros"></div>
	                    </div>
	                    <div class="modal-footer">
	                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
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
        </div>
    </div>
</main>
<script type="text/javascript" src="<?php echo base_url(); ?>/js/Consumo/metros.js"></script>