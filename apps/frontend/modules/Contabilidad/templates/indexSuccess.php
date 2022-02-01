<script type="text/javascript">
Ext.ns("ContabilidadEditar");
ContabilidadEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.storeCO_RAMO = this.getStoreCO_RAMO();
 
this.detalle_factura = '';
this.monto_total = 0;
this.monto_total_factura = 0;

this.co_compra = new Ext.form.Hidden({
    name:'co_compra',
    value:this.OBJ.co_compras
});

this.co_proveedor = new Ext.form.Hidden({
    name:'co_proveedor',
    value:this.OBJ.co_proveedor
});

this.co_solicitud = new Ext.form.Hidden({
    name:'co_solicitud',
    value:this.OBJ.co_solicitud
});


this.co_documento = new Ext.form.Hidden({
    name:'co_documento',
    value:this.OBJ.co_documento
});

/*this.co_ramo = new Ext.form.Hidden({
    name:'co_ramo',
    value:this.OBJ.co_ramo
});*/
//</ClavePrimaria>

this.store_lista      = this.getLista();
this.store_lista_otra = this.getListaOtra();


this.Registro = Ext.data.Record.create([
         {name: 'nu_factura', type: 'number'},
         {name: 'nu_control', type: 'number'},
         {name: 'fe_emision', type: 'string'},
         {name: 'nu_base_imponible', type:'number'},
         {name: 'co_iva_factura', type:'number'},
         {name: 'nu_iva_factura', type: 'number'},                 
         {name: 'nu_total', type:'number'},
         {name: 'co_iva_retencion', type: 'number'},
         {name: 'nu_iva_retencion', type: 'number'},
         {name: 'nu_total_retencion', type:'number'},
         {name: 'total_pagar', type:'number'},   
         {name: 'nu_total_pagar', type:'number'},
         {name: 'tx_concepto', type:'number'},
         {name: 'json_detalle_retencion', type:'string'}
]);

this.hiddenJsonFactura  = new Ext.form.Hidden({
        name:'json_factura',
        value:''
});


this.agregar = new Ext.Button({
    text: 'Agregar',
    iconCls: 'icon-nuevo',
    handler: function () {

        if(!ContabilidadEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }

        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/agregarFactura',
            scripts: true,
            text: "Cargando..",
            params:{
                co_documento: ContabilidadEditar.main.OBJ.co_documento,
                nu_iva_retencion: ContabilidadEditar.main.OBJ.nu_iva_retencion,
                //co_ramo: ContabilidadEditar.main.OBJ.co_ramo,
                co_ramo: ContabilidadEditar.main.co_ramo.getValue(),
                nu_iva:ContabilidadEditar.main.OBJ.nu_iva,
                co_solicitud: ContabilidadEditar.main.OBJ.co_solicitud_cotizacion,
                co_proveedor: ContabilidadEditar.main.OBJ.co_proveedor
            }
        });
    }
});

this.ver_detalle = new Ext.Button({
    text: 'Ver Detalle',
    iconCls: 'icon-buscar',
    handler: function () {
        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/verDetalle',
            scripts: true,
            text: "Cargando.."
        });
    }
});

this.botonEliminar = new Ext.Button({
                text:'Eliminar',
                iconCls: 'icon-eliminar',
                handler: function(){
                    ContabilidadEditar.main.eliminar();
                }
});

this.botonEliminar.disable();
this.ver_detalle.disable();

this.monto_total = new Ext.form.DisplayField({
 value:"<span style='font-size:12px;'><b>|  Total a Pagar: </b>0,00</b></span>"
});

this.monto_total_compra = new Ext.form.DisplayField({
 value:"<span style='font-size:12px;'><b>Monto Total: </b>0,00</b></span>"
});

function renderMonto(val, attr, record) { 
     return paqueteComunJS.funcion.getNumeroFormateado(val);     
} 

