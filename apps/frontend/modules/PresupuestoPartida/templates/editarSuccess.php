<script type="text/javascript">
Ext.ns("PresupuestoPartidaEditar");
PresupuestoPartidaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.storeID = this.getStoreID();
this.storeCO_PARTIDA = this.getStoreCO_PARTIDA();

this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id
});

this.id_tb084_accion_especifica =  new Ext.form.Hidden({
    name:'tb085_presupuesto[id_tb084_accion_especifica]',
    value:this.OBJ.id_tb084_accion_especifica
});     

this.co_partida = new Ext.form.ComboBox({
	fieldLabel:'Partida',
	store: this.storeCO_PARTIDA,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_partida',
	hiddenName:'tb085_presupuesto[co_partida]',
	forceSelection:true,
	resizable:true,
        forceAll:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:700,
	emptyText:'Seleccione...',
	allowBlank:false    
});
this.storeCO_PARTIDA.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_partida,
	value:  this.OBJ.co_partida,
	objStore: this.storeCO_PARTIDA
});

this.nu_partida = new Ext.form.TextField({
	fieldLabel:'Nu partida',
	name:'tb085_presupuesto[nu_partida]',
	value:this.OBJ.nu_partida,
	allowBlank:false,
	width:200
});

this.de_partida = new Ext.form.TextField({
	fieldLabel:'De partida',
	name:'tb085_presupuesto[de_partida]',
	value:this.OBJ.de_partida,
	allowBlank:false,
	width:200
});

this.mo_inicial = new Ext.form.NumberField({
	fieldLabel:'Monto Inicial',
	name:'tb085_presupuesto[mo_inicial]',
	value:this.OBJ.mo_inicial,
	allowBlank:false,
	width:300
});

this.mo_actualizado = new Ext.form.NumberField({
	fieldLabel:'Monto Actualizado',
	name:'tb085_presupuesto[mo_actualizado]',
	value:this.OBJ.mo_actualizado,
	allowBlank:false,
	width:300
});


this.mo_comprometido = new Ext.form.NumberField({
	fieldLabel:'Comprometido',
	name:'tb085_presupuesto[mo_comprometido]',
	value:this.OBJ.mo_comprometido,
	allowBlank:false,
	width:300
});

this.mo_causado = new Ext.form.NumberField({
	fieldLabel:'Causado',
	name:'tb085_presupuesto[mo_causado]',
	value:this.OBJ.mo_causado,
	allowBlank:false,
	width:300
});

this.mo_pagado = new Ext.form.NumberField({
	fieldLabel:'Pagado',
	name:'tb085_presupuesto[mo_pagado]',
	value:this.OBJ.mo_pagado,
	allowBlank:false,
	width:300
});

this.mo_disponible = new Ext.form.NumberField({
	fieldLabel:'Disponible',
	name:'tb085_presupuesto[mo_disponible]',
	value:this.OBJ.mo_disponible,
	allowBlank:false,
	width:300
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'Activo',
	name:'tb085_presupuesto[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!PresupuestoPartidaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        PresupuestoPartidaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoPartida/guardar',
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
                
                PartidapresupuestoLista.main.store_lista.baseParams.codigo=PartidapresupuestoLista.main.OBJ.codigo;
                PartidapresupuestoLista.main.store_lista.load();
                PresupuestoPartidaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        PresupuestoPartidaEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:900,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[         this.id,
                    this.id_tb084_accion_especifica,
                    this.co_partida,
                    this.mo_inicial,
                    this.mo_disponible,
                    this.mo_pagado
          ]
});

this.winformPanel_ = new Ext.Window({
    title:'Agregar Partida',
    modal:true,
    constrain:true,
    width:900,
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
PartidapresupuestoLista.main.mascara.hide();
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoPartida/storefkidtb084accionespecifica',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
},
getStoreCO_PARTIDA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoPartida/storefkcopartida',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_partida',
            convert:function(v,r){
            return r.nu_partida+' - '+r.de_partida;
            }
            }
            ]
    });
    return this.store;
}
};
Ext.onReady(PresupuestoPartidaEditar.main.init, PresupuestoPartidaEditar.main);
</script>
