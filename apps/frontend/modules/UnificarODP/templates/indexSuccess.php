<script type="text/javascript">
Ext.ns("unificacionPagoEditar");
unificacionPagoEditar.main = {
    co_tramite:     [],    
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_TRAMITE = this.getStoreCO_TRAMITE();
//<Stores de fk>
//<Stores de fk>
this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();

this.store_lista = this.getLista();


this.co_solicitud = new Ext.form.Hidden({
    name:'co_solicitud',
    value:this.OBJ.co_solicitud});


this.cod_tipo_solicitud = new Ext.form.Hidden({
    name:'cod_tipo_solicitud'
});

this.co_proveedor = new Ext.form.Hidden({
    name:'co_proveedor',
    value:this.OBJ.co_proveedor});


this.cod_proveedor = new Ext.form.Hidden({
    name:'cod_proveedor',
    value:this.OBJ.co_proveedor});


this.Registro = Ext.data.Record.create([
        {name: 'tx_producto', type: 'string'},
        {name: 'co_producto', type: 'number'},
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
        name:'json_solicitud',
        value:''
});

this.co_tipo_solicitud = new Ext.form.ComboBox({
	fieldLabel:'Tipo de Tramite',
	store: this.storeCO_TRAMITE,
	typeAhead: true,
	valueField: 'co_tipo_solicitud',
	displayField:'tx_tipo_solicitud',
	hiddenName:'co_tipo_solicitud',
	readOnly:(this.OBJ.co_unificacion_odp!='')?true:false,
	style:(this.OBJ.co_unificacion_odp!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione ...',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});

this.storeCO_TRAMITE.load({
    callback: function(){
        unificacionPagoEditar.main.co_tipo_solicitud.setValue(unificacionPagoEditar.main.OBJ.co_tipo_solicitud);
    }
});



this.co_documento = new Ext.form.ComboBox({
	fieldLabel:'Co documento',
	store: this.storeCO_DOCUMENTO,
	typeAhead: true,
	valueField: 'co_documento',
	displayField:'inicial',
	hiddenName:'co_documento',
	readOnly:(this.OBJ.co_unificacion_odp!='')?true:false,
	style:(this.OBJ.co_unificacion_odp!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:50,
	resizable:true,
	allowBlank:false
});
this.storeCO_DOCUMENTO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_documento,
	value:  (this.OBJ.co_documento=='')?4:this.OBJ.co_documento,
	objStore: this.storeCO_DOCUMENTO
});

this.tx_rif = new Ext.form.TextField({
	name:'tx_rif',
	value:this.OBJ.tx_rif,
        readOnly:(this.OBJ.co_unificacion_odp!='')?true:false,
	style:(this.OBJ.co_unificacion_odp!='')?'background:#c9c9c9;':'',
	allowBlank:false,
	width:130
});

this.tx_razon_social = new Ext.form.TextField({
	fieldLabel:'Razon Social',
	name:'tx_razon_social',
	value:this.OBJ.tx_razon_social,
	allowBlank:false,
	readOnly:true,
	style:'background:#c9c9c9;',
	width:500
});

this.co_documento.on("blur",function(){
    if(unificacionPagoEditar.main.tx_rif.getValue()!=''){
    unificacionPagoEditar.main.verificarProveedor();
    }
});

this.tx_rif.on("blur",function(){
    unificacionPagoEditar.main.verificarProveedor();
});

this.compositefieldCIRIF = new Ext.form.CompositeField({
fieldLabel: 'RIF',
width:300,
items: [
	this.co_documento,
	this.tx_rif,
	]
});

this.tx_direccion = new Ext.form.TextField({
	fieldLabel:'Direccion',
	name:'tx_direccion',
	value:this.OBJ.tx_direccion,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;',
	width:500
});

this.fieldDatos1 = new Ext.form.FieldSet({
        title: 'Datos del Proveedor',
        width:1000,        
        items:[
                        this.co_proveedor,
			this.compositefieldCIRIF,
			this.tx_razon_social,
			this.tx_direccion,
			this.co_tipo_solicitud,
		]
});

this.formFiltroPrincipal = new Ext.form.FormPanel({
   // title:'Lista de Solicitudes Pendientes',
    iconCls: 'icon-solpendiente',
  //  collapsible: true,
    titleCollapse: true,
    autoWidth:true,
    border:false,
    labelWidth: 110,
    padding:'10px',
    items   : [
       this.fieldDatos1       
    ],
    keys: [{
		key:[Ext.EventObject.ENTER],
		handler: function() {
			 unificacionPagoEditar.main.aplicarFiltroByFormulario();
		}}
    ],
    buttonAlign:'center',
    buttons:[
        {
            text:'Consultar',
            iconCls:'icon-buscar',
            handler:function(){
                        unificacionPagoEditar.main.aplicarFiltroByFormulario();
            }
        }
    ]
});


//this.displayfieldttotalacancelar = new Ext.form.DisplayField({
//	value:"<span style='font-size:16px;color:white;'><b>Total a Pagar: "+formatoNumero((Number(unificacionPagoEditar.main.total_pagar.getValue()).toFixed(2)))+"</b></span>&nbsp;&nbsp;&nbsp;"
//});

function renderMonto(val, attr, record) { 
     return paqueteComunJS.funcion.getNumeroFormateado(val);     
} 

var myCboxSelModel = new Ext.grid.CheckboxSelectionModel({
  // override private method to allow toggling of selection on or off for multiple rows.
                        handleMouseDown : function(g, rowIndex, e){
                          var view = this.gridPanel.getView();
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
                      //         unificacionPagoEditar.main.botonPagar.setDisabled(true);
                      //         unificacionPagoEditar.main.botonReportesP.setDisabled(true);
                              var length = sm.selections.length
                              , record = [];
                              if(length>0){
                      //           unificacionPagoEditar.main.botonPagar.setDisabled(false);
                      //           unificacionPagoEditar.main.botonReportesP.setDisabled(false);            
                                 for(var i = 0; i<length;i++){
                                      record.push(sm.selections.items[i].data.co_solicitud); 
                                  }
                              }
                              unificacionPagoEditar.main.co_tramite = [];
                              unificacionPagoEditar.main.co_tramite.push(record);
                              console.log(record);
                             //alert(record);

                          }


                       }
});

this.gridPanel = new Ext.grid.GridPanel({
        title:'Lista de Facturas',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:320,  
        width:1100,
        sm: myCboxSelModel,
        columns: [
            new Ext.grid.RowNumberer(),
            myCboxSelModel,            
            {header: 'Solicitud',width:100, menuDisabled:true,dataIndex: 'co_solicitud'},
            {header: 'Fecha', width:100, menuDisabled:true,dataIndex: 'fecha_compra'},
            {header: 'Código', width:150, menuDisabled:true,dataIndex: 'numero_compra'},
            {header: 'Monto',width:150, menuDisabled:true,dataIndex: 'monto_total',renderer:renderMonto},
            {header: 'Observación',width:470, menuDisabled:true,dataIndex: 'tx_observacion'}
        ]
});


this.guardar = new Ext.Button({
    text:'Generar ODP',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!unificacionPagoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        
//        var list_factura = paqueteComunJS.funcion.getJsonByObjStore({
//                store:unificacionPagoEditar.main.gridPanel.getStore()
//        });
        
        unificacionPagoEditar.main.hiddenJsonFactura.setValue(unificacionPagoEditar.main.co_tramite);  
        
        Ext.MessageBox.confirm('Confirmación', '¿Esta seguro que desea unificar la Orden de Pago?, una vez unificada no podrá revertir el proceso?', function(boton){
	if(boton=="yes"){
        
                unificacionPagoEditar.main.formPanel_.getForm().submit({
                    method:'POST',
                    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/UnificarODP/guardar',
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
                         //ServicioBasicoFacturaLista.main.store_lista.load();
                         unificacionPagoEditar.main.winformPanel_.close();
                     }
                });
        }});

   
    }
});

