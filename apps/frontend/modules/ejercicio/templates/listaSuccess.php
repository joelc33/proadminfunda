<style type="text/css">
body {
background-color:white;
}
</style>

<script type="text/javascript">
Ext.BLANK_IMAGE_URL = "<?php echo image_path('default/s.gif'); ?>";
Ext.QuickTips.init();
Ext.form.Field.prototype.msgTarget = 'side';

Ext.ns("seleccionEjercicio");
seleccionEjercicio.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.storeCO_EJERCICIO = this.getStoreCO_EJERCICIO();

this.id_tab_ejercicio = new Ext.form.ComboBox({
	fieldLabel:'Periodo',
	store: this.storeCO_EJERCICIO,
	typeAhead: true,
	valueField: 'co_anio_fiscal',
	displayField:'co_anio_fiscal',
	hiddenName:'ejercicio',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Ejercicio Fiscal...',
  itemSelector: 'div.search-item',
	tpl: new Ext.XTemplate('<tpl for=".">'+
    '<div class="search-item">'+
      '<div style="margin: 4px;" class="x-boundlist-item">'+
      '<div><b>EJERCICIO FISCAL: {tx_anio_fiscal}</b></div>'+
      '<div style="font-size: xx-small; color: grey;">({fe_apertura}) hasta ({fe_cierre})</div>'+
      '</div>'+
    '</div>'+
  '</tpl>'),
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});

this.storeCO_EJERCICIO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tab_ejercicio,
	value:  this.OBJ.id_tab_ejercicio,
	objStore: this.storeCO_EJERCICIO
});

this.fielset1 = new Ext.form.FieldSet({
              title:'Año en Ejercicio',
              autoWidth:true,
		          labelWidth: 70,
              items:[
		              this.id_tab_ejercicio,
              ]
});

this.formPanel_ = new Ext.form.FormPanel({
	width:381,
	labelWidth: 70,
	border:false,
	autoHeight:true,
	autoScroll:true,
	bodyStyle:'padding:10px;',
	items:[
    this.fielset1,
    {html : "<p><br><b>Seleccione el ejercicio Fiscal a utilizar y presione Aceptar:</b></p>",border : false}
	]
});

this.guardar = new Ext.Button({
    text:'Aceptar',
    iconCls: 'icon-fin',
		align:'center',
    handler:function(){

			if(!seleccionEjercicio.main.formPanel_.getForm().isValid()){
					Ext.MessageBox.show({
							title: 'Alerta',
							msg: "Debe ingresar los campos en rojo",
							closable: false,
							icon: Ext.MessageBox.INFO,
							resizable: false,
							animEl: document.body,
							buttons: Ext.MessageBox.OK
					});
					return false;
			}

			seleccionEjercicio.main.formPanel_.getForm().submit({
					method:'POST',
					url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ejercicio/guardar',
					waitMsg: 'Seleccionando Periodo, por favor espere..',
					waitTitle:'Enviando',
					failure: function(form, action) {
						var errores = '';
						for(datos in action.result.msg){
							errores += action.result.msg[datos] + '<br>';
						}
						Ext.MessageBox.alert('Error en transacción', errores);
					},
					success: function(form, action) {
							 if(action.result.success){
								 Ext.MessageBox.show({title: 'Cargando Ejercicio', msg: '<br>Por favor  Espere...',width:300,closable:false,icon:Ext.MessageBox.INFO});
								 location.href=action.result.url;
							 }
					 }
			});

		}
});

this.ejercicio = new Ext.Window({
      title:'Seleccione Ejercicio Fiscal',
      layout:'fit',
      iconCls: 'icon-cambio',
      width:375,
			autoHeight:true,
      modal:true,
			frame:true,
      autoScroll: true,
      maximizable:false,
      closable:false,
      draggable: false,
      resizable: false,
			constrain:true,
      plain: true,
      buttonAlign:'center',
      items:[
        this.formPanel_
      ],
      buttons: [
				this.guardar
			]
});

this.ejercicio.show();
},
getStoreCO_EJERCICIO:function(){
      this.store = new Ext.data.JsonStore({
          url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ejercicio/storelista',
          root:'data',
          fields:[
              {name: 'co_anio_fiscal'},{name: 'tx_anio_fiscal'},{name: 'fe_apertura'},{name: 'fe_cierre'}
              ],
              listeners : {
                  exception : function(proxy, response, operation) {
                      Ext.Msg.alert("Aviso", 'Error al obtener respuesta del servidor intente de nuevo!');
                  }
              }
      });
      return this.store;
}
};
Ext.onReady(seleccionEjercicio.main.init, seleccionEjercicio.main);
</script>
