<main>
    <div class="container-fluid">
        <h3 class="mt-4" align="center"><i class="fas fa-shopping-cart"></i> Compras</h3>
        <div class="alert alerta-fijo hidden" role="alert" id="alerta"></div>

        <div class="container-fluid">
	        <br>
	        <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                	<div class="card mb-4">
	                	<div class="card-header">
	                		<i class="fas fa-shopping-cart"></i> Datos de la Compra
	                	</div>
	                	<div class="card shadow mb-12">
				            <div class="card-body">
				            	<div class="container-fluid">
				                	<form id="form_cuenta" name="form_cuenta" encType="multipart/form-data">
					                    <div class="row">
					                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
				                				<div class="form-group">
					                                <label class="small mb-1" for="cmb_tipo_documento">Tipo de Documento</label>
					                                <select id="cmb_tipo_documento" name="cmb_tipo_documento" class="form-control"></select>
					                            </div>
					                        </div>
					                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
				                				<div class="form-group">
					                                <label class="small mb-1" for="txt_n_documento">N° de Documento</label>
					                                <input type="text" class="form-control" name="txt_n_documento" id="txt_n_documento" placeholder="Ingrese el N° de Documento" />
					                            </div>
					                        </div>
					                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
				                				<div class="form-group">
					                                <label class="small mb-1" for="dt_fecha_documento">Fecha de Documento</label>
					                                <input type="text" class="form-control" name="dt_fecha_documento" id="dt_fecha_documento" placeholder="Ingrese la Fecha del Documento" />
					                            </div>
					                        </div>
					                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
				                				<div class="form-group">
					                                <label class="small mb-1" for="txt_neto">NETO</label>
					                                <div class="input-group">
					                                	<div class="input-group-prepend">
														    <span class="input-group-text" id="basic-addon1">$</span>
														</div>
					                                	<input type="text" class="form-control" name="txt_neto" id="txt_neto" placeholder="Cálculo automático" />
					                                </div>
					                            </div>
					                        </div>
					                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
				                				<div class="form-group">
					                                <label class="small mb-1" for="txt_iva">IVA</label>
					                                <div class="input-group">
					                                	<div class="input-group-prepend">
														    <span class="input-group-text" id="basic-addon1">$</span>
														</div>
					                                	<input type="text" class="form-control" name="txt_iva" id="txt_iva" placeholder="Cálculo automático" />
					                                </div>
					                            </div>
					                        </div>
					                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
				                				<div class="form-group">
					                                <label class="small mb-1" for="txt_total">Total</label>
					                                <div class="input-group">
					                                	<div class="input-group-prepend">
														    <span class="input-group-text" id="basic-addon1">$</span>
														</div>
					                                	<input type="text" class="form-control" name="txt_total" id="txt_total" placeholder="Cálculo automático" />
					                                </div>
					                            </div>
					                        </div>
					                    </div>
					                    <div class="card shadow mb-12">
								            <div class="card-body bg-light">
								                <div class="container-fluid">
								                	<h5 class="card-title"><i class="fas fa-industry"></i> Buscar Proveedor</h5>
								                	<div class="row">
								                        <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12">
								                        	<div class="form-group">
								                                <label class="small mb-1" for="txt_id_proveedor">Id. Proveedor</label>
								                                <input type="text" class="form-control" name="txt_id_proveedor" id="txt_id_proveedor" />
								                            </div>
								                        </div>
								                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
								                        	<div class="form-group">
								                                <label class="small mb-1" for="txt_rut_proveedor">RUT Proveedor</label>
								                                <input type="text" class="form-control" name="txt_rut_proveedor" id="txt_rut_proveedor" />
								                            </div>
								                        </div>
								                        <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">
								                        	<div class="form-group">
								                                <label class="small mb-1" for="txt_razon_social">Razón Social</label>
																<div class="input-group">	
																	<input type="text" class="form-control" name="txt_razon_social" id="txt_razon_social" />
								                                	<div class="input-group-append">
																    	<button class="btn btn-outline-dark" type="button" id="btn_buscar_proveedor" name="btn_buscar_proveedor"><i class="fas fa-search"></i> Buscar Proveedor</button>
																  	</div>
								                                </div>
								                            </div>
								                        </div>
								                    </div>
								                </div>
								            </div>
				                		</div><br>	
				                		<div class="card shadow mb-12">
								            <div class="card-body bg-light">
								                <div class="container-fluid">
								                	<h5 class="card-title"><i class="fas fa-box-open"></i> Ingresar Productos</h5>
								                	<div class="row">
								                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
								                        	<div class="form-group">
									                            <label class="small mb-1" for="cmb_producto">Producto</label>
									                        	<div class="input-group">
									                                <select id="cmb_producto" name="cmb_producto" class="custom-select"></select>
						  											<div class="input-group-append">
																    	<button class="btn btn-outline-success" type="button" id="btn_agregar_producto" name="btn_agregar_producto" title="Agregar Producto"><i class="fas fa-plus"></i></button>
																  	</div>
									                            </div>
									                        </div>
								                        </div>
								                        <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12">
								                        	<div class="form-group">
								                                <label class="small mb-1" for="txt_rut_proveedor">Cantidad</label>
								                                <input type="text" class="form-control" name="txt_rut_proveedor" id="txt_rut_proveedor" placeholder="Ingrese la Cantidad" />
								                            </div>
								                        </div>
								                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
								                        	<div class="form-group">
								                                <label class="small mb-1" for="txt_razon_social">Precio</label>
								                                <input type="text" class="form-control" name="txt_razon_social" id="txt_razon_social" placeholder="Ingrese el Precio" />
								                            </div>
								                        </div>
								                    </div>
								                    <div class="table-responsive">
									                    <table id="grid_productos_fac" class="table table-bordered" width="100%">
									                        <thead class="thead-dark">
									                            <tr>
									                            	<th>Id. Producto</th>
									                            	<th>Producto</th>
									                                <th>Cantidad</th>
									                                <th>Precio</th>
									                                <th><i class="fas fa-trash"></i></th>
									                            </tr>
									                        </thead>
									                    </table> 
									                </div>
								                </div>
								            </div>
				                		</div><br>
				                		<div align="right">
								        	<button id="btn_guardar" name="btn_guardar" class="btn btn-success" style="font-size: 120%;"><i class="fas fa-save"></i> Guardar</button>
								        </div>
				                	</form>
				                </div>
				            </div>
				        </div>
				    </div>
			    </div>
			</div>
	    </div>
	</div>
</main>
<script type="text/javascript" src="<?php echo base_url(); ?>/js/Finanzas/compras.js"></script>