this.nu_orden_pago = new Ext.form.TextField({
	fieldLabel:'Número Orden',
	name:'nu_orden_pago',
	value:this.OBJ.nu_orden_pago,
	width:200
});

this.fieldDatosPreImpresa= new Ext.form.FieldSet({
        title: 'Número de Orden de Pago Pre-Impresa',
        items:[this.nu_orden_pago]
});


this.gridPanel = new Ext.grid.GridPanel({
        title:'Lista de Facturas',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:200,  
        width:810,
        tbar:[this.agregar,'-',this.botonEliminar],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_factura', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_factura'},    
            {header: 'N° Factura',width:100, menuDisabled:true,dataIndex: 'nu_factura'},                
            {header: 'Fecha Emisión', width:100, menuDisabled:true,dataIndex: 'fe_emision'},
            {header: 'Base Imponible',width:180, menuDisabled:true,dataIndex: 'nu_base_imponible',renderer:renderMonto},
            {header: 'Total Retenciones',width:180, menuDisabled:true,dataIndex: 'nu_total_retencion',renderer:renderMonto},
            {header: 'Total Factura',width:180, menuDisabled:true,dataIndex: 'total_pagar',renderer:renderMonto}
        ], 
        bbar: new Ext.ux.StatusBar({
            id: 'basic-statusbar',
            autoScroll:true,
            defaults:{style:'color:black;font-size:30px;',autoWidth:true},
            items:[
             this.monto_total_compra,'-',this.monto_total
            ]
        }),
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
                
            if(ContabilidadEditar.main.store_lista.getAt(rowIndex).get('estatus')==true){
                ContabilidadEditar.main.botonEliminar.disable();
            }else{
                ContabilidadEditar.main.botonEliminar.enable();
            }               
       
        }}   
});

if(this.OBJ.co_compras!=''){

    

    ContabilidadEditar.main.store_lista.baseParams.co_compra=this.OBJ.co_compras;    
    ContabilidadEditar.main.store_lista.baseParams.co_solicitud=this.OBJ.co_solicitud;
    this.store_lista.load({
        callback: function(){
           ContabilidadEditar.main.calcularMonto();
        }
    });

    ContabilidadEditar.main.store_lista_otra.baseParams.co_compra=this.OBJ.co_compras;
    ContabilidadEditar.main.store_lista_otra.baseParams.co_solicitud=this.OBJ.co_solicitud;
    this.store_lista_otra.load({
        callback: function(){
           ContabilidadEditar.main.calcularMonto();
        }
    });

}

this.co_ramo = new Ext.form.ComboBox({
	fieldLabel:'Ramo',
	store: this.storeCO_RAMO,
	typeAhead: true,
	valueField: 'co_ramo',
	displayField:'tx_ramo',
	hiddenName:'tb052_compras[co_ramo]',
	forceSelection:true,
	resizable:true,
    //readOnly:(this.OBJ.co_factura!='')?true:false,
	//style:(this.OBJ.co_factura!='')?'background:#c9c9c9;':'',
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:600,
	allowBlank:false,
        listeners: {
          getSelectedIndex: function() {
            var v = this.getValue();
            var r = this.findRecord(this.valueField || this.displayField, v);
            return(this.storeCO_RAMO.indexOf(r));
          }
}

});


this.fieldDatosRamo= new Ext.form.FieldSet({
        title: 'Ramo del Proveedor',
        items:[this.co_ramo]
});

if(this.OBJ.co_proveedor!=''){
    this.storeCO_RAMO.load({
    params: {
            co_proveedor:this.OBJ.co_proveedor
        },
        callback: function(){
            ContabilidadEditar.main.co_ramo.setValue(ContabilidadEditar.main.OBJ.co_ramo);
        }
    });
}


