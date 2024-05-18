<script type="text/javascript">
Ext.ns("listaFactura");
listaFactura.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.storeCO_IVA_FACTURA = this.getStoreCO_IVA_FACTURA();
this.storeDETALLE_RETENCION = this.getStoreDETALLE_RETENCION();
this.storeCO_IVA_RETENCION = this.getStoreCO_IVA_RETENCION();

this.co_proveedor = new Ext.form.Hidden({
    name:'tb045_factura[co_proveedor]',
    value:this.OBJ.co_proveedor
});

this.co_documento = new Ext.form.Hidden({
    name:'tb045_factura[co_documento]',
    value:this.OBJ.co_documento
});

this.co_ramo = new Ext.form.Hidden({
    name:'tb045_factura[co_ramo]',
    value:this.OBJ.co_ramo
});

this.co_iva_factura = new Ext.form.Hidden({
    name:'tb045_factura[co_iva_factura]',
    value:this.OBJ.co_iva_factura
});



this.nu_factura = new Ext.form.TextField({
	fieldLabel:'N° de Factura',
	name:'tb045_factura[nu_factura]',
	allowBlank:false,
	width:200
});

this.fe_emision = new Ext.form.DateField({
	fieldLabel:'Fecha Emision',
	name:'tb045_factura[fe_emision]',
	allowBlank:false,
	width:100
});

this.nu_base_imponible = new Ext.form.NumberField({
	fieldLabel:'Base Imponible',
	name:'tb045_factura[total_pagar]',
    //value:this.OBJ.nu_base_imponible,
	allowBlank:false,
	width:200,
    enableKeyEvents:true,
    allowNegative: false,
    enableKeyEvents:true,
	listeners:{
        keyup:function(field){

            listaFactura.main.storeDETALLE_RETENCION.load({
                params:{
                    nu_base_imponible: field.getValue(),
                    co_documento: listaFactura.main.co_documento.getValue(),
                    co_ramo: listaFactura.main.co_ramo.getValue(),
                    co_iva_factura:listaFactura.main.co_iva_factura.getValue(),
                    co_iva_retencion: listaFactura.main.co_iva_retencion.getRawValue(),
                    mo_exento: listaFactura.main.mo_exento.getValue(),
                    co_proveedor: listaFactura.main.co_proveedor.getValue()
                },
                callback: function(){
                    listaFactura.main.calcular_monto_factura();                    
                }
            }); 

        }
	}
});

this.nu_gravado_cs = new Ext.form.NumberField({
    fieldLabel:'Gravado CS',
    name:'tb045_factura[monto_gravado_cs]',
    //value:this.OBJ.nu_base_imponible,
    allowBlank:false,
    width:200,
    enableKeyEvents:true,
    allowNegative: false,
    value:0,
    listeners:{
        keyup:function(field){

             if(this.getValue() == ''){
                this.setValue(0); 
             }

             listaFactura.main.calcular_monto_factura();               
              
        }
    }
});

this.id_tb048_producto = new Ext.form.ComboBox({
	fieldLabel:'Tipo de Servicio',
	store: ServicioBasicoFacturaEditar.main.storeCO_PRODUCTO,
	typeAhead: true,
	valueField: 'co_producto',
	displayField:'producto',
	hiddenName:'tb045_factura[id_tb048_producto]',
	//readOnly:(this.OBJ.id_tb048_producto!='')?true:false,
	//style:(this.main.OBJ.id_tb048_producto!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Tipo de Servicio',
	selectOnFocus: true,
	mode: 'local',
	width:500,
	resizable:true,
	allowBlank:false
});

ServicioBasicoFacturaEditar.main.storeCO_PRODUCTO.load({
    params:{
        co_tipo_solicitud:listaFactura.main.OBJ.co_tipo_solicitud,
        co_documento:listaFactura.main.OBJ.co_documento
    }
});

this.tx_concepto = new Ext.form.TextArea({
	fieldLabel:'Descripcion del Pago',
	name:'tb045_factura[tx_concepto]',
	allowBlank:false,
	width:500,
    height:40,
});

