<script type="text/javascript">
Ext.ns("BancoConciliacionLista");
BancoConciliacionLista.main = {
array_pago: [],
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
}, 
init:function(){
//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});


this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.storeCO_BANCO = this.getStoreCO_BANCO();
this.storeCO_CUENTA_BANCARIA = this.getStoreCO_CUENTA_BANCARIA();

this.store_lista = this.getLista();

this.hiddenJsonPago  = new Ext.form.Hidden({
        name:'json_pago',
        value:''
});

this.fecha_desde  = new Ext.form.Hidden({
        name:'tb105_conciliacion[fecha_desde]',
        value:''
});

this.fecha_hasta  = new Ext.form.Hidden({
        name:'tb105_conciliacion[fecha_hasta]',
        value:''
});

this.codigo_banco  = new Ext.form.Hidden({
        name:'tb105_conciliacion[codigo_banco]',
        value:''
});

this.codigo_cuenta  = new Ext.form.Hidden({
        name:'tb105_conciliacion[codigo_cuenta]',
        value:''
});


this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id
});


this.co_solicitud = new Ext.form.Hidden({
	name:'tb105_conciliacion[co_solicitud]',
	value:this.OBJ.co_solicitud,
	allowBlank:false
});

this.co_proceso = new Ext.form.Hidden({
	name:'tb105_conciliacion[co_proceso]',
	value:this.OBJ.co_proceso,
	allowBlank:false
});

this.co_tipo_solicitud = new Ext.form.Hidden({
	name:'tb105_conciliacion[co_tipo_solicitud]',
	value:this.OBJ.co_tipo_solicitud,
	allowBlank:false
});

this.id_tb010_banco = new Ext.form.ComboBox({
  id:'id_tb010_banco',
	fieldLabel:'Banco',
	store: this.storeCO_BANCO,
	typeAhead: true,
	valueField: 'co_banco',
	displayField:'tx_banco',
	hiddenName:'tb105_conciliacion[id_tb010_banco]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Banco',
	selectOnFocus: true,
	mode: 'local',
	width:390,
	resizable:true,
	allowBlank:false,
  listeners:{
      select: function(){
          BancoConciliacionLista.main.storeCO_CUENTA_BANCARIA.load({
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
                        BancoConciliacionLista.main.id_tb011_cuenta_bancaria.setValue(BancoConciliacionLista.main.OBJ.id_tb011_cuenta_bancaria);
                    }
                });
}

this.id_tb010_banco.on('beforeselect',function(cmb,record,index){
        	this.id_tb011_cuenta_bancaria.clearValue();
					this.storeCO_CUENTA_BANCARIA.removeAll();
},this);

this.id_tb011_cuenta_bancaria = new Ext.form.ComboBox({
  id:'id_tb011_cuenta_bancaria',
	fieldLabel:'Cuenta',
	store: this.storeCO_CUENTA_BANCARIA,
	typeAhead: true,
	valueField: 'co_cuenta_bancaria',
	displayField:'tx_cuenta_bancaria',
	hiddenName:'tb105_conciliacion[id_tb011_cuenta_bancaria]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Cuenta',
	selectOnFocus: true,
	mode: 'local',
	width:390,
	resizable:true,
	allowBlank:false
});

this.fe_desde = new Ext.form.DateField({
  id:'fe_desde',
	fieldLabel:'Fecha Desde',
	name:'tb105_conciliacion[fe_desde]',
	value:this.OBJ.fe_desde,
        format:'d-m-Y',
	allowBlank:false,
	width:100
});

this.fe_hasta = new Ext.form.DateField({
  id:'fe_hasta',
	fieldLabel:'Fecha Hasta',
	name:'tb105_conciliacion[fe_hasta]',
	value:this.OBJ.fe_hasta,
        format:'d-m-Y',
	allowBlank:false,
	width:100
});

this.compositefieldFecha = new Ext.form.CompositeField({
        fieldLabel: 'Fecha Desde',
//      msgTarget : 'side',
        anchor    : '-20',
        defaults: {
            flex: 1
        },
        items: [
             this.fe_desde,
             {
                   xtype: 'displayfield',
                   value: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fecha Hasta:',
                   width: 180
             },
             this.fe_hasta
        ]
});

this.fieldset1 = new Ext.form.FieldSet({
	title: 'Datos de Cuenta',
	autoWidth:true,
        items:[this.id_tb010_banco,
               this.id_tb011_cuenta_bancaria,
               this.compositefieldFecha]
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!BancoConciliacionLista.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }        
       
        BancoConciliacionLista.main.hiddenJsonPago.setValue(BancoConciliacionLista.main.array_pago);
        BancoConciliacionLista.main.fecha_desde.setValue(BancoConciliacionLista.main.fe_desde.value);  
        BancoConciliacionLista.main.fecha_hasta.setValue(BancoConciliacionLista.main.fe_hasta.value); 
        BancoConciliacionLista.main.codigo_banco.setValue(BancoConciliacionLista.main.id_tb010_banco.getValue());
        BancoConciliacionLista.main.codigo_cuenta.setValue(BancoConciliacionLista.main.id_tb011_cuenta_bancaria.getValue()); 
        
         
        BancoConciliacionLista.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Conciliacion/guardar',
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
                 //BancoConciliacionLista.main.store_lista.load();
                 BancoConciliacionLista.main.store_lista.load({
                   params:{
                     id_tb105_conciliacion: action.result.codigo
                   }
                 });
                 Detalle.main.store_lista.load();
                 BancoConciliacionLista.main.winformPanel_.close();
             }
        });


    }
});


