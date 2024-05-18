<script type="text/javascript">
Ext.ns("generarODPEditar");
generarODPEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_TIPO_TRABAJADOR = this.getStoreCO_TIPO_TRABAJADOR();
this.storeCO_EJECUTOR = this.getStoreCO_EJECUTOR();
this.storeCO_TIPO_ODP = this.getStoreCO_TIPO_ODP();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TIPO_NOMINA = this.getStoreCO_TIPO_NOMINA();
this.store_lista   = this.getLista();

this.co_detalle_compras  = '';
this.id_partida  = '';
this.monto  = '';
this.nu_partida  = '';
this.de_partida  = '';
this.co_tipo_movimiento = '';
this.co_presupuesto_movimiento = '';
this.tx_producto = '';
this.co_producto = ''

//<ClavePrimaria>
this.co_pago_nomina = new Ext.form.Hidden({
    name:'co_pago_nomina',
    value:this.OBJ.co_pago_nomina});
//</ClavePrimaria>

this.co_solicitud = new Ext.form.Hidden({
    name:'co_solicitud',
    value:this.OBJ.co_solicitud
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
 value:"<span style='font-size:12px;'><b>Monto Presupuesto: </b>0</b></span>"
});
this.displayfieldmonto_nomina = new Ext.form.DisplayField({
 value:"<span style='font-size:12px;'><b>Monto Nomina: </b>0</b></span>"
});

 

this.gridPanel = new Ext.grid.GridPanel({
        title:'Detalle del Concepto',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:500,
        width:950,
        //tbar:[this.agregar_partida],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_detalle_compras', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_detalle_compras'},    
            {header: 'co_solicitud', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_solicitud'},
            {header: 'Concepto',width:220, menuDisabled:true,dataIndex: 'tx_descripcion',renderer:textoLargo},
            {header: 'Cod. Partida', width:130, menuDisabled:true,dataIndex: 'tx_partida'},
            {header: 'Partida',width:220, menuDisabled:true,dataIndex: 'de_partida',renderer:textoLargo},
            {header: 'Monto Disponible',width:180, menuDisabled:true,dataIndex: 'mo_disponible',renderer:renderMontoDisponible},
            {header: 'Monto',width:180, menuDisabled:true,dataIndex: 'nu_monto',renderer:renderMonto}   
        ],
//        bbar: new Ext.ux.StatusBar({
//            autoScroll:true,
//            defaults:{style:'color:black;font-size:30px;',autoWidth:true},
//            items:[
//             this.displayfieldmonto_presupuesto,'-',
//             this.displayfieldmonto_nomina
//            ]
//        }),
        stripeRows: true,
        autoScroll:true,
        stateful: true
});


this.store_lista.baseParams.co_solicitud = this.OBJ.co_solicitud;
this.store_lista.load({ callback: function(){
                                generarODPEditar.main.getCalcular();
                        }});


this.co_tipo_odp = new Ext.form.ComboBox({
	fieldLabel:'Tipo',
	store: this.storeCO_TIPO_ODP,
	typeAhead: true,
	valueField: 'co_tipo_odp',
        id:'co_tipo_odp',
	displayField:'tx_tipo_odp',
	hiddenName:'co_tipo_odp',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:100,
	allowBlank:false
});


this.storeCO_TIPO_ODP.load({
    callback: function(){
        generarODPEditar.main.co_tipo_odp.setValue(generarODPEditar.main.OBJ.co_tipo_odp);
    }
});

this.field_tipo_odp = new Ext.form.FieldSet({
        title: 'Tipo de Orden de Pago',
        items:[this.co_tipo_odp]
});  

this.guardar = new Ext.Button({
    text:'Generar ODP',
    iconCls: 'icon-fin',
    handler:function(){

        if(!generarODPEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        generarODPEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/generarODPGenerico',
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

                 //generarODPEditar.main.winformPanel_.close();
                 if(action.result.co_odp!=''){
                    generarODPEditar.main.guardar.disable();
                 }
                 
                 generarODPEditar.main.store_lista.baseParams.co_solicitud = generarODPEditar.main.OBJ.co_solicitud;
                 generarODPEditar.main.store_lista.load();
             }
        });


    }
});

if(this.OBJ.co_odp != null){
    this.guardar.disable();
}

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        generarODPEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    fileUpload: true,
    frame:true,
    width:1000,
    autoHeight:true,
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.co_pago_nomina,
           this.co_solicitud,
           this.field_tipo_odp,
           this.gridPanel]
});

this.winformPanel_ = new Ext.Window({
    title:'Generar ODP',
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
    buttonAlign:'center'
});
this.winformPanel_.show();
//PagoNominaLista.main.mascara.hide();
},getCalcular: function(){
    var monto_presupuesto = paqueteComunJS.funcion.getSumaColumnaGrid({
                store:generarODPEditar.main.store_lista,
                campo:'mo_disponible'
    }); 


    var monto_nomina = paqueteComunJS.funcion.getSumaColumnaGrid({
            store:generarODPEditar.main.store_lista,
            campo:'monto'
    });

    generarODPEditar.main.displayfieldmonto_presupuesto.setValue("<span style='font-size:12px;'><b>Monto Presupuesto: </b>"+paqueteComunJS.funcion.getNumeroFormateado(monto_presupuesto)+"</b></span>");
    generarODPEditar.main.displayfieldmonto_nomina.setValue("<span style='font-size:12px;'><b>Monto Nomina: </b>"+paqueteComunJS.funcion.getNumeroFormateado(monto_nomina)+"</b></span>");
   
},getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/storelistaConceptoODP',
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
},getStoreCO_TIPO_ODP: function(){
     this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storefkcotipoodp',
        root:'data',
        fields:[
            {name: 'co_tipo_odp'},
            {name: 'tx_tipo_odp'}
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
Ext.onReady(generarODPEditar.main.init, generarODPEditar.main);
</script>
<div id="formularioAgregar"></div>