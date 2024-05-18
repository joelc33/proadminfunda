<script type="text/javascript">
Ext.ns("PagoNominaLista");
PagoNominaLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.storeCO_LIQUIDACION = this.getStoreCO_LIQUIDACION();

//<Stores de fk>
this.storeCO_BANCO = this.getStoreCO_BANCO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CUENTA_BANCARIA = this.getStoreCO_CUENTA_BANCARIA();
//<Stores de fk>

/*this.co_liquidacion_pago = new Ext.form.Hidden({
    name:'co_liquidacion_pago'
}); */ 

this.nu_banco = new Ext.form.Hidden({
    name:'nu_banco'
});

this.id_tb010_banco = new Ext.form.ComboBox({
	fieldLabel:'Banco',
	store: this.storeCO_BANCO,
	typeAhead: true,
	valueField: 'co_banco',
	displayField:'banco',
	hiddenName:'co_banco',
	//readOnly:(this.OBJ.id_tb010_banco!='')?true:false,
	//style:(this.main.OBJ.id_tb010_banco!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Banco',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false,
    onSelect: function(record){
		PagoNominaLista.main.id_tb010_banco.setValue(record.data.co_banco);
		PagoNominaLista.main.nu_banco.setValue(record.data.tx_codigo_banco);
        PagoNominaLista.main.storeCO_CUENTA_BANCARIA.load({
            params: {
                co_banco:this.getValue()
            },
            callback: function(){
                PagoNominaLista.main.id_tb011_cuenta_bancaria.setValue('');
            }
        });
		this.collapse();
    }
});
this.storeCO_BANCO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb010_banco,
	value:  this.OBJ.id_tb010_banco,
	objStore: this.storeCO_BANCO
});

this.id_tb011_cuenta_bancaria = new Ext.form.ComboBox({
	fieldLabel:'Cuenta Bancaria',
	store: this.storeCO_CUENTA_BANCARIA,
	typeAhead: true,
	valueField: 'co_cuenta_bancaria',
	displayField:'cuenta',
	hiddenName:'co_cuenta_bancaria',
	//readOnly:(this.OBJ.id_tb011_cuenta_bancaria!='')?true:false,
	//style:(this.main.OBJ.id_tb011_cuenta_bancaria!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Cuenta Bancaria',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	//allowBlank:false
});
/*this.storeCO_CUENTA_BANCARIA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb011_cuenta_bancaria,
	value:  this.OBJ.id_tb011_cuenta_bancaria,
	objStore: this.storeCO_CUENTA_BANCARIA
});*/

this.co_solicitud = new Ext.form.NumberField({
                    fieldLabel:'Solicitud',
                    name:'co_solicitud_anular',
                    allowBlank:false
});

this.co_solicitud.on("blur",function(){
    if(PagoNominaLista.main.co_solicitud.getValue()!=''){
         PagoNominaLista.main.buscarSolicitud();
    }
});

this.tipo_solicitud = new Ext.form.TextField({
        fieldLabel:'Tipo de Solicitud',
        name:'tx_tipo_solicitud',
        readOnly:true,
        width:500,
        style:'background:#c9c9c9;',
});

this.rif = new Ext.form.TextField({
        fieldLabel:'RIF',
        name:'tx_rif',
        readOnly:true,
        width:500,
        style:'background:#c9c9c9;',
});


this.co_liquidacion_pago = new Ext.form.ComboBox({
                    fieldLabel:'Monto Liquidado',
                    store: this.storeCO_LIQUIDACION,
                    typeAhead: true,
                    valueField: 'co_liquidacion_pago',
                    displayField:'mo_pagado',
                    hiddenName:'co_liquidacion_pago',
                    forceSelection:true,
                    resizable:true,
                    triggerAction: 'all',
                    emptyText:'Seleccione...',
                    selectOnFocus: true,
                    mode: 'local',
                    width:400,
                    resizable:true,
                    //allowBlank:false
});
            
this.razon_social = new Ext.form.TextField({
        fieldLabel:'Razon Soical',
        name:'tx_razon_social',
        readOnly:true,
        width:500,
        style:'background:#c9c9c9;',
});

this.tx_concepto = new Ext.form.TextField({
        fieldLabel:'Concepto',
	name:'tx_concepto',
	allowBlank:false,
	width:500
});

