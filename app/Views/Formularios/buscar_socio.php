<main>
    <div class="container-fluid">
        <input type="hidden" name="txt_origen" id="txt_origen" value="<?php echo $origen; ?>">
		<div class="table-responsive">
            <table id="grid_buscar_socio" class="table table-bordered" width="100%">
                <thead class="thead-dark">
                    <tr>
                    	<th width="30%">Id Socio</th>
                    	<th width="30%">RUT Socio</th>
                        <th width="20%">ROL Socio</th>
                        <th width="20%">Nombre Socio</th>
                        <th width="20%">Fecha Entrada</th>
                    </tr>
                </thead>
            </table> 
        </div>
	</div>
</main>
<script type="text/javascript" src="<?php echo base_url(); ?>/js/Formularios/buscar_socio.js"></script>