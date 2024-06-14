<script type="text/javascript">
Ext.ns("PagoNominaMasivoEditar");
PagoNominaMasivoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_TIPO_TRABAJADOR = this.getStoreCO_TIPO_TRABAJADOR();
this.storeCO_EJECUTOR = this.getStoreCO_EJECUTOR();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TIPO_NOMINA     = this.getStoreCO_TIPO_NOMINA();
this.store_lista             = this.getLista();
this.store_lista_deduccion   = this.getListaDeducciones();
this.store_lista_aporte      = this.getListaAporte();

//<ClavePrimaria>
this.co_pago_nomina = new Ext.form.Hidden({
    name:'co_pago_nomina',
    value:this.OBJ.co_pago_nomina});
//</ClavePrimaria>

this.co_solicitud = new Ext.form.Hidden({
    name:'tb132_pago_nomina_masivo[co_solicitud]',
    value:this.OBJ.co_solicitud
});

this.tx_concepto = new Ext.form.TextArea({
	fieldLabel:'Concepto',
	name:'tb132_pago_nomina_masivo[tx_concepto]',
	value:this.OBJ.tx_concepto,
	allowBlank:false,
	width:730
});

this.fe_pago = new Ext.form.DateField({
	fieldLabel:'Fecha de Pago',
	name:'tb132_pago_nomina_masivo[fe_pago]',
	value:this.OBJ.fe_pago,
	allowBlank:false,
	width:100,
    minValue:this.OBJ.fe_ini,
	maxValue:this.OBJ.fe_fin,
});

this.fieldPago = new Ext.form.FieldSet({
	title: 'Datos de la Nomina',
	items:[this.co_pago_nomina,
                this.co_solicitud,
                this.tx_concepto,
                this.fe_pago]
});

this.fieldDocumento = new Ext.form.FieldSet({
	title: 'Archivo de Presupuesto',
	items:[{
                            xtype: 'fileuploadfield',
                            style:"padding-right:630px",
                            id: 'form-file',
                            emptyText: 'Seleccione un archivo',
                            fieldLabel: 'Archivo (xls)',
                            name: 'form-file',
                            buttonText: 'Buscar'
                    }]
});

function renderMonto(val, attr, record) {
     return paqueteComunJS.funcion.getNumeroFormateado(val);
}

function renderMontoDisponible(val, attr, record) {
    if(parseFloat(record.data.mo_disponible) >= parseFloat(record.data.nu_monto)){
        return '<p style="color:green"><b>'+paqueteComunJS.funcion.getNumeroFormateado(record.data.mo_disponible)+'</b></p>';
     }else{
        return '<p style="color:red"><b>'+paqueteComunJS.funcion.getNumeroFormateado(record.data.mo_disponible)+'</b></p>';
     }
} 

this.displayfieldmonto_presupuesto = new Ext.form.DisplayField({
 value:"<span style='font-size:12px;'><b>Monto Presupuesto: </b>0.00</b></span>"
});

this.displayfieldmonto_asignacion = new Ext.form.DisplayField({
 value:"<span style='font-size:12px;'><b>Asignacion: </b>0.00</b></span>"
});

this.displayfieldmonto_deduccion = new Ext.form.DisplayField({
 value:"<span style='font-size:12px;'><b>Deducción: </b>0.00</b></span>"
});

this.displayfieldmonto_aporte = new Ext.form.DisplayField({
 value:"<span style='font-size:12px;'><b>Aporte: </b>0.00</b></span>"
});

this.displayfieldmonto_neto = new Ext.form.DisplayField({
 value:"<span style='font-size:12px;'><b>Neto: </b>0.00</b></span>"
});

this.gridPanelAsignacion = new Ext.grid.GridPanel({
        title:'Detalle del Concepto',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:300,
        width:950,
        //tbar:[this.causar,'-',this.descausar],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_solicitud', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_solicitud'},
            {header: 'Concepto',width:220, menuDisabled:true,dataIndex: 'tx_descripcion',renderer:textoLargo},
            {header: 'Cod. Partida', width:130, menuDisabled:true,dataIndex: 'tx_partida'},
            {header: 'Partida',width:220, menuDisabled:true,dataIndex: 'de_partida',renderer:textoLargo},
            {header: 'Monto Disponible',width:180, menuDisabled:true,dataIndex: 'mo_disponible',renderer:renderMontoDisponible},
            {header: 'Monto',width:180, menuDisabled:true,dataIndex: 'nu_monto',renderer:renderMonto}
        ],
        stripeRows: true,
        autoScroll:true,
        stateful: true
});