this.fieldSolicitud = new Ext.form.FieldSet({
	title: 'Datos de la Solicitud',
	items:[this.co_solicitud,
               this.tipo_solicitud,
               this.rif,
               this.razon_social,
               this.co_liquidacion_pago]
});

this.fieldDocumento = new Ext.form.FieldSet({
	title: 'Datos del Pago',
	items:[
               //this.fe_pago,
              // this.co_liquidacion_pago,
              this.nu_banco,
              this.id_tb010_banco,
              this.id_tb011_cuenta_bancaria,
               this.tx_concepto,
               //this.banco,
               //this.cuenta,
               //this.nu_pago,
               {
                            xtype: 'fileuploadfield',
                            style:"padding-right:330px",
                            id: 'form-file',
                            width:500,
                            emptyText: 'Seleccione un archivo',
                            fieldLabel: 'Archivo (txt)',
                            name: 'form-file',
                            buttonText: 'Buscar'            
                }]
});

this.formPanel_ = new Ext.form.FormPanel({
    title:'Generar TXT Nomina',
    fileUpload: true,
   // frame:true,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
        //this.fieldSolicitud,
        this.fieldDocumento
    ],
     buttons:[
        {
            text:'Generar',
            iconCls:'icon-buscar',
            handler:function(){
                if(!PagoNominaLista.main.formPanel_.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
                    return false;
                }
                PagoNominaLista.main.formPanel_.getForm().submit({
                    method:'POST',
                    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/GeneradorTxtBanco/guardar',
                    failure: function(form, action) {
                        Ext.MessageBox.alert('Error en transacción', action.result.msg);
                     },
                    success: function(form, action) {
                         
                    }
                });
            }
        }
    ],
    buttonAlign:'center'
});

this.formPanel_.render("contenedorPagoNominaLista");


},
buscarSolicitud: function(){
         Ext.Ajax.request({
                method:'GET',
                url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/GeneradorTxtBanco/verificarSolicitud',
                params:{
                    co_solicitud: PagoNominaLista.main.co_solicitud.getValue()
                },
                success:function(result, request ) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if(!obj.data){
                        
                        PagoNominaLista.main.tipo_solicitud.setValue("");

                        Ext.Msg.show({
                            title : 'ALERTA',
                            msg : 'La solicitud no se encuentra registrada o no se ha procesado el pago',
                            width : 400,
                            height : 800,
                            closable : false,
                            buttons : Ext.Msg.OK,
                            icon : Ext.Msg.INFO
                        });

                    }else{
                        PagoNominaLista.main.rif.setValue(obj.data.inicial+'-'+obj.data.tx_rif);                       
                        PagoNominaLista.main.razon_social.setValue(obj.data.tx_razon_social);                       
                        PagoNominaLista.main.tipo_solicitud.setValue(obj.data.tx_tipo_solicitud);                       
                        
                        PagoNominaLista.main.storeCO_LIQUIDACION.baseParams.co_solicitud = obj.data.co_solicitud;
                        PagoNominaLista.main.storeCO_LIQUIDACION.load();
                    }
                }
         });
},
getStoreCO_LIQUIDACION: function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/GeneradorTxtBanco/storefkcoliquidacion',
        root:'data',
        fields:[
            {name: 'co_liquidacion_pago'},
            {name: 'mo_pagado'}
        ]
    });
    return this.store;
}
,getStoreCO_BANCO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/GeneradorTxtBanco/storefkidtb010banco',
        root:'data',
        fields:[
            {name: 'co_banco'},
            {name: 'tx_banco'},
            {name: 'nu_codigo'},
            {name: 'tx_siglas'},
            {name: 'tx_codigo_banco'},
            {name: 'banco',
                convert:function(v,r){
                    return r.tx_codigo_banco+' - '+r.tx_banco;
                }
            }
            ]
    });
    return this.store;
}
,getStoreCO_CUENTA_BANCARIA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/GeneradorTxtBanco/storefkidtb011cuentabancaria',
        root:'data',
        fields:[
            {name: 'co_cuenta_bancaria'},
            {name: 'tx_cuenta_bancaria'},
            {name: 'tx_descripcion'},
            {name: 'nu_contrato'},
            {name: 'cuenta',
                convert:function(v,r){
                    return r.tx_cuenta_bancaria+' - CONTRATO: '+r.nu_contrato;
                }
            }
            ]
    });
    return this.store;
}
};
Ext.onReady(PagoNominaLista.main.init, PagoNominaLista.main);
</script>
<div id="contenedorPagoNominaLista"></div>
