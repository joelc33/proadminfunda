<script type="text/javascript">
Ext.ns('datos');
datos.main = {
init: function(){
	this.store_ubicacion = this.getStoreUBICACION();
this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.datos ='<table class="registro_detalle" align="left">';
this.datos += '<tr><td align="left"><b>Denominación: </b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>'+this.OBJ.tx_detalle+'</td></tr>';
this.datos += '<tr><td align="left"><b>Detalle: </b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>'+this.OBJ.desc_inm+'</td></tr>';
this.datos += '<tr><td align="left"><b>Numero del bien:: </b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>'+this.OBJ.nu_bienes+'</td></tr>';
this.datos += '<tr><td align="left"><b>Documento Incorporación: </b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>'+this.OBJ.desc_documento+'</td></tr>';
this.datos += '<tr><td align="left"><b>Fecha registro:</b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>'+this.OBJ.fecha+'</td></tr>';
this.datos += '<tr><td align="left"><b>Dirección:  </b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>'+this.OBJ.tx_direccion+'</td></tr>';
this.datos += '<tr><td align="left"><b>Estado legal:  </b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>'+this.OBJ.tx_estado_legal+'</td></tr>';

//this.datos += '<p class="registro_detalle"><b>Numero del bien: </b>'+this.OBJ.nu_bienes+'</p>';
//this.datos += '<p class="registro_detalle"><b>Documento Incorporación: </b>'+this.OBJ.desc_documento+'</p>';
//this.datos += '<p class="registro_detalle"><b>Fecha registro: </b>'+this.OBJ.fecha+'</p>';
//this.datos += '<p class="registro_detalle"><b>Dirección: </b>'+this.OBJ.tx_direccion+'</p>';
this.datos +='</table>';

this.formpanel = new Ext.form.FormPanel({
	title:'Datos basicos',
	bodyStyle: 'padding:10px',
	autoWidth:true,
	autoHeight:true,
  border:false,
  html: this.datos
});

this.datos2 = '<table class="registro_detalle" align="left">';
this.datos2 += '<tr><td align="left"><b>Clasificación: </b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>'+this.OBJ.tx_clasificacion+'</td></tr>';
this.datos2 += '<tr><td align="left"><b>Tipo: </b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>'+this.OBJ.tx_tipo+'</td></tr>';
this.datos2 +='</table>';



this.datos3 = '<table class="registro_detalle" align="left">';
if(this.OBJ.norte){
this.datos3 += '<tr><td align="left"><b>Norte: </b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>'+this.OBJ.norte+'</td></tr>';
this.datos3 += '<tr><td align="left"><b>Sur: </b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>'+this.OBJ.sur+'</td></tr>';
this.datos3 += '<tr><td align="left"><b>Este: </b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>'+this.OBJ.este+'</td></tr>';
this.datos3 += '<tr><td align="left"><b>Oeste: </b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>'+this.OBJ.oeste+'</td></tr>';
}else{
	this.datos3 += '<tr><td align="left"><b>Linderos: </b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>'+this.OBJ.lindero+'</td></tr>';
}
this.datos3 +='</table>';

this.datos4 = '<table class="registro_detalle" align="left">';
this.datos4 += '<tr><td align="left"><b>Medida: </b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>'+this.OBJ.medida+'</td></tr>';
this.datos4 += '<tr><td align="left"><b>Area Construcción: </b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>'+this.OBJ.construccion+'</td></tr>';
this.datos4 += '<tr><td align="left"><b>Area Cubierta: </b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>'+this.OBJ.cubierta+'</td></tr>';
this.datos4 += '<tr><td align="left"><b>Area Otras Instituciones: </b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>'+this.OBJ.oi+'</td></tr>';
this.datos4 += '<tr><td align="left"><b>Area Terreno: </b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>'+this.OBJ.terreno+'</td></tr>';
this.datos4 +='</table>';

this.datos5 = '<table class="registro_detalle" align="left">';
this.datos5 += '<tr><td align="left"><b>Precio: </b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>'+this.OBJ.precio+'</td></tr>';
this.datos5 += '<tr><td align="left"><b>Avaluo: </b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>'+this.OBJ.avaluo+'</td></tr>';
this.datos5 += '<tr><td align="left"><b>Avaluo Compra: </b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>'+this.OBJ.compra+'</td></tr>';
this.datos5 +='</table>';
//this.datos2 += '<p class="registro_detalle">sds</p>';
this.formpanel2 = new Ext.form.FormPanel({
	id:'panelubi',
	title:'Clasificación',
	bodyStyle: 'padding:10px',
	autoWidth:true,
	autoHeight:true,
  border:false,
  html: this.datos2
});

this.formpanel3 = new Ext.form.FormPanel({
	id:'panellinde',
	title:'Linderos',
	bodyStyle: 'padding:10px',
	autoWidth:true,
	autoHeight:true,
  border:false,
  html: this.datos3
});

this.formpanel4 = new Ext.form.FormPanel({
	id:'panelarea',
	title:'Areas',
	bodyStyle: 'padding:10px',
	autoWidth:true,
	autoHeight:true,
  border:false,
  html: this.datos4
});

this.formpanel5 = new Ext.form.FormPanel({
	id:'panelprecio',
	title:'Valor',
	bodyStyle: 'padding:10px',
	autoWidth:true,
	autoHeight:true,
  border:false,
  html: this.datos5
});

this.tabuladores = new Ext.Panel({
		autoWidth:true,
		autoHeight:250,
		border: false,
		defaults: {autoScroll:true},
		items:[
			{
				title: this.OBJ.de_tipo_prac,
				items:[this.formpanel,this.formpanel2,this.formpanel3,this.formpanel4,this.formpanel5]
			}
		]
	});

  this.tabuladores.render('detalle');

 	},getStoreUBICACION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefkubicacion',
        root:'data',
        fields:[
            {name: 'co_organigrama'},
            {name: 'tx_organigrama'},
            {name: 'co_padre'},
            {name: 'nu_nivel'}
            ]
    });
    return this.store;
}
}
Ext.onReady(datos.main.init, datos.main);
</script>
