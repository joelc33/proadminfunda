<script type="text/javascript">
Ext.ns('datos');
datos.main = {
init: function(){
	this.store_ubicacion = this.getStoreUBICACION();
this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.datos = '<p class="registro_detalle"><b>Detalle del bien: </b>'+this.OBJ.tx_detalle+'</p>';
this.datos += '<p class="registro_detalle"><b>Numero del bien: </b>'+this.OBJ.nu_bienes+'</p>';
this.datos += '<p class="registro_detalle"><b>Serial del bien: </b>'+this.OBJ.tx_serial+'</p>';
this.datos += '<p class="registro_detalle"><b>Producto: </b>'+this.OBJ.tx_producto+'</p>';
this.datos += '<p class="registro_detalle"><b>Tipo Incorporación: </b>'+this.OBJ.tx_tipo_incorporacion+'</p>';
this.datos += '<p class="registro_detalle"><b>Documento Incorporación: </b>'+this.OBJ.desc_documento+'</p>';

if(this.OBJ.tx_tipo_incorporacion=='COMPRA'){
this.datos += '<p class="registro_detalle"><b>Rif Proveedor: </b>'+this.OBJ.tx_rif+'</p>';
this.datos += '<p class="registro_detalle"><b>Proveedor: </b>'+this.OBJ.tx_razon_social+'</p>';
this.datos += '<p class="registro_detalle"><b>Precio Unitario: </b>'+this.OBJ.precio_unitario+' Bs.S</p>';

}


this.formpanel = new Ext.form.FormPanel({
	title:'Datos basicos',
	bodyStyle: 'padding:10px',
	autoWidth:true,
	autoHeight:true,
  border:false,
  html: this.datos
});

this.datos2 = '<p class="registro_detalle"></p>';

this.store_ubicacion.load({
                        params:{
                            co_bienes:this.OBJ.co_bienes
                        },
						callback:function(records,operation,success){
							var t=true;
							var d='';
							var i=records.length;
							var tx='';
							d+='<table><tr><td><b>Ubicación<b/></td><td></td><td align=center><b>Nivel</b></td><td></td><td align=center><b>Estatus</b></td></tr>';
							this.each(function(record,index){
								if(record.data.tx_organigrama){
									if(t){
										d += '<tr><td class="registro_detalle">'+record.data.tx_organigrama+'</td><td><td align=center>'+record.data.nu_nivel+'</td><td></td><td>Actual</td></tr>';
										t=false;
									}else{
										d += '<tr><td class="registro_detalle">'+record.data.tx_organigrama+'</td><td><td align=center>'+record.data.nu_nivel+'</td><td></td><td></td></tr>';
										
									}
									
								}
								
								i--;
								//console.log(record.data.tx_organigrama);
							},this);
							d += '</table>';
							Ext.getCmp('panelubi').body.update(d);
							
						}

                    });

//this.datos2 += '<p class="registro_detalle">sds</p>';
this.formpanel2 = new Ext.form.FormPanel({
	id:'panelubi',
	title:'Ubicacion completa',
	bodyStyle: 'padding:10px',
	autoWidth:true,
	autoHeight:true,
  border:false,
  html: this.datos2
});

this.tabuladores = new Ext.Panel({
		autoWidth:true,
		autoHeight:250,
		border: false,
		defaults: {autoScroll:true},
		items:[
			{
				title: this.OBJ.de_tipo_prac,
				items:[this.formpanel,this.formpanel2]
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
