<script type="text/javascript">
Ext.ns('datos');
datos.main = {
init: function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.datos = '<p class="registro_detalle"><b>Sector: </b>'+this.OBJ.id_tb080_sector+'</p>';
//this.datos +='<p class="registro_detalle"><b>Sub-Sector: </b>'+this.OBJ.id_tb081_sub_sector+'</p>';
this.datos +='<p class="registro_detalle"><b>Ejecutor: </b>'+this.OBJ.id_tb082_ejecutor+'</p>';
this.datos +='<p class="registro_detalle"><b>Codigo: </b>'+this.OBJ.nu_proyecto_ac+'</p>';
this.datos +='<p class="registro_detalle"><b>Descripcion: </b>'+this.OBJ.de_proyecto_ac+'</p>';
this.datos +='<p class="registro_detalle"><b>Ejercicio: </b>'+this.OBJ.id_tb013_anio_fiscal+'</p>';

this.ae = new Ext.Button({
	text:'Accion Especifica',
	iconCls: 'icon-reporteest',
	handler: function(boton){
		var id  = AsignacionpresupuestoLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
		AsignacionpresupuestoLista.main.mascara.show();
		this.msg = Ext.get('formularioAsignacionpresupuesto');
		this.msg.load({
			url:"<?php echo $_SERVER["SCRIPT_NAME"] ?>/Accionespecifica/lista/codigo/"+id,
			scripts: true,
			text: "Cargando.."
		});
	}
});

this.formpanel = new Ext.form.FormPanel({
	bodyStyle: 'padding:10px',
	autoWidth:true,
	autoHeight:true,
  border:false,
  html: this.datos,
	tbar:[
			this.ae,'-'
	]
});

this.tabuladores = new Ext.Panel({
		autoWidth:true,
		autoHeight:250,
		border: false,
		defaults: {autoScroll:true},
		items:[
			{
				title: this.OBJ.de_tipo_prac,
				items:[this.formpanel]
			}
		]
	});

  this.tabuladores.render('detalle');

 	}
}
Ext.onReady(datos.main.init, datos.main);
</script>