this.store_lista.baseParams.co_solicitud = this.OBJ.co_solicitud;
this.store_lista.load({ callback: function(){
                                PagoNominaMasivoEditar.main.getCalcular();
                        }});
                    
this.gridPanelDeduccion = new Ext.grid.GridPanel({
        title:'Lista',
        iconCls: 'icon-libro',
        store: this.store_lista_deduccion,
        loadMask:true,
        height:300,
        width:950,
        //tbar:[this.causar,'-',this.descausar],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_solicitud', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_solicitud'},
            {header: 'Concepto',width:620, menuDisabled:true,dataIndex: 'tx_descripcion',renderer:textoLargo},
            {header: 'Monto',width:180, menuDisabled:true,dataIndex: 'nu_monto',renderer:renderMonto}
        ],
        stripeRows: true,
        autoScroll:true,
        stateful: true
});

this.store_lista_deduccion.baseParams.co_solicitud = this.OBJ.co_solicitud;
this.store_lista_deduccion.load({ callback: function(){
                                PagoNominaMasivoEditar.main.getCalcular();
                        }});
                    


this.gridPanelAporte = new Ext.grid.GridPanel({
        title:'Lista',
        iconCls: 'icon-libro',
        store: this.store_lista_aporte,
        loadMask:true,
        height:300,
        width:950,
        //tbar:[this.causar,'-',this.descausar],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_solicitud', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_solicitud'},
            {header: 'Concepto',width:620, menuDisabled:true,dataIndex: 'tx_descripcion',renderer:textoLargo},
            {header: 'Monto',width:180, menuDisabled:true,dataIndex: 'nu_monto',renderer:renderMonto}
        ],
        stripeRows: true,
        autoScroll:true,
        stateful: true
});

this.store_lista_aporte.baseParams.co_solicitud = this.OBJ.co_solicitud;
this.store_lista_aporte.load({ callback: function(){
                                PagoNominaMasivoEditar.main.getCalcular();
                        }});


this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!PagoNominaMasivoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        PagoNominaMasivoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/guardarMaestro',
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

                 //PagoNominaMasivoEditar.main.winformPanel_.close();
                 
                 PagoNominaMasivoEditar.main.co_pago_nomina.setValue(action.result.co_pago_nomina);
                 PagoNominaMasivoEditar.main.co_solicitud.setValue(action.result.co_solicitud);
                 
                 PagoNominaMasivoEditar.main.store_lista.baseParams.co_solicitud = action.result.co_solicitud;
                 PagoNominaMasivoEditar.main.store_lista.load({
                     callback: function(){
                         PagoNominaMasivoEditar.main.getCalcular();
                     }
                 });
                 
                 PagoNominaMasivoEditar.main.store_lista_deduccion.baseParams.co_solicitud = action.result.co_solicitud;
                 PagoNominaMasivoEditar.main.store_lista_deduccion.load({
                     callback: function(){
                         PagoNominaMasivoEditar.main.getCalcular();
                     }
                 });
                 
                 
                 PagoNominaMasivoEditar.main.store_lista_aporte.baseParams.co_solicitud = action.result.co_solicitud;
                 PagoNominaMasivoEditar.main.store_lista_aporte.load({
                     callback: function(){
                         PagoNominaMasivoEditar.main.getCalcular();
                     }
                 });
                 
                 solicitudLista.main.store_lista.load();
             }
        });


    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        PagoNominaMasivoEditar.main.winformPanel_.close();
    }
});

this.tabuladores = new Ext.TabPanel({
        resizeTabs:true, // turn on tab resizing
        minTabWidth: 115,
        tabWidth:150,border:false,
        enableTabScroll:true,
        autoWidth:true,
        autoHeight:250,
        activeTab: 0,
        defaults: {autoScroll:true},
        items:[
                {
                        title: 'Asignación',
                        items:[this.gridPanelAsignacion]
                },
                {
                        title: 'Deducción',
                        items:[this.gridPanelDeduccion]
                },
                {
                        title: 'Aporte',
                        items:[this.gridPanelAporte]
                }
        ]
});


