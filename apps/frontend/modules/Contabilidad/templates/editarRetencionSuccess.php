<script type="text/javascript">
Ext.ns("ContabilidadEditar");
ContabilidadEditar.main = {
init:function(){
    
this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
this.storeCO_RAMO = this.getStoreCO_RAMO();
this.storeCO_IVA_FACTURA = this.getStoreCO_IVA_FACTURA();
this.store_lista_requisicion   = this.getListaRequisicion();

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
 
this.detalle_factura = '';
this.monto_total = 0;

this.co_compra = new Ext.form.Hidden({
    name:'co_compra',
    value:this.OBJ.co_compras
});

this.co_solicitud = new Ext.form.Hidden({
    name:'co_solicitud',
    value:this.OBJ.co_solicitud
});

this.co_proveedor  = new Ext.form.Hidden({
        name:'co_proveedor',
        value:this.OBJ.co_proveedor
});


this.nu_iva_retencion = new Ext.form.Hidden({
    name:'nu_iva_retencion',
    value:this.OBJ.nu_iva_retencion
});

this.co_iva_retencion = new Ext.form.Hidden({
    name:'co_iva_retencion',
    value:this.OBJ.co_iva_retencion
});

this.co_iva_factura = new Ext.form.Hidden({
    name:'co_iva_factura'
});


/*
this.co_ramo = new Ext.form.Hidden({
    name:'co_ramo',
    value:this.OBJ.co_ramo
});*/
//</ClavePrimaria>

this.store_lista = this.getLista();


this.Registro = Ext.data.Record.create([
         {name: 'nu_factura', type: 'number'},
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
        this.msg = Ext.get('formularioAgregar');
        
        if(ContabilidadEditar.main.co_proveedor.getValue()==''){           
            Ext.MessageBox.alert('Notificación', "Para realizar el calculo de retención, debe indicar un proveedor");
            return;
        }
        
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/agregarFacturaRetencionExpress',
            scripts: true,
            text: "Cargando..",
            params:{
                co_documento: ContabilidadEditar.main.co_documento.getValue(),
                nu_iva_retencion: ContabilidadEditar.main.nu_iva_retencion.getValue(),
                co_ramo: ContabilidadEditar.main.co_ramo.getValue(),
                nu_iva:ContabilidadEditar.main.co_iva.lastSelectionText
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
 value:"<span style='font-size:12px;'><b>Total a Pagar: </b>0,00</b></span>"
});

function renderMonto(val, attr, record) { 
     return paqueteComunJS.funcion.getNumeroFormateado(val);     
} 

this.gridPanel = new Ext.grid.GridPanel({
        title:'Lista de Retenciones',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:200,  
        width:810,
        tbar:[this.agregar,'-',this.botonEliminar],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_factura', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_factura'},    
//            {header: 'N° Factura',width:100, menuDisabled:true,dataIndex: 'nu_factura'},                
//            {header: 'Fecha Emisión', width:100, menuDisabled:true,dataIndex: 'fe_emision'},
            {header: 'Base Imponible',width:250, menuDisabled:true,dataIndex: 'nu_base_imponible',renderer:renderMonto},
            {header: 'Total Retenciones',width:200, menuDisabled:true,dataIndex: 'nu_total_retencion',renderer:renderMonto},
            {header: 'Total Factura',width:250, menuDisabled:true,dataIndex: 'total_pagar',renderer:renderMonto}
        ], 
        bbar: new Ext.ux.StatusBar({
            id: 'basic-statusbar',
            autoScroll:true,
            defaults:{style:'color:black;font-size:30px;',autoWidth:true},
            items:[
             this.monto_total
            ]
        }),
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){           
            ContabilidadEditar.main.botonEliminar.enable();
         //   ContabilidadEditar.main.ver_detalle.enable();
         //   ContabilidadEditar.main.detalle_factura =  ContabilidadEditar.main.store_lista.getAt(rowIndex)
        }}   
});