this.nu_control = new Ext.form.TextField({
	fieldLabel:'N° de control',
	name:'tb045_factura[nu_control]',
        allowBlank:false,
	width:200
});

this.campoNumeroFC = new Ext.form.CompositeField({
        fieldLabel: 'N° de Factura',
        items: [
             this.nu_factura,
             {
                   xtype: 'displayfield',
                   value: '&nbsp;&nbsp;&nbsp; N° de control:',
                   width: 100
             },
             this.nu_control
        ]
});

this.co_iva_factura = new Ext.form.ComboBox({
	fieldLabel:'IVA',
	store: this.storeCO_IVA_FACTURA,
	typeAhead: true,
	valueField: 'nu_valor',
	displayField:'nu_valor',
	hiddenName:'co_iva_factura',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:50,
    value: this.OBJ.nu_iva,
    //readOnly:true,
	//style:'background:#c9c9c9;',
	resizable:true,
	allowBlank:false,
    listeners:{
        select: function(){
            listaFactura.main.storeDETALLE_RETENCION.load({
                params:{
                    nu_base_imponible: listaFactura.main.nu_base_imponible.getValue(),
                    co_documento: listaFactura.main.co_documento.getValue(),
                    co_ramo: listaFactura.main.co_ramo.getValue(),
                    co_iva_factura: this.getValue(),
                    co_iva_retencion: listaFactura.main.co_iva_retencion.getRawValue(),
                    mo_exento: listaFactura.main.mo_exento.getValue(),
                    co_proveedor: listaFactura.main.co_proveedor.getValue()
                },
                callback: function(){
                    listaFactura.main.calcular_monto_factura();                    
                }
            }); 
        }
    }
});
this.storeCO_IVA_FACTURA.load();

this.nu_iva_factura = new Ext.form.TextField({  
    name:'nu_iva_factura',
    allowBlank:false,
    width:450,
    readOnly:true,
    style:'background:#c9c9c9;'
});


this.co_iva_cs = new Ext.form.ComboBox({
    fieldLabel:'IVA',
    store: this.storeCO_IVA_FACTURA,
    typeAhead: true,
    valueField: 'nu_valor',
    displayField:'nu_valor',
    hiddenName:'co_iva_cs',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    selectOnFocus: true,
    mode: 'local',
    width:50,
    readOnly:true,
    style:'background:#c9c9c9;',
    resizable:true,
    allowBlank:false    
});

paqueteComunJS.funcion.seleccionarComboByCo({
    objCMB: this.co_iva_cs,
    value:  15,
    objStore: this.storeCO_IVA_RETENCION
});

this.nu_iva_cs= new Ext.form.TextField({	
	name:'nu_iva_cs',
	allowBlank:false,
	width:385,
    readOnly:true,
	style:'background:#c9c9c9;',
    value:0,
    allowNegative: false
});

this.compositefieldIVAFactura = new Ext.form.CompositeField({
fieldLabel: 'IVA',
width:485,
items: [
	this.co_iva_factura,
	this.nu_iva_factura
	]
});

this.compositefieldIVACS = new Ext.form.CompositeField({
fieldLabel: 'I.V.A.C.S',
width:485,
items: [
    this.co_iva_cs,
    this.nu_iva_cs
    ]
});

this.co_iva_retencion = new Ext.form.ComboBox({
	fieldLabel:'IVA',
	store: this.storeCO_IVA_RETENCION,
	typeAhead: true,
	valueField: 'co_iva_retencion',
	displayField:'nu_valor',
	hiddenName:'tb052_compras[co_iva_retencion]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
    readOnly:true,
	style:'background:#c9c9c9;',
	selectOnFocus: true,
	mode: 'local',
	width:50,
	resizable:true,
	allowBlank:false
});
this.storeCO_IVA_RETENCION.load();

paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_iva_retencion,
	value:  this.OBJ.co_iva_retencion,
	objStore: this.storeCO_IVA_RETENCION
});

this.nu_iva_retencion = new Ext.form.TextField({
	fieldLabel:'IVA',
	name:'nu_iva_retencion',
	allowBlank:false,
	width:385,
    readOnly:true,
	style:'background:#c9c9c9;'
});

