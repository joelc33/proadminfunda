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
this.storeCO_TIPO_NOMINA = this.getStoreCO_TIPO_NOMINA();
this.store_lista   = this.getLista();
this.store_lista_resumen   = PagoNominaMasivoEditar.main.getListaResumen();
this.storeCO_TIPO_ODP = this.getStoreCO_TIPO_ODP();

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

this.tx_concepto = new Ext.form.TextArea({
	fieldLabel:'Concepto',
	name:'tb132_pago_nomina_masivo[tx_concepto]',
	value:this.OBJ.tx_concepto,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;',
	width:730
});

this.fe_pago = new Ext.form.DateField({
	fieldLabel:'Fecha de Pago',
	name:'tb132_pago_nomina_masivo[fe_pago]',
	value:this.OBJ.fe_pago,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;',
	width:100
});

this.fieldPago = new Ext.form.FieldSet({
	title: 'Datos de la Nomina',
	items:[this.co_pago_nomina,
//                this.co_ejecutor,
                this.co_solicitud,
//                this.co_tipo_trabajador,
//                this.co_tipo_nomina,
                this.tx_concepto,
                this.fe_pago]
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


this.resumen= new Ext.Button({
    text:'Ver Resumen',
    iconCls: 'icon-buscar',
    handler:function(){	
	//ContabilidadEditar.main.mascara.show();
        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/verResumen',
            scripts: true,
            text: "Cargando..",
            params:{                
               co_compras: PagoNominaMasivoEditar.main.OBJ.co_compras,
            }
        });
    }
});

function renderPartidaAlerta(val, attr, record) { 
     if(parseFloat(record.data.mo_disponible) >= parseFloat(record.data.nu_monto)){
        return val;     
     }else{
        return '<p style="color:red"><b>'+val+'</b></p>';  
     }
}

this.gridPanel = new Ext.grid.GridPanel({
        title:'Detalle del Concepto',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:300,
        width:950,
        tbar:[this.resumen],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_detalle_compras', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_detalle_compras'},    
            {header: 'co_solicitud', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_solicitud'},
            {header: 'Concepto',width:300, menuDisabled:true,dataIndex: 'tx_descripcion',renderer:textoLargo},
            {header: 'Cod. Partida', width:130, menuDisabled:true,dataIndex: 'tx_partida',renderer:renderPartidaAlerta},
            {header: 'Partida',width:300, menuDisabled:true,dataIndex: 'de_partida',renderer:textoLargo},
           // {header: 'Monto Disponible',width:180, menuDisabled:true,dataIndex: 'mo_disponible',renderer:renderMontoDisponible},
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
                                PagoNominaMasivoEditar.main.getCalcular();
                        }});


this.guardar = new Ext.Button({
    text:'Generar ODP',
    iconCls: 'icon-fin',
    handler:function(){        
        Ext.MessageBox.confirm('Confirmación', '¿Esta seguro que desea generar la ODP?', function(boton){
	if(boton=="yes"){
             var flag = true;
             PagoNominaMasivoEditar.main.store_lista_resumen.baseParams.co_compra=PagoNominaMasivoEditar.main.OBJ.co_compras;
             PagoNominaMasivoEditar.main.store_lista_resumen.load({
                 callback: function(){
                   PagoNominaMasivoEditar.main.store_lista_resumen.each(function(record){
                            var    nu_partida;
                            var    de_partida;
                            var    mo_disponible;
                            var    monto;
                            var    monto_total;
                            var    id;

                            record.fields.each(function(field){
                                if(field.name=='id'){
                                    id = record.get(field.name);
                                }

                                if(field.name=='nu_partida'){
                                    nu_partida = record.get(field.name);
                                }

                                if(field.name=='de_partida'){
                                    de_partida = record.get(field.name);
                                }

                                if(field.name=='mo_disponible'){
                                    mo_disponible = record.get(field.name);
                                }

                                if(field.name=='monto'){
                                    monto = record.get(field.name);
                                }
                            });

                            monto_total = parseFloat(monto);

                            if(mo_disponible<monto_total){
                                flag = false;
                                Ext.MessageBox.alert('Error en transacción', "El monto de la partida <b>"+nu_partida+"-"+de_partida+"</b> es insuficiente, monto disponible "+mo_disponible+", monto precomprometido en la compra "+monto_total);
                                return false;
                            }
                        }, this);
                        
                        if(flag==true){
                         PagoNominaMasivoEditar.main.afectar_partida();
                        }
                 }
        });
        
        }
      })
    }
 });

if(this.OBJ.co_odp != null){
    this.guardar.disable();
}

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        PagoNominaMasivoEditar.main.winformPanel_.close();
    }
});


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
        PagoNominaMasivoEditar.main.co_tipo_odp.setValue(PagoNominaMasivoEditar.main.OBJ.co_tipo_odp);
    }
});

this.field_tipo_odp = new Ext.form.FieldSet({
        title: 'Tipo de Orden de Pago',
        items:[this.co_tipo_odp]
});   

this.formPanel_ = new Ext.form.FormPanel({
    fileUpload: true,
    frame:true,
    width:1000,
    autoHeight:true,
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.fieldPago,
           this.field_tipo_odp,
           this.gridPanel]
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
    buttonAlign:'center'
});
this.winformPanel_.show();
//PagoNominaLista.main.mascara.hide();
},afectar_partida: function(){

        if(!PagoNominaMasivoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        PagoNominaMasivoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/generarODP',
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
                 if(action.result.co_odp!=''){
                    PagoNominaMasivoEditar.main.guardar.disable();
                 }
                 
                 PagoNominaMasivoEditar.main.store_lista.baseParams.co_solicitud = PagoNominaMasivoEditar.main.OBJ.co_solicitud;
                 PagoNominaMasivoEditar.main.store_lista.load();
             }
        });

}
,getCalcular: function(){
    var monto_presupuesto = paqueteComunJS.funcion.getSumaColumnaGrid({
                store:PagoNominaMasivoEditar.main.store_lista,
                campo:'mo_disponible'
    }); 


    var monto_nomina = paqueteComunJS.funcion.getSumaColumnaGrid({
            store:PagoNominaMasivoEditar.main.store_lista,
            campo:'monto'
    });

    PagoNominaMasivoEditar.main.displayfieldmonto_presupuesto.setValue("<span style='font-size:12px;'><b>Monto Presupuesto: </b>"+paqueteComunJS.funcion.getNumeroFormateado(monto_presupuesto)+"</b></span>");
    PagoNominaMasivoEditar.main.displayfieldmonto_nomina.setValue("<span style='font-size:12px;'><b>Monto Nomina: </b>"+paqueteComunJS.funcion.getNumeroFormateado(monto_nomina)+"</b></span>");
   
},getListaResumen: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storelistaResumen',
    root:'data',
    fields:[
 
                {name :'nu_partida'},
                {name :'de_partida'},
                {name :'mo_disponible'},
                {name :'monto'},
                {name: 'id'}
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
<div id="formularioAgregar"></div>