this.gridPanelRequisicion = new Ext.grid.GridPanel({
        title:'Datos de la Requisición',
        iconCls: 'icon-libro',
        store: this.store_lista_requisicion,
        loadMask:true,
        height:150,  
        width:810,
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_detalle_requisicion', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_detalle_requisicion'},    
            {header: 'co_producto', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_producto'},                
            {header: 'Codigo', width:80, menuDisabled:true,dataIndex: 'cod_producto'},
            {header: 'Descripción',width:520, menuDisabled:true,dataIndex: 'tx_producto'},
            {header: 'Unidad',width:80, menuDisabled:true,dataIndex: 'tx_unidad_producto'},
            {header: 'Cantidad',width:80, menuDisabled:true,dataIndex: 'nu_cantidad'}
        ]
});


if(this.OBJ.co_solicitud!=''){

    ContabilidadEditar.main.store_lista.baseParams.co_solicitud=this.OBJ.co_solicitud;
    this.store_lista.load({
        callback: function(){
            ContabilidadEditar.main.total_pagar = paqueteComunJS.funcion.getSumaColumnaGrid({
                 store:ContabilidadEditar.main.store_lista,
                 campo:'total_pagar'
            });
            
             ContabilidadEditar.main.monto_total.setValue("<span style='font-size:12px;'><b>Total a Pagar: </b>"+paqueteComunJS.funcion.getNumeroFormateado(ContabilidadEditar.main.total_pagar)+"</b></span>");     
        }
    });

}

this.co_documento = new Ext.form.ComboBox({
	fieldLabel:'Co documento',
	store: this.storeCO_DOCUMENTO,
	typeAhead: true,
	valueField: 'co_documento',
	displayField:'inicial',
	hiddenName:'tb008_proveedor[co_documento]',
        id:'co_documento',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
        readOnly:(this.OBJ.co_documento!='')?true:false,
	style:(this.OBJ.co_documento!='')?'background:#c9c9c9;':'',
	mode: 'local',
	width:50,
	allowBlank:false
});
this.storeCO_DOCUMENTO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_documento,
	value:  (this.OBJ.co_documento=='')?4:this.OBJ.co_documento,
	objStore: this.storeCO_DOCUMENTO
});

this.tx_rif = new Ext.form.TextField({
	name:'tb008_proveedor[tx_rif]',
	value:this.OBJ.tx_rif,
        id:'tx_rif',
	allowBlank:false,
        readOnly:(this.OBJ.tx_rif!='')?true:false,
	style:(this.OBJ.tx_rif!='')?'background:#c9c9c9;':'',
	width:130
});
this.co_documento.on("blur",function(){
    if(ContabilidadEditar.main.tx_rif.getValue()!=''){
    ContabilidadEditar.main.verificarProveedor();
    }
});

this.tx_rif.on("blur",function(){
    ContabilidadEditar.main.verificarProveedor();
});

this.compositefieldCIRIF = new Ext.form.CompositeField({
fieldLabel: 'Cedula/Rif',
width:185,
items: [
	this.co_documento,
	this.tx_rif,
	]
});

this.tx_razon_social = new Ext.form.TextField({
	fieldLabel:'Razon Social',
	name:'tx_razon_social',
        id:'tx_razon_social',
	value:this.OBJ.tx_razon_social,
	allowBlank:false,
        readOnly:(this.OBJ.tx_razon_social!='')?true:false,
	style:(this.OBJ.tx_razon_social!='')?'background:#c9c9c9;':'',
        readOnly:true,
	style:'background:#c9c9c9;',
	width:650
});

this.co_ramo = new Ext.form.ComboBox({
	fieldLabel:'Ramo',
	store: this.storeCO_RAMO,
	typeAhead: true,
	valueField: 'co_ramo',
	displayField:'tx_ramo',
        id:'co_ramo',
	hiddenName:'co_ramo',
	forceSelection:true,
	resizable:true,        
	readOnly:(this.OBJ.co_ramo!='')?true:false,
	style:(this.OBJ.co_ramo!='')?'background:#c9c9c9;':'',
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:415,
	allowBlank:false,
        listeners: {
          getSelectedIndex: function() {
            var v = this.getValue();
            var r = this.findRecord(this.valueField || this.displayField, v);
            return(this.storeCO_RAMO.indexOf(r));
          }
}

});

if(this.OBJ.co_proveedor!=''){
this.storeCO_RAMO.load({
params: {co_proveedor:this.OBJ.co_proveedor
        }
 });
}