this.compositefieldIVARetencion = new Ext.form.CompositeField({
fieldLabel: 'IVA',
width:500,
items: [
	this.co_iva_retencion,
	this.nu_iva_retencion
	]
});

this.fieldDatosRetencion= new Ext.form.FieldSet({
    title: 'Retención',
    width:600,
    items:[ 
        this.compositefieldIVARetencion,
        this.compositefieldIVACS
    ]
});

this.mo_exento = new Ext.form.NumberField({
    fieldLabel:'Monto Exento',
    name:'mo_exento',
    value:0,
    allowNegative: false,
    enableKeyEvents:true,
	listeners:{
        keyup:function(field){

            listaFactura.main.storeDETALLE_RETENCION.load({
                params:{
                    nu_base_imponible: field.getValue(),
                    co_documento: listaFactura.main.co_documento.getValue(),
                    co_ramo: listaFactura.main.co_ramo.getValue(),
                    co_iva_factura:listaFactura.main.co_iva_factura.getValue(),
                    co_iva_retencion: listaFactura.main.co_iva_retencion.getRawValue(),
                    mo_exento: listaFactura.main.mo_exento.getValue(),
                    co_proveedor: listaFactura.main.co_proveedor.getValue()
                },
                callback: function(){
                    listaFactura.main.calcular_monto_factura();                    
                }
            }); 

        }
	}    
});

this.nu_total = new Ext.form.TextField({
	fieldLabel:'Monto Total',
	name:'nu_total',
	allowBlank:false,
	width:500,
    readOnly:true,
	style:'background:#c9c9c9;'
});

this.total_pagar = new Ext.form.TextField({
	fieldLabel:'Total a Pagar',
	name:'nu_total_pagar',
	allowBlank:false,
	width:450,
    readOnly:true,
	style:'background:#c9c9c9;'
});

this.fieldDatosPagar= new Ext.form.FieldSet({
    title: 'Monto a Pagar',
    width:600,
    items:[ 
            this.total_pagar 
         ]
});

this.fieldDatos2 = new Ext.form.FieldSet({
    title: 'Datos de la Factura',
    items:[
        //this.nu_factura,
        //this.nu_control,
        this.campoNumeroFC,
        this.fe_emision,
        this.id_tb048_producto,
        this.nu_base_imponible,
        this.nu_gravado_cs,
        this.mo_exento,
        this.compositefieldIVAFactura,
        this.nu_total,
        this.fieldDatosRetencion,
        this.fieldDatosPagar,
        this.tx_concepto,
    ]
});

this.total_retencion = new Ext.form.DisplayField({
    value:"<span style='font-size:12px;'><b>Total Retención: </b>0,00</b></span>"
});

this.botonEliminar = new Ext.Button({
                text:'Eliminar Retención',
                iconCls: 'icon-eliminar',
                id:'eliminar',
                handler: function(boton){
                   listaFactura.main.eliminar();
                }
});

function renderMonto(val, attr, record) { 
     return paqueteComunJS.funcion.getNumeroFormateado(val);     
} 
    
this.gridPanel = new Ext.grid.GridPanel({
        title:'Detalle de Retención',
        store: this.storeDETALLE_RETENCION,
        loadMask:true,
        height:160,  
        width:778,
        tbar:[this.botonEliminar],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'Tipo de Retención',width:250, menuDisabled:true,dataIndex: 'tx_tipo_retencion'},                
            {header: 'Porcentaje', width:100, menuDisabled:true,dataIndex: 'po_deduccion'},
            {header: 'Monto',width:370, menuDisabled:true,dataIndex: 'nu_valor',renderer: renderMonto}          
        ],
        bbar: new Ext.ux.StatusBar({
            id: 'basic-statusbar_factura',
            autoScroll:true,
            defaults:{style:'color:black;font-size:30px;',autoWidth:true},
            items:[
             this.total_retencion
            ]
        }), 
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        listeners:{
            cellclick:function(Grid, rowIndex, columnIndex,e ){
                listaFactura.main.botonEliminar.enable();
            }
        }   
});


