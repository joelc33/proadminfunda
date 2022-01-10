<script type="text/javascript">
Ext.ns('datos');
datos.main = {
init: function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.datos = '<p class="registro_detalle"><b>Codigo Solicitud: </b>'+this.OBJ.co_solicitud+'</p>';
this.datos +='<p class="registro_detalle"><b>Tramite Solicitado: </b>'+this.OBJ.tx_tipo_solicitud+'</p>';
//this.datos +='<p class="registro_detalle"><b>Instituto: </b>'+this.OBJ.co_instituto+'</p>';
this.datos +='<p class="registro_detalle"><b>Estatus: </b>'+this.OBJ.tx_estatus+'</p>';
this.datos +='<p class="registro_detalle"><b>Fecha de Recepción: </b>'+this.OBJ.fe_creacion+'</p>';
this.datos +='<p class="registro_detalle"><b>Observacion: </b>'+this.OBJ.tx_observacion+'</p>';

this.fieldDatos = new Ext.form.FieldSet({
	title: 'Datos de la Solicitud',
	html: this.datos
});

this.datos2 = '<p class="registro_detalle"><b>Login: </b>'+this.OBJ.tx_login+'</p>';
this.datos2 +='<p class="registro_detalle"><b>Nombre y Apellido: </b>'+this.OBJ.nb_usuario+'</p>';

this.fieldDatos1 = new Ext.form.FieldSet({
	title: 'Datos del Usuario',
	html: this.datos2
});




this.formpanel = new Ext.form.FormPanel({
	bodyStyle: 'padding:10px',
	autoWidth:true,
	autoHeight:true,
        border:false,
	items:[
		this.fieldDatos,this.fieldDatos1
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
				title: 'Datos de la Solicitud',
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