paqueteComunJS.funcion.seleccionarComboByCo({
objCMB: this.co_ramo,
value: this.OBJ.co_ramo,
objStore: this.storeCO_RAMO
});


this.co_iva = new Ext.form.ComboBox({
	fieldLabel:'IVA',
	store: this.storeCO_IVA_FACTURA,
	typeAhead: true,
	valueField: 'co_iva_factura',
	displayField:'nu_valor',
        id:'co_iva',
	hiddenName:'co_iva',
	forceSelection:true,
	resizable:true,
        readOnly:(this.OBJ.co_iva!='')?true:false,
	style:(this.OBJ.co_iva!='')?'background:#c9c9c9;':'',
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:50,
	allowBlank:false
});
this.storeCO_IVA_FACTURA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_iva,
	value:  this.OBJ.co_iva,
	objStore: this.storeCO_IVA_FACTURA
});


/*
this.datos  = '<p class="registro_detalle"><b>RIF: </b>'+this.OBJ.tipo+'-'+this.OBJ.tx_rif+'</p>';
this.datos += '<p class="registro_detalle"><b>Razón Social: </b>'+this.OBJ.tx_razon_social+'</p>';
this.datos +='<p class="registro_detalle"><b>Dirección: </b>'+this.OBJ.tx_direccion+'</p>';
*/
   
this.fieldDatos= new Ext.form.FieldSet({
        title: 'Datos del Proveedor',
        items:[
            this.compositefieldCIRIF,
            this.tx_razon_social,
            this.co_ramo,
            this.co_iva,
            this.co_iva_factura
        ]
});



this.tx_concepto = new Ext.form.TextField({
	fieldLabel:'Concepto',
	name:'tb039_requisiciones[tx_concepto]',
	value:this.OBJ.tx_concepto,
	allowBlank:false,
	width:680
});

this.tx_observacion = new Ext.form.TextArea({
	fieldLabel:'Observaciones',
	name:'tb039_requisiciones[tx_observacion]',
	value:this.OBJ.tx_observacion,
	width:680
});

this.fieldDatosRequisicion= new Ext.form.FieldSet({
    items:[this.tx_concepto,
           this.tx_observacion]
});
            

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ContabilidadEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        
        
        if(parseFloat(ContabilidadEditar.main.total_pagar)>=parseFloat(ContabilidadEditar.main.OBJ.monto)){
            Ext.Msg.alert("Alerta","El total de la factura debe ser menor o igual al monto previsto.");
            return false;
        }
        
        var list_factura = paqueteComunJS.funcion.getJsonByObjStore({
                store:ContabilidadEditar.main.gridPanel.getStore()
        });
        
        ContabilidadEditar.main.hiddenJsonFactura.setValue(list_factura);
        ContabilidadEditar.main.co_iva_factura.setValue(ContabilidadEditar.main.co_iva.lastSelectionText);
        
        
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
                
                 ContabilidadEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ContabilidadEditar.main.winformPanel_.close();
    }
});

this.panelRequisicion = new Ext.form.FieldSet({
  items:[this.gridPanelRequisicion]
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:850,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[         this.co_compra, 
                    this.co_iva_retencion,
                    this.co_proveedor,
                    this.co_solicitud,
                    this.hiddenJsonFactura,
                    this.fieldDatos,
                    this.panelRequisicion,
                    this.gridPanel
            ]
});