this.guardar = new Ext.Button({
    text:'Agregar',
    iconCls: 'icon-guardar',
    handler:function(){
        
        if(!listaFactura.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }

        var list_retencion = paqueteComunJS.funcion.getJsonByObjStore({
            store:listaFactura.main.gridPanel.getStore()
        });
        
        var e = new ServicioBasicoFacturaEditar.main.Registro({      
                    co_factura: '',
                    nu_factura:listaFactura.main.nu_factura.getValue(),
                    nu_control:listaFactura.main.nu_control.getValue(),
                    fe_emision:listaFactura.main.fe_emision.value,
                    tx_producto: listaFactura.main.id_tb048_producto.lastSelectionText,
                    co_producto: listaFactura.main.id_tb048_producto.getValue(),
                    nu_base_imponible:listaFactura.main.nu_base_imponible.getValue(),                 
                    tx_concepto:listaFactura.main.tx_concepto.getValue(),
                    nu_exento:listaFactura.main.mo_exento.getValue(), 
                    co_iva_factura:listaFactura.main.po_iva_factura,
                    nu_iva_factura:listaFactura.main.mo_iva_factura,                 
                    nu_total: listaFactura.main.mo_total,
                    co_iva_retencion:listaFactura.main.po_iva_retencion,
                    nu_iva_retencion:listaFactura.main.mo_iva_retencion,
                    nu_total_retencion:listaFactura.main.mo_retencion,
                    total_pagar:listaFactura.main.mo_total_pagar, 
                    nu_total_pagar:listaFactura.main.mo_total_pagar,
                    mo_iva_cs: listaFactura.main.monto_iva_cs,
                    co_iva_cs: listaFactura.main.co_iva_cs.getValue(),
                    sub_total_cs: listaFactura.main.nu_gravado_cs.getValue(),
                    json_detalle_retencion: list_retencion
        });

        var cant = ServicioBasicoFacturaEditar.main.store_lista.getCount();
         
        (cant == 0) ? 0 : ServicioBasicoFacturaEditar.main.store_lista.getCount() + 1;
      
    
        ServicioBasicoFacturaEditar.main.store_lista.insert(cant, e);
        ServicioBasicoFacturaEditar.main.gridPanel.getView().refresh();


        var nu_base_imponible = paqueteComunJS.funcion.getSumaColumnaGrid({
                 store:ServicioBasicoFacturaEditar.main.store_lista,
                 campo:'nu_base_imponible'
        });

        var nu_total_retencion = paqueteComunJS.funcion.getSumaColumnaGrid({
                 store:ServicioBasicoFacturaEditar.main.store_lista,
                 campo:'nu_total_retencion'
        });

       var total_pagar = paqueteComunJS.funcion.getSumaColumnaGrid({
                 store:ServicioBasicoFacturaEditar.main.store_lista,
                 campo:'total_pagar'
        });

        ServicioBasicoFacturaEditar.main.monto_imponible.setValue("<span style='font-size:12px;'><b>Base Imponible: </b>"+paqueteComunJS.funcion.getNumeroFormateado(nu_base_imponible )+"</b></span>");   
       
        ServicioBasicoFacturaEditar.main.monto_retencion.setValue("<span style='font-size:12px;'><b>Total Retenciones: </b>"+paqueteComunJS.funcion.getNumeroFormateado(nu_total_retencion)+"</b></span>");   
       
        ServicioBasicoFacturaEditar.main.monto_pagar.setValue("<span style='font-size:12px;'><b>Total Factura: </b>"+paqueteComunJS.funcion.getNumeroFormateado(total_pagar)+"</b></span>");  



        
        Ext.utiles.msg('Mensaje', "La Factura se agregó exitosamente");
        
        listaFactura.main.winformPanel_.close(); 
       
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        listaFactura.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
  //  frame:true,
    width:800,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
        this.fieldDatos2,
     //   this.gridPanel
    ]
});