this.gridPanelValuaciones = new Ext.grid.GridPanel({
        title:'Lista de Valuaciones Cargardas para la Obra',
        iconCls: 'icon-libro',
        store: this.store_lista_otra,
        loadMask:true,
        height:150,  
        width:810,
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_factura', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_factura'},    
            {header: 'N° Factura',width:100, menuDisabled:true,dataIndex: 'nu_factura'},                
            {header: 'Fecha Emisión', width:100, menuDisabled:true,dataIndex: 'fe_emision'},
            {header: 'Base Imponible',width:180, menuDisabled:true,dataIndex: 'nu_base_imponible',renderer:renderMonto},
            {header: 'Total Retenciones',width:180, menuDisabled:true,dataIndex: 'nu_total_retencion',renderer:renderMonto},
            {header: 'Total Factura',width:180, menuDisabled:true,dataIndex: 'total_pagar',renderer:renderMonto}
        ], 
        stripeRows: true,
        autoScroll:true,
        stateful: true,
       
});


this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ContabilidadEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
      
        if(parseFloat(ContabilidadEditar.main.monto_total_factura)>parseFloat(ContabilidadEditar.main.OBJ.monto)){
             Ext.MessageBox.confirm('Confirmación', 'El total de la factura debe ser igual al monto previsto, ¿Desea Continuar?', function(boton){
                if(boton=="yes"){
                    ContabilidadEditar.main.setGuardar();
                }
             });
        }else{
            ContabilidadEditar.main.setGuardar();
        }   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ContabilidadEditar.main.winformPanel_.close();
    }
});

this.co_solicitud_compra = new Ext.form.TextField({
    fieldLabel:'Solicitud',
    name:'tb052_compras[co_solicitud_compra]',
    value:this.OBJ.co_solicitud_compra,
    allowBlank:false,
    width:100,
    readOnly:true,
    style:'background:#c9c9c9;',
});

this.buscar = new Ext.Button({
    text:'Buscar',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cotizacion/buscarCompra',
            scripts: true,
            text: "Cargando.."
        });
    }
});

this.tx_concepto = new Ext.form.TextArea({
    fieldLabel:'Concepto',
    name:'tb052_compras[tx_concepto]',
    value:this.OBJ.tx_concepto,
    allowBlank:false,
    width:600,
    readOnly:true,
    style:'background:#c9c9c9;'
});

this.tx_rif = new Ext.form.TextField({
    fieldLabel:'Rif',
    name:'tb052_compras[tx_rif]',
    value:this.OBJ.tx_rif,
    allowBlank:false,
    width:200,
    readOnly:true,
    style:'background:#c9c9c9;'
});


this.tx_razon_social = new Ext.form.TextField({
    fieldLabel:'Razón Social',
    name:'tb052_compras[tx_razon_social]',
    value:this.OBJ.tx_razon_social,
    allowBlank:false,
    width:600,
    readOnly:true,
    style:'background:#c9c9c9;'
});

this.compositefieldPresupuestoBase = new Ext.form.CompositeField({
fieldLabel: 'Solicitud',
width:190,
items: [
        this.co_solicitud_compra,
        this.buscar
    ]
});


this.fieldPresupuesto= new Ext.form.FieldSet({
        title: 'Datos de la Obra',
        items:[   
          this.compositefieldPresupuestoBase,
          this.tx_rif,
          this.tx_razon_social,
          this.tx_concepto
       ]
});


