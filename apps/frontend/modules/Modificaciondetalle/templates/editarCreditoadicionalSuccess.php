<script type="text/javascript">
Ext.ns("ModificaciondetalleEditar");
ModificaciondetalleEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_PROYECTO = this.getStoreCO_PROYECTO();
this.storeID_AE = this.getStoreID_AE();
this.storeID_PRESUPUESTO = this.getStoreID_PRESUPUESTO();
//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});

this.id_tb082_ejecutor_origen = new Ext.form.Hidden({
    name:'tb097_modificacion_detalle[id_tb082_ejecutor_origen]',
    value:this.OBJ.id_tb082_ejecutor_origen});    
//</ClavePrimaria>

this.id_tb096_presupuesto_modificacion = new Ext.form.Hidden({
    name:'tb097_modificacion_detalle[id_tb096_presupuesto_modificacion]',
    value:this.OBJ.id_tb096_presupuesto_modificacion
  });

this.nu_partida = new Ext.form.Hidden({
    name:'tb097_modificacion_detalle[nu_partida]',
    value:this.OBJ.nu_partida
});

this.id_tb064_presupuesto_ingreso = new Ext.form.ComboBox({
	fieldLabel:'Partida de Ingreso',
	store: this.storeID_PRESUPUESTO,
	typeAhead: true,
	valueField: 'co_presupuesto_ingreso',
	displayField:'partida',
	hiddenName:'tb097_modificacion_detalle[id_tb064_presupuesto_ingreso]',
  readOnly:(this.OBJ.id_tb064_presupuesto_ingreso!='')?true:false,
  style:(this.OBJ.id_tb064_presupuesto_ingreso!='')?'background-color:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Partida...',
	selectOnFocus: true,
	mode: 'local',
	width:500,
	resizable:true,
	allowBlank:false,
  onSelect: function(record){
    ModificaciondetalleEditar.main.mo_distribucion.setValue('');
    ModificaciondetalleEditar.main.id_tb064_presupuesto_ingreso.setValue(record.data.co_presupuesto_ingreso);
    ModificaciondetalleEditar.main.nu_partida.setValue(record.data.nu_partida);
    ModificaciondetalleEditar.main.monto.setValue(record.data.monto);
    ModificaciondetalleEditar.main.mo_disponible.setValue(record.data.mo_disponible);
    this.collapse();
  }
});

this.storeID_PRESUPUESTO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb064_presupuesto_ingreso,
	value:  this.OBJ.id_tb064_presupuesto_ingreso,
	objStore: this.storeID_PRESUPUESTO
});

this.mo_disponible = new Ext.form.Hidden({
    name:'mo_disponible',
    value:this.OBJ.mo_disponible
});

this.monto = new Ext.form.TextField({
	fieldLabel:'Disponibilidad',
	name:'monto',
	value:this.OBJ.mo_disponible,
  readOnly: true,
  style:'background:#c9c9c9;',
	//allowBlank:false,
	width:200
});

this.mo_distribucion = new Ext.form.NumberField({
	fieldLabel:'Monto',
	name:'tb097_modificacion_detalle[mo_distribucion]',
	value:this.OBJ.mo_distribucion,
  //readOnly:(this.OBJ.mo_distribucion!='')?true:false,
  //style:(this.OBJ.mo_distribucion!='')?'background-color:#c9c9c9;':'',
	allowBlank:false,
	width:200,
  /*validator: function(){
    return this.validFlag;
  },
  listeners:{
    change: function(textfield, newValue, oldValue){
      var me = this;
      if(ModificaciondetalleEditar.main.mo_disponible.getValue() < newValue){
        me.validFlag = 'El monto a solicitar no debe superar al monto Disponible.';
      }else{
        me.validFlag = true;
      }
      //me.validFlag = 'El monto a solicitar no debe superar al monto Disponible.';
      me.validate();
    }
  }*/
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ModificaciondetalleEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ModificaciondetalleEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modificaciondetalle/guardarCreditoAdicional',
            waitMsg: 'Enviando datos, por favor espere..',
            waitTitle:'Enviando',
            failure: function(form, action) {
                Ext.MessageBox.alert('Error en transacción', action.result.msg);
            },
            success: function(form, action) {
                 if(action.result.success){
                     Ext.MessageBox.show({
                         title: 'Mensaje',
                         msg: action.result.msg,
                         closable: false,
                         icon: Ext.MessageBox.INFO,
                         resizable: false,
			                   animEl: document.body,
                         buttons: Ext.MessageBox.OK
                     });
                 }
                 PresupuestomodificacionEditar.main.store_lista.load({
                   params:{
                     id_tb096_presupuesto_modificacion:ModificaciondetalleEditar.main.id_tb096_presupuesto_modificacion.getValue()
                   },
                   callback: function(){
                       PresupuestomodificacionEditar.main.getTotal();
                   }
                 });
                 ModificaciondetalleEditar.main.winformPanel_.close();
             }
        });


    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ModificaciondetalleEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:700,
autoHeight:true,
labelWidth: 150,
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
                    this.id,
                    this.id_tb082_ejecutor_origen,
                    this.id_tb096_presupuesto_modificacion,
                    this.nu_partida,
                    this.id_tb064_presupuesto_ingreso,
                    this.mo_disponible,
//                    this.monto,
                    this.mo_distribucion,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Detalle Presupesto de Ingreso',
    modal:true,
    constrain:true,
width:714,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.formPanel_
    ],
    buttons:[
        this.guardar,
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
PresupuestomodificacionEditar.main.mascara.hide();
},
getStoreCO_PROYECTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/storefkcoproyecto',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_proyecto_ac',
              convert:function(v,r){
                return r.nu_proyecto_ac+' - '+r.de_proyecto_ac;
              }
            }
            ]
    });
    return this.store;
},
getStoreID_AE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modificaciondetalle/storefkidtb084accionespecifica',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'nu_accion_especifica'},
            {name: 'de_accion_especifica'},
            {name: 'ae',
              convert:function(v,r){
                return r.nu_accion_especifica+' - '+r.de_accion_especifica;
              }
            }
            ]
    });
    return this.store;
},
getStoreID_PRESUPUESTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modificaciondetalle/storefkidtb064presupuestoingreso',
        root:'data',
        fields:[
            {name: 'co_presupuesto_ingreso'},
            {name: 'nu_partida'},
            {name: 'tx_partida'},
            {name: 'tx_descripcion'},
            {name: 'de_partida'},
            {name: 'mo_disponible'},
            {name: 'partida',
              convert:function(v,r){
                return r.nu_partida+' - '+r.tx_descripcion;
              }
            },
            {name: 'monto',
              convert:function(v,r){
                return paqueteComunJS.funcion.getNumeroFormateado( r.mo_disponible );
              }
            }
            ]
    });
    return this.store;
}
};
Ext.onReady(ModificaciondetalleEditar.main.init, ModificaciondetalleEditar.main);
</script>
