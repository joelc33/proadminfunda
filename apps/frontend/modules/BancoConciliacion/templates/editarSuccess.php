<script type="text/javascript">
Ext.ns("BancoConciliacionEditar");
BancoConciliacionEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_BANCO = this.getStoreCO_BANCO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CUENTA_BANCARIA = this.getStoreCO_CUENTA_BANCARIA();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk> 

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>

//<ClavePrimaria>
this.id_tb105_conciliacion = new Ext.form.Hidden({
    name:'tb104_banco_conciliacion[id_tb105_conciliacion]',
    value:this.OBJ.id_tb105_conciliacion});
//</ClavePrimaria>


this.id_tb010_banco = new Ext.form.ComboBox({
  id:'id_tb010_banco_detalle',
	fieldLabel:'Banco',
	store: this.storeCO_BANCO,
	typeAhead: true,
	valueField: 'co_banco',
	displayField:'tx_banco',
	hiddenName:'tb104_banco_conciliacion[id_tb010_banco]',
  readOnly:true,
	style:'background-color:#c9c9c9;',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Banco',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false,
  listeners:{
      select: function(){
          BancoConciliacionEditar.main.storeCO_CUENTA_BANCARIA.load({
              params: {
                banco:this.getValue()
              }
          })
      }
  }
});
this.storeCO_BANCO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb010_banco,
	value:  this.OBJ.id_tb010_banco,
	objStore: this.storeCO_BANCO
});

if(this.OBJ.id_tb010_banco){
  this.storeCO_CUENTA_BANCARIA.load({
                    params: {
                      banco:this.OBJ.id_tb010_banco
                    },
                    callback: function(){
                        BancoConciliacionEditar.main.id_tb011_cuenta_bancaria.setValue(BancoConciliacionEditar.main.OBJ.id_tb011_cuenta_bancaria);
                    }
                });
}

this.id_tb010_banco.on('beforeselect',function(cmb,record,index){
        	this.id_tb011_cuenta_bancaria.clearValue();
					this.storeCO_CUENTA_BANCARIA.removeAll();
},this);

this.id_tb011_cuenta_bancaria = new Ext.form.ComboBox({
  id:'id_tb011_cuenta_bancaria_detalle',
	fieldLabel:'Cuenta',
	store: this.storeCO_CUENTA_BANCARIA,
	typeAhead: true,
	valueField: 'co_cuenta_bancaria',
	displayField:'tx_cuenta_bancaria',
	hiddenName:'tb104_banco_conciliacion[id_tb011_cuenta_bancaria]',
	readOnly:true,
	style:'background-color:#c9c9c9;',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Cuenta',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
/*this.storeCO_CUENTA_BANCARIA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb011_cuenta_bancaria,
	value:  this.OBJ.id_tb011_cuenta_bancaria,
	objStore: this.storeCO_CUENTA_BANCARIA
});*/

this.fe_movimiento = new Ext.form.DateField({
	fieldLabel:'Fecha de Movimiento',
	name:'tb104_banco_conciliacion[fe_movimiento]',
	value:this.OBJ.fe_movimiento,
	allowBlank:false,
  minValue:this.OBJ.fe_desde,
  maxValue:this.OBJ.fe_hasta,
	width:100
});

this.de_concepto = new Ext.form.TextField({
	fieldLabel:'Concepto',
	name:'tb104_banco_conciliacion[de_concepto]',
	value:this.OBJ.de_concepto,
	allowBlank:false,
	width:400
});

this.mo_cargo = new Ext.form.NumberField({
	fieldLabel:'Cargo (Bs)',
	name:'tb104_banco_conciliacion[mo_cargo]',
	value:this.OBJ.mo_cargo,
	allowBlank:false,
	width:200
});

this.mo_abono = new Ext.form.NumberField({
	fieldLabel:'Abono (Bs)',
	name:'tb104_banco_conciliacion[mo_abono]',
	value:this.OBJ.mo_abono,
	allowBlank:false,
	width:200
});

this.mo_saldo = new Ext.form.NumberField({
	fieldLabel:'Saldo (Bs)',
	name:'tb104_banco_conciliacion[mo_saldo]',
	value:this.OBJ.mo_saldo,
	allowBlank:false,
	width:200
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!BancoConciliacionEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        BancoConciliacionEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoConciliacion/guardar',
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
                 BancoConciliacionLista.main.store_lista.load({
                   params:{
                     id_tb105_conciliacion: BancoConciliacionEditar.main.OBJ.id_tb105_conciliacion
                   }
                 });
                 BancoConciliacionEditar.main.winformPanel_.close();
             }
        });


    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        BancoConciliacionEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:600,
autoHeight:true,
    autoScroll:true,
    bodyStyle:'padding:10px;',
    labelWidth: 140,
    items:[

                    this.id,
                    this.id_tb105_conciliacion,
                    this.id_tb010_banco,
                    this.id_tb011_cuenta_bancaria,
                    this.fe_movimiento,
                    this.de_concepto,
                    this.mo_cargo,
                    this.mo_abono,
                    this.mo_saldo
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Conciliacion Bancaria',
    modal:true,
    constrain:true,
width:614,
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
BancoConciliacionLista.main.mascara.hide();
}
,getStoreCO_BANCO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoConciliacion/storefkidtb010banco',
        root:'data',
        fields:[
            {name: 'co_banco'},{name: 'tx_banco'}
            ]
    });
    return this.store;
}
,getStoreCO_CUENTA_BANCARIA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoConciliacion/storefkidtb011cuentabancaria',
        root:'data',
        fields:[
            {name: 'co_cuenta_bancaria'},{name: 'tx_cuenta_bancaria'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoConciliacion/storefkidtb101tipoconcilacion',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
};
Ext.onReady(BancoConciliacionEditar.main.init, BancoConciliacionEditar.main);
</script>