ContabilidadEditar.main.store_lista_requisicion.baseParams.co_solicitud=this.OBJ.co_solicitud;
this.store_lista_requisicion.load();

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
            }});
            
        }
       
        for(var i = 0, r; r = s[i]; i++){
              ContabilidadEditar.main.store_lista.remove(r);
        }
        
        
         ContabilidadEditar.main.total_pagar = paqueteComunJS.funcion.getSumaColumnaGrid({
                     store:ContabilidadEditar.main.store_lista,
                     campo:'nu_total_pagar'
        });
        
        
        if(parseFloat(ContabilidadEditar.main.total_pagar)>0){
            Ext.get('tx_rif').setStyle('background-color','#c9c9c9');
            ContabilidadEditar.main.tx_rif.setReadOnly(true);
            Ext.get('tx_razon_social').setStyle('background-color','#c9c9c9');
            ContabilidadEditar.main.tx_razon_social.setReadOnly(true);
            Ext.get('co_ramo').setStyle('background-color','#c9c9c9');
            ContabilidadEditar.main.co_ramo.setReadOnly(true);
            Ext.get('co_documento').setStyle('background-color','#c9c9c9');
            ContabilidadEditar.main.co_documento.setReadOnly(true);
            Ext.get('co_iva').setStyle('background-color','#c9c9c9');
            ContabilidadEditar.main.co_iva.setReadOnly(true);

        }else{
        
            
        
            Ext.get('tx_rif').setStyle('background-color','#FFFFFF');
            ContabilidadEditar.main.tx_rif.setReadOnly(false);
            Ext.get('tx_razon_social').setStyle('background-color','#FFFFFF');
            ContabilidadEditar.main.tx_razon_social.setReadOnly(false);
            Ext.get('co_ramo').setStyle('background-color','#FFFFFF');
            ContabilidadEditar.main.co_ramo.setReadOnly(false);
            Ext.get('co_documento').setStyle('background-color','#FFFFFF');
            ContabilidadEditar.main.co_documento.setReadOnly(false);
            Ext.get('co_iva').setStyle('background-color','#FFFFFF');
            ContabilidadEditar.main.co_iva.setReadOnly(false);
            
            
        }
        
        
        //104800
        
},getStoreCO_DOCUMENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcodocumento',
        root:'data',
        fields:[
            {name: 'co_documento'},
            {name: 'inicial'}
            ]
    });
    return this.store;
}
,getStoreCO_RAMO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoramo',
        root:'data',
        fields:[
            {name: 'co_ramo'},
            {name: 'tx_ramo'}
            ]
    });
    return this.store;
},
getStoreCO_IVA_FACTURA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoivafactura',
        root:'data',
        fields:[
            {name: 'nu_valor'},
            {name: 'co_iva_factura'}
            ]
    });
    return this.store;
},
getLista: function(){

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
                {name :'co_solicitud'}
           ]
    });
    return this.store;      
},getListaRequisicion: function(){

    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/storelistamateriales',
    root:'data',
    fields:[
                {name: 'co_detalle_requisicion'},
                {name: 'co_producto'},
                {name: 'cod_producto'},
                {name: 'tx_producto'},
                {name: 'nu_cantidad'},
                {name: 'co_requisicion'},
                {name: 'co_unidad_producto'},
                {name: 'tx_unidad_producto'}
                
           ]
    });
    return this.store;      
},
verificarProveedor:function(){
            Ext.Ajax.request({
                method:'GET',
                url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Contabilidad/verificarProveedor',
                params:{
                    co_documento: ContabilidadEditar.main.co_documento.getValue(),
                    tx_rif: ContabilidadEditar.main.tx_rif.getValue()
                },
                success:function(result, request ) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if(!obj.data){
                        ContabilidadEditar.main.co_proveedor.setValue("");
                        ContabilidadEditar.main.co_documento.setValue("");
                        ContabilidadEditar.main.tx_rif.setValue("");
                        ContabilidadEditar.main.tx_razon_social.setValue("");
			ContabilidadEditar.main.nu_iva_retencion.setValue("");
                        ContabilidadEditar.main.co_ramo.clearValue();
                        ContabilidadEditar.main.storeCO_RAMO.removeAll();

                            Ext.Msg.show({
                            title : 'ALERTA',
                            msg : 'El Proveedor no se encuentra registrado',
                            width : 400,
                            height : 800,
                            closable : false,
                            buttons : Ext.Msg.OK,
                            icon : Ext.Msg.INFO
                        });

                    }else{

                        ContabilidadEditar.main.co_proveedor.setValue(obj.data.co_proveedor);
                        ContabilidadEditar.main.tx_razon_social.setValue(obj.data.tx_razon_social);
                        ContabilidadEditar.main.nu_iva_retencion.setValue(obj.data.nu_valor);
                        ContabilidadEditar.main.storeCO_RAMO.load({
                            params: {
                                co_proveedor:obj.data.co_proveedor
                            }
                        });
                    }
                }
 });
}
};
Ext.onReady(ContabilidadEditar.main.init, ContabilidadEditar.main);
</script>
<div id="formularioAgregar"></div>