if(this.OBJ.co_unificacion_odp!=''){
    this.guardar.disable();
    this.store_lista.baseParams.co_unificacion_odp = this.OBJ.co_unificacion_odp;
    this.store_lista.load({
        callback: function(){
            var records = [];
            this.each(function(record,rowIndex){
                 records.push(record); 
            })           
            unificacionPagoEditar.main.gridPanel.getSelectionModel().selectRecords(records);            
           
        }
    });
}

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        unificacionPagoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:false,
    width:1040,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[       
            this.co_solicitud,
            this.cod_proveedor,
            this.cod_tipo_solicitud,
            this.hiddenJsonFactura,
            this.gridPanel
        ],
	bbar: new Ext.ux.StatusBar({
		style: 'border: 1px solid #99bbe8',
		items:[ 
//                 this.displayfieldttotalacancelar
                ]
	})
});



this.winformPanel_ = new Ext.Window({
    title:'Unificacion de Facturas',
    modal:true,
    constrain:true,
    width:1040,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.formFiltroPrincipal,
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
aplicarFiltroByFormulario: function(){
	//Capturamos los campos con su value para posteriormente verificar cual
	//esta lleno y trabajar en base a ese.
	var campo = unificacionPagoEditar.main.formFiltroPrincipal.getForm().getValues();       
	unificacionPagoEditar.main.store_lista.baseParams={}

	var swfiltrar = false;
	for(campName in campo){
	    if(campo[campName]!=''){
		swfiltrar = true;
		eval("unificacionPagoEditar.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
                
                if(campName == 'co_tipo_solicitud'){
                    unificacionPagoEditar.main.cod_tipo_solicitud.setValue(campo[campName]);
                }
                
	    }
	}
        
        
	if(swfiltrar==true){
	    unificacionPagoEditar.main.store_lista.baseParams.BuscarBy = true;
	    unificacionPagoEditar.main.store_lista.load();
	}else{
	    Ext.MessageBox.show({
		       title: 'Notificación',
		       msg: 'Debe ingresar un parametro de busqueda',
		       buttons: Ext.MessageBox.OK,
		       icon: Ext.MessageBox.WARNING
	    });
	}

},
eliminar:function(){
        var s = unificacionPagoEditar.main.gridPanel.getSelectionModel().getSelections();
        
        var co_factura         = unificacionPagoEditar.main.gridPanel.getSelectionModel().getSelected().get('co_factura');
        var co_detalle_compras = unificacionPagoEditar.main.gridPanel.getSelectionModel().getSelected().get('co_detalle_compras');
       
        if(co_factura!=''){
            
            Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ServicioBasicoFactura/eliminarFactura',
            params:{
                co_factura: co_factura,
                co_detalle_compras: co_detalle_compras
            },
            success:function(result, request ) {
               unificacionPagoEditar.main.store_lista.load();
            }});
            
        } 
        
       
        for(var i = 0, r; r = s[i]; i++){
              unificacionPagoEditar.main.store_lista.remove(r);
        }
        
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
}
,verificarProveedor:function(){
            Ext.Ajax.request({
                method:'GET',
                url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Compras/verificarProveedor',
                params:{
                    co_documento: unificacionPagoEditar.main.co_documento.getValue(),
                    tx_rif: unificacionPagoEditar.main.tx_rif.getValue()
                },
                success:function(result, request ) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if(!obj.data){
                        unificacionPagoEditar.main.co_proveedor.setValue("");
                        unificacionPagoEditar.main.co_documento.setValue("");
                        unificacionPagoEditar.main.tx_rif.setValue("");
                        unificacionPagoEditar.main.tx_razon_social.setValue("");
			unificacionPagoEditar.main.tx_direccion.setValue("");
                        unificacionPagoEditar.main.cod_proveedor.setValue("");

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

                        unificacionPagoEditar.main.co_proveedor.setValue(obj.data.co_proveedor);
                        unificacionPagoEditar.main.cod_proveedor.setValue(obj.data.co_proveedor);
                        unificacionPagoEditar.main.tx_razon_social.setValue(obj.data.tx_razon_social);
                        unificacionPagoEditar.main.tx_direccion.setValue(obj.data.tx_direccion);                       
                    }
                }
 });
}
,getStoreCO_DOCUMENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcodocumento',
        root:'data',
        fields:[
            {name: 'co_documento'},
            {name: 'inicial'}
            ]
    });
    return this.store;
}
,getStoreCO_TRAMITE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/UnificarODP/storefkcotramite',
        root:'data',
        fields:[
            {name: 'co_tipo_solicitud'},
            {name: 'tx_tipo_solicitud'}
        ]
    });
    return this.store;
},getLista: function(){

    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/UnificarODP/storelista',
    root:'data',
    fields:[
                {name: 'co_solicitud'},
                {name: 'fecha_compra'},
                {name: 'tx_observacion'},
                {name: 'monto_total'},
                {name: 'numero_compra'}
           ]
    });
    return this.store;  
    
    
    
    
}
};
Ext.onReady(unificacionPagoEditar.main.init, unificacionPagoEditar.main);
</script>
<div id="formularioAgregar"></div>