this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    //width:850,
    autoWidth:true,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[         this.co_compra,
                    this.co_proveedor,
                    this.co_documento,
                    //this.co_ramo,
                    this.co_solicitud,
                    this.fieldPresupuesto,
                    this.hiddenJsonFactura,
                    //this.fieldDatos,
                  //  this.fieldDatosContrato,
                    this.fieldDatosRamo,
//                    this.fieldDatosPreImpresa,
                    this.gridPanelValuaciones,
                    this.gridPanel
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Contabilidad',
    modal:true,
    constrain:true,
    width:850,
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
},
setGuardar: function(){
    
        ContabilidadEditar.main.monto_total_factura = paqueteComunJS.funcion.getSumaColumnaGrid({
                 store:ContabilidadEditar.main.store_lista,
                 campo:'nu_total'
        });
    
        var list_factura = paqueteComunJS.funcion.getJsonByObjStore({
                store:ContabilidadEditar.main.gridPanel.getStore()
        });
        
        ContabilidadEditar.main.hiddenJsonFactura.setValue(list_factura);        
        
        ContabilidadEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/guardar',
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
                 
              
                Detalle.main.store_lista.load();
                
                ContabilidadEditar.main.winformPanel_.close();
             }
        });
},
calcularMonto: function(){
            ContabilidadEditar.main.total_pagar = paqueteComunJS.funcion.getSumaColumnaGrid({
                 store:ContabilidadEditar.main.store_lista,
                 campo:'total_pagar'
            });
            
            ContabilidadEditar.main.monto_total_factura = paqueteComunJS.funcion.getSumaColumnaGrid({
                 store:ContabilidadEditar.main.store_lista,
                 campo:'nu_total'
            });
            
            ContabilidadEditar.main.monto_total_compra.setValue("<span style='font-size:12px;'><b>Monto Total: </b>"+paqueteComunJS.funcion.getNumeroFormateado(ContabilidadEditar.main.monto_total_factura)+"</b></span>");     
            ContabilidadEditar.main.monto_total.setValue("<span style='font-size:12px;'><b>|  Total a Pagar: </b>"+paqueteComunJS.funcion.getNumeroFormateado(ContabilidadEditar.main.total_pagar)+"</b></span>");     

},
eliminar:function(){
        var s = ContabilidadEditar.main.gridPanel.getSelectionModel().getSelections();
        
        var co_factura = ContabilidadEditar.main.gridPanel.getSelectionModel().getSelected().get('co_factura');
       
        if(co_factura!=''){
            
            Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/eliminarFactura',
            params:{
                co_factura: co_factura,
                co_solicitud: ContabilidadEditar.main.OBJ.co_solicitud
            },
            success:function(result, request ) {
               ContabilidadEditar.main.store_lista.load();
               ContabilidadEditar.main.calcularMonto();
            }});
            
        }
        
        
       
        for(var i = 0, r; r = s[i]; i++){
              ContabilidadEditar.main.store_lista.remove(r);
        }
        
},getLista: function(){

    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/storelista',
    root:'data',
    fields:[
                {name :'co_factura'},
                {name :'nu_factura'},
                {name :'fe_emision'},
                {name :'nu_base_imponible'},
                {name :'co_iva_factura'},
                {name :'nu_iva_factura'},
                {name :'nu_total'},
                {name :'co_iva_retencion'},
                {name :'nu_iva_retencion'},
                {name :'nu_total_pagar'},
                {name :'nu_total_retencion'},
                {name :'total_pagar'},
                {name :'tx_concepto'},
                {name :'co_compra'},
                {name :'co_solicitud'},
                {name: 'estatus'}
           ]
    });
    return this.store;      
},getListaOtra: function(){

    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/storelistaotra',
    root:'data',
    fields:[
                {name :'co_factura'},
                {name :'nu_factura'},
                {name :'fe_emision'},
                {name :'nu_base_imponible'},
                {name :'co_iva_factura'},
                {name :'nu_iva_factura'},
                {name :'nu_total'},
                {name :'co_iva_retencion'},
                {name :'nu_iva_retencion'},
                {name :'nu_total_pagar'},
                {name :'nu_total_retencion'},
                {name :'total_pagar'},
                {name :'tx_concepto'},
                {name :'co_compra'},
                {name :'co_solicitud'},
                {name: 'estatus'}
           ]
    });
    return this.store;      
},
getStoreCO_RAMO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoramo',
        root:'data',
        fields:[
            {name: 'co_ramo'},
            {name: 'tx_ramo'}
            ]
    });
    return this.store;
}
};
Ext.onReady(ContabilidadEditar.main.init, ContabilidadEditar.main);
</script>
<div id="formularioAgregar"></div>