this.formPanel_ = new Ext.form.FormPanel({
    fileUpload: true,
    frame:true,
    width:1000,
    autoHeight:true,
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.fieldPago,
           this.fieldDocumento,
           this.tabuladores]
});

this.winformPanel_ = new Ext.Window({
    title:'Pago Nomina',
    modal:true,
    constrain:true,
    width:1000,
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
    bbar: new Ext.ux.StatusBar({
            autoScroll:true,
            defaults:{style:'color:black;font-size:30px;',autoWidth:true},
            items:[
             this.displayfieldmonto_asignacion,'-',
             this.displayfieldmonto_deduccion,'-',
             this.displayfieldmonto_aporte,'-',
             this.displayfieldmonto_neto
            ]
    }),
    buttonAlign:'center'
});
this.winformPanel_.show();
//PagoNominaLista.main.mascara.hide();
},getCalcular: function(){
    var monto_asignacion = paqueteComunJS.funcion.getSumaColumnaGrid({
                store:PagoNominaMasivoEditar.main.store_lista,
                campo:'nu_monto'
    }); 

    var monto_deduccion = paqueteComunJS.funcion.getSumaColumnaGrid({
            store:PagoNominaMasivoEditar.main.store_lista_deduccion,
            campo:'nu_monto'
    });
    
    var monto_aporte = paqueteComunJS.funcion.getSumaColumnaGrid({
            store:PagoNominaMasivoEditar.main.store_lista_aporte,
            campo:'nu_monto'
    });    

    PagoNominaMasivoEditar.main.displayfieldmonto_asignacion.setValue("<span style='font-size:12px;'><b>Asignación: </b>"+paqueteComunJS.funcion.getNumeroFormateado(monto_asignacion)+"</b></span>");
    PagoNominaMasivoEditar.main.displayfieldmonto_deduccion.setValue("<span style='font-size:12px;'><b>Deducción: </b>"+paqueteComunJS.funcion.getNumeroFormateado(monto_deduccion)+"</b></span>");
    PagoNominaMasivoEditar.main.displayfieldmonto_aporte.setValue("<span style='font-size:12px;'><b>Aporte: </b>"+paqueteComunJS.funcion.getNumeroFormateado(monto_aporte)+"</b></span>");
    PagoNominaMasivoEditar.main.displayfieldmonto_neto.setValue("<span style='font-size:12px;'><b>Neto: </b>"+paqueteComunJS.funcion.getNumeroFormateado(monto_asignacion-monto_deduccion)+"</b></span>");
   
},getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/storelistaConcepto',
    root:'data',
    fields:[
                {name: 'co_partida'},
                {name :'co_detalle_compras'},
                {name :'tx_descripcion'},
                {name :'tx_partida'},
                {name :'de_partida'},
                {name :'mo_disponible'},
                {name :'nu_monto'},
                {name :'co_tipo_movimiento'},
                {name: 'tx_tipo_movimiento'}
           ]
    });
    return this.store;
},getListaDeducciones: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/storelistaDeducciones',
    root:'data',
    fields:[
                {name :'tx_descripcion'},
                {name :'nu_monto'},
                {name :'co_solicitud'}
           ]
    });
    return this.store;
},getListaAporte: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/storelistaAporte',
    root:'data',
    fields:[
                {name :'tx_descripcion'},
                {name :'nu_monto'},
                {name :'co_solicitud'}
           ]
    });
    return this.store;
}
,getStoreCO_TIPO_TRABAJADOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/storefkcotipotrabajador',
        root:'data',
        fields:[
            {name: 'co_tipo_trabajador'},
            {name: 'tx_tipo_trabajador'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_NOMINA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/storefkcotiponomina',
        root:'data',
        fields:[
            {name: 'co_tipo_nomina'},
            {name: 'tx_tipo_nomina'}
            ]
    });
    return this.store;
},
getStoreCO_EJECUTOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/storefkcoejecutor',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_ejecutor',
            convert:function(v,r){
            return r.de_ejecutor;
            }
            }
            ]
    });
    return this.store;
}
};
Ext.onReady(PagoNominaMasivoEditar.main.init, PagoNominaMasivoEditar.main);
</script>
