<main>
    <div class="container-fluid">
        <h3 class="mt-4" align="center"><i class="fas fa-cash-register mr-1"></i> Caja</h3>
        <div class="alert alerta-fijo hidden" role="alert" id="alerta"></div>

        <div class="container-fluid">
        	<br>
	        <div class="card shadow mb-12">
	            <div class="card-body">
	                <div class="container-fluid">
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
	                </div>
	            </div>
	        </div>
	        <br>
	        <div class="card shadow mb-12">
	            <div class="card-body">
	                <div class="container-fluid">
	                	<div class="row">
	                		<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
	                			<div class="container-fluid">
				            		<div class="table-responsive">
					                    <table id="grid_deuda" class="table table-bordered" width="100%">
					                        <thead class="thead-dark">
					                            <tr>
					                            	<th>id_metros</th>
					                            	<th>Deuda $</th>
					                            	<th>Fecha Vencimiento</th>
					                            </tr>
					                        </thead>
					                    </table> 
					                </div>
					                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
			                        	<div class="form-group">
			                                <label class="small mb-1" for="txt_total_pagar" style="font-size: 150%;">Total a Pagar $</label>
			                                <input type='text' class="form-control bg-warning text-dark" id='txt_total_pagar' name="txt_total_pagar" style="font-size: 150%;" />
			                            </div>
			                        </div>
					            </div>
	                		</div>
	                		<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
	                			<div class="row">
	                				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
			                        	<div class="form-group">
			                        		<label class="small mb-1" for="cmb_forma_pago" style="font-size: 150%;">Forma de Pago</label>
			                        		<select id="cmb_forma_pago" name="cmb_forma_pago" class="form-control" style="font-size: 150%;">
			                        			<option value="1">Efectivo</option>
			                        		</select>
			                        	</div>
			                        </div>
	                				
			                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
			                        	<div class="form-group">
			                                <label class="small mb-1" for="txt_entregado" style="font-size: 150%;">Entregado $</label>
			                                <input type='text' class="form-control bg-secondary text-white" id='txt_entregado' name="txt_entregado" style="font-size: 150%;" />
			                            </div>
			                        </div>
			                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
			                        	<div class="form-group">
			                                <label class="small mb-1" for="txt_vuelto" style="font-size: 150%;">Vuelto $</label>
			                                <input type='text' class="form-control bg-info text-white" id='txt_vuelto' name="txt_vuelto" style="font-size: 150%;" />
			                            </div>
			                        </div>
			                    </div>
			                    <br><br>
			                    <div class="row">
			                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
			                        	<div class="form-group">
			                        		<button type="button" name="btn_pagar" id="btn_pagar" class="btn btn-dark form-control" style="font-size: 150%;"><i class="fas fa-money-bill-wave"></i> Pagar</button>
			                            </div>
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
<script type="text/javascript" src="<?php echo base_url(); ?>/js/Pagos/caja.js"></script>