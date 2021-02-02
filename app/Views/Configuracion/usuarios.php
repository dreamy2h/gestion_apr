<main>
    <div class="container-fluid">
        <h3 class="mt-4" align="center">Usuarios</h3>
        <div class="alert alerta-fijo hidden" role="alert" id="alerta"></div>

        <div class="container-fluid">
        	<br>
	        <div class="card shadow mb-12">
	            <div class="card-body">
	                <div class="container-fluid">
	                    <center>
	                        <button type="button" name="btn_nuevo" id="btn_nuevo" class="btn btn-primary"><i class="fas fa-user-plus"></i> Nuevo</button>
	                        <button type="button" name="btn_modificar" id="btn_modificar" class="btn btn-primary"><i class="fas fa-user-edit"></i> Modificar</button>
	                        <button type="button" name="btn_bloquear" id="btn_bloquear" class="btn btn-primary"><i class="fas fa-user-lock"></i> Bloquear</button>
	                        <button type="button" name="btn_permisos" id="btn_permisos" class="btn btn-warning"><i class="fas fa-id-card"></i> Permisos</button>
	                        <button type="button" name="btn_reset" id="btn_reset" class="btn btn-info"><i class="fas fa-window-restore"></i> Reset Clave</button>
	                        <button type="button" name="btn_aceptar" id="btn_aceptar" class="btn btn-success"><i class="fas fa-user-check"></i> Aceptar</button>
	                        <button type="button" name="btn_cancelar" id="btn_cancelar" class="btn btn-danger"><i class="fas fa-ban"></i> Cancelar</button>
	                    </center>
	                </div>
	            </div>
	        </div>
	        <br>
	        <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                	<div class="card mb-4">
	                	<div class="card-header" data-toggle="collapse" data-target="#datosUsuario" aria-expanded="false" aria-controls="datosUsuario">
	                		<i class="fas fa-user mr-1"></i> Datos Usuarios
	                	</div>
	                	<div class="card shadow mb-12 collapse" id="datosUsuario">
				            <div class="card-body">
				            	<div class="container-fluid">
				                	<form id="form_usuarios" name="form_usuarios" encType="multipart/form-data">
										
				                		<div class="row">
				                			<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
				                				<div class="form-group">
					                                <label class="small mb-1" for="txt_id_usuario">Identificador</label>
					                                <input type="text" class="form-control" name="txt_id_usuario" id="txt_id_usuario" />
					                            </div>
					                        </div>
				                			<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
				                				<div class="form-group">
					                                <label class="small mb-1" for="txt_usuario">Usuario</label>
					                                <input type='text' class="form-control" id='txt_usuario' name="txt_usuario" />
					                            </div>
					                        </div>
					                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
					                        	<div class="form-group">
					                                <label class="small mb-1" for="cmb_apr">APR</label>
					                                <select id="cmb_apr" name="cmb_apr" class="form-control"></select>
					                            </div>
					                        </div>
				                		</div>
				                		<div class="row">
				                			<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
				                				<div class="form-group">
					                                <label class="small mb-1" for="txt_nombres">Nombres</label>
					                                <input type='text' class="form-control" id='txt_nombres' name="txt_nombres" />
					                            </div>
					                        </div>
					                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
					                            <div class="form-group">
					                                <label class="small mb-1" for="txt_apepat">Apellido Paterno</label>
					                                <input type='text' class="form-control" id='txt_apepat' name="txt_apepat" />
					                            </div>
				                			</div>
				                			<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
					                            <div class="form-group">
					                                <label class="small mb-1" for="txt_apemat">Apellido Materno</label>
					                                <input type='text' class="form-control" id='txt_apemat' name="txt_apemat" />
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
	                	<div class="card-header"><i class="fas fa-user mr-1"></i> Listado de Usuarios</div>
	                	<div class="card shadow mb-12">
				            <div class="card-body">
				            	<div class="container-fluid">
				            		<div class="table-responsive">
					                    <table id="grid_usuarios" class="table table-bordered" width="100%">
					                        <thead class="thead-dark">
					                            <tr>
					                            	<th width="0%">id_usuario</th>
					                                <th width="10%">Usuario</th>
					                                <th width="0%">id_apr</th>
					                                <th width="20%">APR</th>
					                                <th width="0%">Nombres</th>
					                                <th width="0%">Ap. Paterno</th>
					                                <th width="0%">Ap. Materno</th>
					                                <th width="20%">Nombre Usuario</th>
					                                <th width="0%">id_region</th>
					                                <th width="0%">id_provincia</th>
					                                <th width="0%">id_comuna</th>
					                                <th width="15%">Comuna</th>
					                                <th width="0%">Calle</th>
					                                <th width="0%">Número</th>
					                                <th width="0%">resto_direccion</th>
					                                <th width="0%">id_estado</th>
					                                <th width="10%">Estado</th>
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

			<div id="dlg_permisos" class="modal fade" role="dialog">
	            <div class="modal-dialog modal-xl">
	                <div class="modal-content">
	                    <div class="modal-header">
	                        <h4 class="modal-title">Permisos del Usuario</h4>
	                    </div>
	                    <div class="modal-body">
	                        <div id="divContenedorPermisos"></div>
	                    </div>
	                    <div class="modal-footer">
	                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
	                    </div>
	                </div>
	            </div>
	        </div>

	        <div id="dlg_traza_usuario" class="modal fade" role="dialog">
	            <div class="modal-dialog modal-xl">
	                <div class="modal-content">
	                    <div class="modal-header">
	                        <h4 class="modal-title">Trazabilidad del Usuario</h4>
	                    </div>
	                    <div class="modal-body">
	                        <div id="divContenedorTrazaUsuario"></div>
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
<script type="text/javascript" src="<?php echo base_url(); ?>/js/Configuracion/usuarios.js"></script>