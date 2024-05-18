<script type="text/javascript">
Ext.ns("FondoTerceroMasivo");
FondoTerceroMasivo.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>

this.storeCO_CLASE_RETENCION = this.getStoreCO_CLASE_RETENCION();
this.storeCO_TIPO_RETENCION = this.getStoreCO_TIPO_RETENCION();
this.store_lista             = this.getLista();

//<ClavePrimaria>
this.co_pago_fondo_tercero = new Ext.form.Hidden({
    name:'co_pago_fondo_tercero',
    value:this.OBJ.co_pago_fondo_tercero});
//</ClavePrimaria>

this.co_solicitud = new Ext.form.Hidden({
    name:'tb161_pago_fondo_tercero[co_solicitud]',
    value:this.OBJ.co_solicitud
});

this.co_clase_retencion = new Ext.form.ComboBox({
	fieldLabel:'Clase Retención',
	store: this.storeCO_CLASE_RETENCION,
	typeAhead: true,
	valueField: 'co_clase_retencion',
	displayField:'tx_clase_retencion',
	hiddenName:'tb161_pago_fondo_tercero[co_clase_retencion]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'...',
	selectOnFocus: true,
	mode: 'local',
	width:250,
	allowBlank:false
});
this.storeCO_CLASE_RETENCION.load({
    callback: function(){
        FondoTerceroMasivo.main.co_clase_retencion.setValue(FondoTerceroMasivo.main.OBJ.co_clase_retencion);
    }
});

if(FondoTerceroMasivo.main.OBJ.co_clase_retencion!=''){
    
    FondoTerceroMasivo.main.storeCO_TIPO_RETENCION.load({
            params:{
                co_clase_retencion:FondoTerceroMasivo.main.OBJ.co_clase_retencion
            },
            callback: function(){
                FondoTerceroMasivo.main.co_tipo_retencion.setValue(FondoTerceroMasivo.main.OBJ.co_tipo_retencion);
            }
    });
}

this.co_clase_retencion.on('select',function(cmb,record,index){
var list_tipo_retencion = paqueteComunJS.funcion.getJsonByObjStore({
        store:FondoTerceroMasivo.main.gridPanel.getStore()
});    
FondoTerceroMasivo.main.co_tipo_retencion.clearValue();
FondoTerceroMasivo.main.storeCO_TIPO_RETENCION.load({
            params:{
                co_clase_retencion:record.get('co_clase_retencion'),
                json_tipo_retencion:list_tipo_retencion
            }
        });
},this);

this.co_tipo_retencion = new Ext.form.ComboBox({
	fieldLabel:'Tipo Retención',
	store: this.storeCO_TIPO_RETENCION,
	typeAhead: true,
	valueField: 'co_tipo_retencion',
	displayField:'tx_tipo_retencion',
	hiddenName:'tb161_pago_fondo_tercero[co_tipo_retencion]',
	forceSelection:true,
	resizable:true,
        forceAll:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:250,
	allowBlank:false
    
});

this.fe_pago_desde = new Ext.form.DateField({
	fieldLabel:'Fecha de Desde',
	name:'tb161_pago_fondo_tercero[fe_pago_desde]',
	value:this.OBJ.fe_desde,
	allowBlank:false,
	width:100
});

this.fe_pago_hasta = new Ext.form.DateField({
	fieldLabel:'Fecha de Hasta',
	name:'tb161_pago_fondo_tercero[fe_pago_hasta]',
	value:this.OBJ.fe_hasta,
	allowBlank:false,
	width:100
});


this.fieldPago = new Ext.form.FieldSet({
	title: 'Datos del Fondo a Tercero',
	items:[this.co_pago_fondo_tercero,
               this.co_solicitud,
               this.co_clase_retencion,
               this.co_tipo_retencion,
               this.fe_pago_desde,
               this.fe_pago_hasta]
});

this.fieldDocumento = new Ext.form.FieldSet({
	title: 'Archivo Txt',
	items:[{
                            xtype: 'fileuploadfield',
                            style:"padding-right:330px",
                            id: 'form-file',
                            emptyText: 'Seleccione un archivo',
                            fieldLabel: 'Archivo (txt)',
                            name: 'form-file',
                            buttonText: 'Buscar'            
                    }]
});




this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!FondoTerceroMasivo.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        FondoTerceroMasivo.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoTerceroMasivo/guardar',
            waitMsg: 'Enviando datos, por favor espere..',
            waitTitle:'Enviando',
            failure: function(form, action) {
                Ext.MessageBox.alert('Error en transacción', action.result.msg);
                
//                FondoTerceroMasivo.main.nu_monto_nomina.setValue(action.result.monto);
//                FondoTerceroMasivo.main.nu_diferencia.setValue(action.result.diferencia);                
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
                     
//                  
                    FondoTerceroMasivo.main.co_pago_fondo_tercero.setValue(action.result.co_pago_fondo_tercero);

                    FondoTerceroMasivo.main.store_lista.baseParams.co_solicitud = FondoTerceroMasivo.main.OBJ.co_solicitud;
                    FondoTerceroMasivo.main.store_lista.load();
                 }
                 
                
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        FondoTerceroMasivo.main.winformPanel_.close();
    }
});

function renderMonto(val, attr, record) {
     return paqueteComunJS.funcion.getNumeroFormateado(val);
}

this.gridPanel = new Ext.grid.GridPanel({
        title:'Lista',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:150,
        width:770,
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'Cant', width:100, menuDisabled:true,dataIndex: 'cant'},
            {header: 'Banco',width:420, menuDisabled:true,dataIndex: 'tx_banco',renderer:textoLargo},
            {header: 'Monto',width:200, menuDisabled:true,dataIndex: 'total',renderer:renderMonto}
        ],
        stripeRows: true,
        autoScroll:true,
        stateful: true
});

this.store_lista.baseParams.co_solicitud = this.OBJ.co_solicitud;
this.store_lista.load();

this.formPanel_ = new Ext.form.FormPanel({
    fileUpload: true,
    frame:true,
    width:800,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.fieldPago,
           this.fieldDocumento,
           this.gridPanel]
});

this.winformPanel_ = new Ext.Window({
    title:'Fondo de Tercero Masivo',
    modal:true,
    constrain:true,
    width:800,
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
//PagoNominaLista.main.mascara.hide();
},getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoTerceroMasivo/storelista',
    root:'data',
    fields:[ 
                {name :'cant'},
                {name :'tx_banco'},
                {name :'total'}
           ]
    });
    return this.store;
}
,getStoreCO_CLASE_RETENCION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoTercero/storefkcoclaseretencion',
        root:'data',
        fields:[
            {name: 'co_clase_retencion'},
            {name: 'tx_clase_retencion'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_RETENCION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoTerceroMasivo/storefkcotiporetencion',
        root:'data',
        fields:[
            {name: 'co_tipo_retencion'},
            {name: 'tx_tipo_retencion'}
            ]
    });
    return this.store;
}
};
Ext.onReady(FondoTerceroMasivo.main.init, FondoTerceroMasivo.main);
</script>
