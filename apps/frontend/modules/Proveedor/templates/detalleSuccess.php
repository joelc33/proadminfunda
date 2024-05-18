<script type="text/javascript">
Ext.ns('datos');
datos.main = {
init: function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.datos = '<p class="registro_detalle"><b>Rif: </b>'+this.OBJ.tx_documento+'-'+this.OBJ.tx_rif+'</p>';
this.datos +='<p class="registro_detalle"><b>Nit: </b>'+this.OBJ.tx_nit+'</p>';
this.datos +='<p class="registro_detalle"><b>Razón Social: </b>'+this.OBJ.tx_razon_social+'</p>';
this.datos +='<p class="registro_detalle"><b>Siglas: </b>'+this.OBJ.tx_siglas+'</p>';
this.datos +='<p class="registro_detalle"><b>Clasificacion: </b>'+this.OBJ.tx_clasificacion+'</p>';
this.datos += '<p class="registro_detalle"><b>Email: </b>'+this.OBJ.tx_email+'</p>';
this.datos +='<p class="registro_detalle"><b>Web: </b>'+this.OBJ.tx_sitio_web+'</p>';
this.datos +='<p class="registro_detalle"><b>Fecha de Registro: </b>'+this.OBJ.fe_registro+'</p>';
//this.datos +='<p class="registro_detalle"><b>Fecha de Vencimiento: </b>'+this.OBJ.fe_vencimiento+'</p>';

this.fieldDatos = new Ext.form.FieldSet({
	title: 'Proveedor',
	html: this.datos
});

this.datos2 = '<p class="registro_detalle"><b>Estado: </b>'+this.OBJ.nb_estado+'</p>';
this.datos2 +='<p class="registro_detalle"><b>Municipio: </b>'+this.OBJ.nb_municipio+'</p>';
this.datos2 +='<p class="registro_detalle"><b>Dirección: </b>'+this.OBJ.tx_direccion+'</p>';

this.fieldDatos1 = new Ext.form.FieldSet({
	title: 'Direccion',
	html: this.datos2
});

this.datos3 = '<p class="registro_detalle"><b>Cédula: </b>'+this.OBJ.nb_representante_legal+'</p>';
this.datos3 +='<p class="registro_detalle"><b>Nombre y Apellido: </b>'+this.OBJ.nu_cedula_representante+'</p>';
this.datos3 +='<p class="registro_detalle"><b>Telefono Movil: </b>'+this.OBJ.tx_num_celular+'</p>';

this.fieldDatos2 = new Ext.form.FieldSet({
	title: 'Representante Legal',
	html: this.datos3
});

this.formpanel = new Ext.form.FormPanel({
	bodyStyle: 'padding:10px',
	autoWidth:true,
	autoHeight:true,
        border:false,
	items:[
		this.fieldDatos,this.fieldDatos1,this.fieldDatos2
		]
});

	this.tabuladores = new Ext.TabPanel({
		resizeTabs:true, // turn on tab resizing
		minTabWidth: 115,
		tabWidth:150,border:false,
		enableTabScroll:true,
		autoWidth:true,
		autoHeight:250,
		activeTab: 0,
		defaults: {autoScroll:true},
		items:[
			{
				title: 'Datos del Proveedor',
				items:[this.formpanel]
			},
	        <?php echo $tab; ?>
                        
                        
		]
	});

        this.tabuladores.render('detalle');

 	}
}
Ext.onReady(datos.main.init, datos.main);
</script>