this.winformPanel_ = new Ext.Window({
    title:'Agregar Factura',
    modal:true,
    constrain:true,
    width:810,
  //  frame:true,
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
},
eliminar:function(){
        var s = listaFactura.main.gridPanel.getSelectionModel().getSelections();
                      
        for(var i = 0, r; r = s[i]; i++){
              listaFactura.main.storeDETALLE_RETENCION.remove(r);
        }
        
        listaFactura.main.calcular_monto_factura(); 
        listaFactura.main.botonEliminar.disable();
        
},
getStoreDETALLE_RETENCION: function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Contabilidad/calculo',
        root:'data',
        fields:[
                {name: 'nu_valor'},
                {name: 'co_tipo_retencion'},
                {name: 'po_deduccion'},
                {name: 'tx_tipo_retencion'}
        ]
    });
    return this.store;    
},
calcular_monto_factura: function(){
                listaFactura.main.base_imp         = listaFactura.main.nu_base_imponible.getValue();
                listaFactura.main.po_iva_factura   = listaFactura.main.co_iva_factura.getValue();
                listaFactura.main.po_iva_retencion = listaFactura.main.co_iva_retencion.getRawValue();

                if(listaFactura.main.mo_exento.getValue()==''){
                    listaFactura.main.mo_exento.setValue(0);
                }


                listaFactura.main.monto_iva_cs   = listaFactura.main.nu_gravado_cs.getValue()*(listaFactura.main.co_iva_cs.getValue()/100);

                listaFactura.main.mo_total           = (listaFactura.main.base_imp+(listaFactura.main.base_imp)*(listaFactura.main.po_iva_factura/100))+listaFactura.main.mo_exento.getValue()+listaFactura.main.monto_iva_cs;
                listaFactura.main.mo_iva_factura     = (listaFactura.main.base_imp)*(listaFactura.main.po_iva_factura/100);
                listaFactura.main.mo_iva_retencion   = listaFactura.main.mo_iva_factura*(listaFactura.main.po_iva_retencion/100);

                listaFactura.main.monto_iva_cs   = listaFactura.main.nu_gravado_cs.getValue()*(listaFactura.main.co_iva_cs.getValue()/100);
            

               // alert(listaFactura.main.monto_iva_cs);

                listaFactura.main.mo_retencion = paqueteComunJS.funcion.getSumaColumnaGrid({
                    store:listaFactura.main.storeDETALLE_RETENCION,
                    campo:'nu_valor'
                });
                               
                listaFactura.main.mo_retencion    =   parseFloat(listaFactura.main.mo_retencion)+parseFloat(listaFactura.main.mo_iva_retencion)+parseFloat(listaFactura.main.monto_iva_cs);        


                listaFactura.main.mo_total_pagar = listaFactura.main.mo_total-listaFactura.main.mo_retencion;
                
                listaFactura.main.nu_total.setValue(paqueteComunJS.funcion.getNumeroFormateado(listaFactura.main.mo_total));
                listaFactura.main.nu_iva_factura.setValue(paqueteComunJS.funcion.getNumeroFormateado(listaFactura.main.mo_iva_factura));
                listaFactura.main.nu_iva_retencion.setValue(paqueteComunJS.funcion.getNumeroFormateado(listaFactura.main.mo_iva_retencion));
                listaFactura.main.total_pagar.setValue(paqueteComunJS.funcion.getNumeroFormateado(listaFactura.main.mo_total_pagar));
                listaFactura.main.nu_iva_cs.setValue(paqueteComunJS.funcion.getNumeroFormateado(listaFactura.main.monto_iva_cs));
                
                listaFactura.main.total_retencion.setValue("<span style='font-size:12px;'><b>Total Retención: </b>"+paqueteComunJS.funcion.getNumeroFormateado(listaFactura.main.mo_retencion)+"</b></span>");     

},
getStoreCO_IVA_RETENCION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ServicioBasicoFactura/storefkcoivaretencion',
        root:'data',
        fields:[
            {name: 'co_iva_retencion'},
            {name: 'nu_valor'}
            ]
    });
    return this.store;
},
getStoreCO_IVA_FACTURA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/storefkcoivafactura',
        root:'data',
        fields:[
            {name: 'co_iva_factura'},
            {name: 'nu_valor'}
            ]
    });
    return this.store;
}
};
Ext.onReady(listaFactura.main.init, listaFactura.main);
</script>
<div id="formularioProducto"></div>
