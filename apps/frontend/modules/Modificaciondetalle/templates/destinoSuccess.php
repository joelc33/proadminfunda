<script type="text/javascript">
Ext.ns("ModificaciondetalleEditar");
ModificaciondetalleEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_EJECUTOR = this.getStoreCO_EJECUTOR();
this.storeCO_PROYECTO = this.getStoreCO_PROYECTO();
this.storeID_AE = this.getStoreID_AE();
this.storeID_PRESUPUESTO = this.getStoreID_PRESUPUESTO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_APLICACION = this.getStoreCO_APLICACION();
//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>

this.id_tb096_presupuesto_modificacion = new Ext.form.Hidden({
    name:'tb097_modificacion_detalle[id_tb096_presupuesto_modificacion]',
    value:this.OBJ.id_tb096_presupuesto_modificacion
  });

this.nu_partida = new Ext.form.Hidden({
    name:'tb097_modificacion_detalle[nu_partida]',
    value:this.OBJ.nu_partida
});

this.id_tb082_ejecutor = new Ext.form.ComboBox({
	fieldLabel:'Ejecutor',
	store: this.storeCO_EJECUTOR,
	typeAhead: true,
  id:'id_tb082_ejecutor',
	valueField: 'id',
	displayField:'de_ejecutor',
	hiddenName:'tb097_modificacion_detalle[id_tb082_ejecutor]',
    //readOnly:(this.OBJ.id_tb082_ejecutor!='')?true:false,
    //style:(this.OBJ.id_tb082_ejecutor!='')?'background-color:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
  emptyText:'Seleccione Ejecutor...',
	selectOnFocus: true,
	mode: 'local',
	width:500,
	allowBlank:false,
  listeners:{
      select: function(){
          ModificaciondetalleEditar.main.id_tb085_presupuesto.clearValue();
          ModificaciondetalleEditar.main.id_tb083_proyecto_ac.clearValue();
          ModificaciondetalleEditar.main.id_tb084_accion_especifica.clearValue();
          ModificaciondetalleEditar.main.id_tb085_presupuesto.clearValue();
          ModificaciondetalleEditar.main.mo_distribucion.setValue(null);
          ModificaciondetalleEditar.main.storeCO_PROYECTO.load({
              params: {
                ejecutor:this.getValue()
              }
          })
      }
  }
});

this.storeCO_EJECUTOR.load();

paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb082_ejecutor,
	value:  this.OBJ.id_tb082_ejecutor,
	objStore: this.storeCO_EJECUTOR
});

if(this.OBJ.id_tb082_ejecutor){
  this.storeCO_PROYECTO.load({
                    params: {
                      ejecutor:this.OBJ.id_tb082_ejecutor
                    },
                    callback: function(){
                        ModificaciondetalleEditar.main.id_tb083_proyecto_ac.setValue(ModificaciondetalleEditar.main.OBJ.id_tb083_proyecto_ac);
                    }
                });

}

this.id_tb083_proyecto_ac = new Ext.form.ComboBox({
	fieldLabel:'Proyecto / AC',
	store: this.storeCO_PROYECTO,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_proyecto_ac',
	hiddenName:'tb097_modificacion_detalle[id_tb083_proyecto_ac]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
  emptyText:'Seleccione Proyecto / AC...',
	selectOnFocus: true,
	mode: 'local',
	width:500,
	allowBlank:false,
  listeners:{
      select: function(){
          ModificaciondetalleEditar.main.id_tb085_presupuesto.clearValue();
          ModificaciondetalleEditar.main.mo_distribucion.setValue('');
          ModificaciondetalleEditar.main.storeID_AE.load({
              params: {
                ac:this.getValue()
              }
          })
      }
  }
});

/*this.storeCO_PROYECTO.load({
    params: {
        ejecutor:this.OBJ.ejecutor
    }
});*/
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb083_proyecto_ac,
	value:  this.OBJ.id_tb083_proyecto_ac,
	objStore: this.storeCO_PROYECTO
});

if(this.OBJ.id_tb083_proyecto_ac){
  this.storeID_AE.load({
                    params: {
                      ac:this.OBJ.id_tb083_proyecto_ac
                    },
                    callback: function(){
                        ModificaciondetalleEditar.main.id_tb084_accion_especifica.setValue(ModificaciondetalleEditar.main.OBJ.id_tb084_accion_especifica);
                    }
                });

}

this.id_tb084_accion_especifica = new Ext.form.ComboBox({
	fieldLabel:'Accion Especifica',
	store: this.storeID_AE,
	typeAhead: true,
	valueField: 'id',
	displayField:'ae',
	hiddenName:'tb097_modificacion_detalle[id_tb084_accion_especifica]',
	//readOnly:(this.OBJ.id_tb084_accion_especifica!='')?true:false,
	//style:(this.main.OBJ.id_tb084_accion_especifica!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Accion Especifica...',
	selectOnFocus: true,
	mode: 'local',
	width:500,
	resizable:true,
	allowBlank:false,
  listeners:{
      select: function(){
          ModificaciondetalleEditar.main.id_tb085_presupuesto.clearValue();
          ModificaciondetalleEditar.main.mo_distribucion.setValue('');
          ModificaciondetalleEditar.main.storeID_PRESUPUESTO.load({
              params: {
                ae:this.getValue(),
                tipo_fuente:ModificaciondetalleEditar.main.OBJ.tipo_fuente,
                numero_fuente:ModificaciondetalleEditar.main.OBJ.numero_fuente,
                id_tb096_presupuesto_modificacion:ModificaciondetalleEditar.main.OBJ.id_tb096_presupuesto_modificacion
              }
          })
      }
  }
});