if(this.OBJ.id){
    this.store_lista.load({
        params:{
            co_conciliacion:this.OBJ.id,
            co_banco: BancoConciliacionLista.main.OBJ.id_tb010_banco,
            co_cuenta:BancoConciliacionLista.main.OBJ.id_tb011_cuenta_bancaria,
            fe_desde: BancoConciliacionLista.main.fe_desde.value,
            fe_hasta: BancoConciliacionLista.main.fe_hasta.value
        },
        callback: function(){
            var records = [];
            this.each(function(record,rowIndex){
                if(record.get("in_consolidado") == 1)
                {  
                    records.push(record); 
                }
            })           
            BancoConciliacionLista.main.gridPanel_.getSelectionModel().selectRecords(records);            
           
        }
    });
}

var myCboxSelModel = new Ext.grid.CheckboxSelectionModel({
        // override private method to allow toggling of selection on or off for multiple rows.
        
        handleMouseDown : function(g, rowIndex, e){
              var view = this.grid.getView();
              var isSelected = this.isSelected(rowIndex);
              if(isSelected) {  
                this.deselectRow(rowIndex);
              } 
              else if(!isSelected || this.getCount() > 1) {
                this.selectRow(rowIndex, true);
                view.focusRow(rowIndex);
              }else{
                  this.deselectRow(rowIndex);
              }             
        },
        singleSelect: false,
        listeners: {
           selectionchange: function(sm, rowIndex, rec) {                    
                var length = sm.selections.length, record = [];
                
                if(length>0){
                    for(var i = 0; i<length;i++){
                        record.push(sm.selections.items[i].data.co_pago);        
                    }
                }
                delete BancoConciliacionLista.main.array_pago.splice(0,BancoConciliacionLista.main.array_pago.length);
                BancoConciliacionLista.main.array_pago.push(record);
           }           
        }
});

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Conciliación',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:350,
    width:1180,
    id:'gridPanel',
    sm: myCboxSelModel,
    columns: [
//        new Ext.grid.RowNumberer(),
        myCboxSelModel,
        {header: 'co_pago',hidden:true, menuDisabled:true,dataIndex: 'co_pago'},
        {header: 'Solicitud', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud'},
        {header: 'Banco', width:180,  menuDisabled:true, sortable: true,  dataIndex: 'tx_banco',renderer:textoLargo},
        {header: 'Cuenta', width:180,  menuDisabled:true, sortable: true,  dataIndex: 'tx_cuenta_bancaria'},
        {header: 'Tipo Transacción', width:120,  menuDisabled:true, sortable: true,  dataIndex: 'tx_forma_pago'},
        {header: 'Transf./Cheque', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_pago'},
        {header: 'Fecha', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'fe_pago'},
        {header: 'Tipo Solicitud', width:180,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tipo_solicitud'},
        {header: 'Pago', width:200,  menuDisabled:true, sortable: true, renderer: formatoNumero,  dataIndex: 'nu_monto'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        BancoConciliacionLista.main.winformPanel_.close();
    }
});

this.tbar_modificacion = {
    xtype        : 'toolbar',
    layout       : 'hbox',
    items        : this.nu_conciliacion,
    height       : 25,
    layoutConfig : {
        align : 'left'
    }
};

this.formFiltroPrincipal = new Ext.form.FormPanel({
    title:'Busqueda',
    iconCls: 'icon-solpendiente',
    collapsible: true,
    titleCollapse: true,
    autoWidth:true,
    border:false,
    labelWidth: 110,
    padding:'10px',
    items   : [this.fieldset1],
    keys: [{
		key:[Ext.EventObject.ENTER],
		handler: function() {     
                    BancoConciliacionLista.main.getConsultar();
                }
           }
    ],
    buttonAlign:'center',
    buttons:[
        {
            text:'Consultar',
            iconCls:'icon-buscar',
            handler:function(){
                BancoConciliacionLista.main.getConsultar();
            }
        },
        {
            text:'Limpiar',
            iconCls:'icon-limpiar',
            handler:function(){
//                pendienteEntidadesLista.main.limpiarCamposByFormFiltro();
            }
        }
    ]
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:false,
    autoHeight:true,
    border: false,
    bodyStyle:'padding:0px;',
    items:[
                    this.id,
                    this.hiddenJsonPago,
                    this.co_solicitud,
                    this.co_tipo_solicitud,
                    this.co_proceso,
                    this.gridPanel_,
                    this.fecha_desde,  
                    this.fecha_hasta,
                    this.codigo_banco,
                    this.codigo_cuenta
            ]
});

//this.gridPanel_.render("contenedorBancoConciliacionLista");
this.winformPanel_ = new Ext.Window({
    title:'Conciliacion Manual',
    modal:true,
    constrain:true,
    width:1200,
    frame:true,
    closabled:true,
    autoHeight:true,
//    tbar: this.tbar_modificacion,
    bodyStyle:'padding:5px;',
    items:[
        this.formFiltroPrincipal,
        this.formPanel_
    ],
    buttons:[
        //this.crear,
        this.guardar,
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();



//this.store_lista.load();
},getConsultar: function(){
        if(BancoConciliacionLista.main.id_tb010_banco.getValue()==''){
            Ext.Msg.alert("Notificación","Debe seleccionar el Banco"); 
            return false;
        }

        if(BancoConciliacionLista.main.id_tb011_cuenta_bancaria.getValue()==''){
            Ext.Msg.alert("Notificación","Debe la cuenta Bancaria a Consolidar"); 
            return false;
        }

        if(BancoConciliacionLista.main.fe_desde.getValue()==''){
            Ext.Msg.alert("Notificación","Debe indicar la fecha a consultar"); 
            return false;
        }

        if(BancoConciliacionLista.main.fe_hasta.getValue()==''){
            Ext.Msg.alert("Notificación","Debe indicar la fecha a consultar"); 
            return false;
        }


        BancoConciliacionLista.main.store_lista.load({
            params:{
                co_banco:BancoConciliacionLista.main.id_tb010_banco.getValue(),
                co_cuenta:BancoConciliacionLista.main.id_tb011_cuenta_bancaria.getValue(),
                fe_desde:BancoConciliacionLista.main.fe_desde.value,
                fe_hasta:BancoConciliacionLista.main.fe_hasta.value
            }
        });
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoConciliacion/storelista',
    root:'data',
    fields:[
                {name: 'co_solicitud'},
                {name: 'co_pago'},
                {name: 'tx_banco'},
                {name: 'tx_cuenta_bancaria'},
                {name: 'fe_pago'},
                {name: 'tx_tipo_solicitud'},
                {name: 'nu_monto'},
                {name: 'in_consolidado'},
                {name: 'tx_forma_pago'},
                {name: 'nu_pago'},
                {name: 'co_conciliacion'}
           ]
    });
    return this.store;
       
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
};
Ext.onReady(BancoConciliacionLista.main.init, BancoConciliacionLista.main);
</script>
<div id="contenedorBancoConciliacionLista"></div>
<div id="formularioBancoConciliacion"></div>
<div id="filtroBancoConciliacion"></div>