if(this.OBJ.id_tb084_accion_especifica){
  this.storeID_PRESUPUESTO.load({
                    params: {
                      ae:this.OBJ.id_tb084_accion_especifica,
                      id_tb096_presupuesto_modificacion:ModificaciondetalleEditar.main.OBJ.id_tb096_presupuesto_modificacion
                    },
                    callback: function(){
                        ModificaciondetalleEditar.main.id_tb085_presupuesto.setValue(ModificaciondetalleEditar.main.OBJ.id_tb085_presupuesto);
                    }
                });
}

this.id_tb085_presupuesto = new Ext.form.ComboBox({
	fieldLabel:'Partida',
	store: this.storeID_PRESUPUESTO,
	typeAhead: true,
	valueField: 'id',
	displayField:'partida',
	hiddenName:'tb097_modificacion_detalle[id_tb085_presupuesto]',
	//readOnly:(this.OBJ.id_tb085_presupuesto!='')?true:false,
	//style:(this.main.OBJ.id_tb085_presupuesto!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Partida...',
	selectOnFocus: true,
	mode: 'local',
	width:500,
	resizable:true,
	allowBlank:false,
  /*onSelect: function(record){
    ModificaciondetalleEditar.main.mo_distribucion.setValue('');
    ModificaciondetalleEditar.main.id_tb085_presupuesto.setValue(record.data.id);
    ModificaciondetalleEditar.main.nu_partida.setValue(record.data.nu_partida);
    ModificaciondetalleEditar.main.mo_disponible.setValue(record.data.mo_disponible);
    this.collapse();
  }*/
});
/*this.storeID_PRESUPUESTO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb085_presupuesto,
	value:  this.OBJ.id_tb085_presupuesto,
	objStore: this.storeID_PRESUPUESTO
});*/

this.mo_disponible = new Ext.form.NumberField({
	fieldLabel:'Monto a Transferir',
	name:'mo_disponible',
	value:this.OBJ.mo_disponible,
  readOnly: true,
  style:'background:#c9c9c9;',
	allowBlank:false,
	width:200
});

this.mo_distribucion = new Ext.form.NumberField({
	fieldLabel:'Monto',
	name:'tb097_modificacion_detalle[mo_distribucion]',
	value:this.OBJ.mo_distribucion,
	allowBlank:false,
	width:200,
  validator: function(){
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
  }
});

this.id_tb139_aplicacion = new Ext.form.ComboBox({
	fieldLabel:'Aplicacion',
	store: this.storeCO_APLICACION,
	typeAhead: true,
	valueField: 'co_aplicacion',
	displayField:'aplicacion',
	hiddenName:'tb097_modificacion_detalle[id_tb139_aplicacion]',
	//readOnly:(this.OBJ.id_tb139_aplicacion!='')?true:false,
	//style:(this.main.OBJ.id_tb139_aplicacion!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Aplicacion',
	selectOnFocus: true,
	mode: 'local',
	width:500,
	resizable:true,
	allowBlank:false,
    onSelect: function(record){
        ModificaciondetalleEditar.main.id_tb139_aplicacion.setValue(record.data.co_aplicacion);
        ModificaciondetalleEditar.main.nu_aplicacion.setValue(record.data.tx_tip_aplicacion);
        this.collapse();
    }
});
this.storeCO_APLICACION.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb139_aplicacion,
	value:  this.OBJ.id_tb139_aplicacion,
	objStore: this.storeCO_APLICACION
});

this.nu_aplicacion = new Ext.form.Hidden({
    name:'tb097_modificacion_detalle[nu_aplicacion]',
    value:this.OBJ.nu_aplicacion
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
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modificaciondetalle/guardarCredito',
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
                 PresupuestomodificacionEditar.main.store_lista_destino.load({
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
labelWidth: 140,
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
                    this.id,
                    this.id_tb096_presupuesto_modificacion,
                    this.nu_partida,
                    this.id_tb082_ejecutor,
                    this.id_tb083_proyecto_ac,
                    this.id_tb084_accion_especifica,
                    this.id_tb085_presupuesto,
                    this.mo_disponible,
//                    this.id_tb139_aplicacion,
//                    this.nu_aplicacion,
                    this.mo_distribucion,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Detalle Credito',
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
                return r.nu_proyecto_ac+' - '+r.de_proyecto_ac+' - Sector: '+r.id_tb080_sector;
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
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modificaciondetalle/storefkidtb085presupuestoCreditoAdicional',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'nu_partida'},
            {name: 'co_partida'},
            {name: 'de_partida'},
            {name: 'mo_disponible'},
            {name: 'partida',
              convert:function(v,r){
                return r.nu_pa+'.'+r.nu_ge+'.'+r.nu_es+'.'+r.nu_se+'.'+r.nu_sse+' - '+r.de_partida;
              }
            }
            ]
    });
    return this.store;
},
getStoreCO_EJECUTOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/storefkcoejecutor',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_ejecutor',
              convert:function(v,r){
                return r.nu_ejecutor+' - '+r.de_ejecutor;
              }
            }
            ]
    });
    return this.store;
},
getStoreCO_APLICACION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modificaciondetalle/storefkidtb139aplicacion',
        root:'data',
        fields:[
            {name: 'co_aplicacion'},
            {name: 'tx_tip_aplicacion'},
            {name: 'tx_aplicacion'},
            {name: 'aplicacion',
              convert:function(v,r){
                return r.tx_tip_aplicacion+' - '+r.tx_aplicacion;
              }
            }
            ]
    });
    return this.store;
}
};
Ext.onReady(ModificaciondetalleEditar.main.init, ModificaciondetalleEditar.main);
</script>
