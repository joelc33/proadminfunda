<script type="text/javascript">
Ext.ns("ComprasEditar");
ComprasEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
this.storeCO_RAMO = this.getStoreCO_RAMO();
this.storeCO_IVA_FACTURA = this.getStoreCO_IVA_FACTURA();
this.storeCO_ENTE = this.getStoreCO_ENTE();
this.storeCO_EJECUTOR = this.getStoreCO_EJECUTOR();
this.storeCO_PROYECTO = this.getStoreCO_PROYECTO();
this.storeCO_ACCION = this.getStoreCO_ACCION();
this.storeCO_TPCONTRATO = this.getStoreCO_TPCONTRATO();
this.storeCO_PARTIDA= this.getStoreCO_PARTIDA();
this.store_lista   = this.getLista();

this.Registro = Ext.data.Record.create([
                     {name: 'co_detalle_requisicion', type:'number'},
                     {name: 'co_producto', type:'number'},
                     {name: 'cod_producto', type: 'string'},
                     {name: 'tx_producto', type: 'string'},
                     {name: 'nu_cantidad', type:'number'},
                     {name: 'precio_unitario', type:'number'},
                     {name: 'monto', type:'number'},
                     {name: 'detalle', type:'string'},
                     {name: 'co_partida', type:'number'},
                     {name: 'co_unidad_producto', type:'number'}
                ]);

//<ClavePrimaria>
this.co_compras = new Ext.form.Hidden({
    name:'co_compras',
    value:this.OBJ.co_compras});
//</ClavePrimaria>


this.co_requisicion = new Ext.form.Hidden({
	name:'tb052_compras[co_requisicion]',
	value:this.OBJ.co_requisicion,
	allowBlank:false
});

this.co_solicitud = new Ext.form.Hidden({
	name:'tb052_compras[co_solicitud]',
	value:this.OBJ.co_solicitud,
	allowBlank:false
});

this.co_tipo_solicitud = new Ext.form.Hidden({
	name:'tb052_compras[co_tipo_solicitud]',
	value:this.OBJ.co_tipo_solicitud,
	allowBlank:false
});

this.co_contrato_compras = new Ext.form.Hidden({
	name:'tb052_compras[co_contrato_compras]',
	value:this.OBJ.co_contrato_compras,
	allowBlank:false
});

this.hiddenJsonProducto  = new Ext.form.Hidden({
        name:'json_producto',
        value:''
});

this.co_proveedor  = new Ext.form.Hidden({
        name:'tb008_proveedor[co_proveedor]',
        value:this.OBJ.co_proveedor
});

this.monto_compra  = new Ext.form.Hidden({
        name:'tb052_compras[monto_compra]',
        value:this.OBJ.monto_compra
});

this.monto_iva  = new Ext.form.Hidden({
        name:'tb052_compras[monto_iva]',
        value:this.OBJ.monto_iva
});

this.monto_total  = new Ext.form.Hidden({
        name:'tb052_compras[monto_total]',
        value:this.OBJ.monto_total
});

this.co_hidden_ejecutor  = new Ext.form.Hidden({
        name:'tb052_compras[co_hidden_ejecutor]',
        value:this.OBJ.co_ejecutor
});

this.nu_compra = new Ext.form.DisplayField({
 value:"<span style='color:black;font-size:15px;'><b>N° Compra: </b>"+ComprasEditar.main.OBJ.nu_compra+"</b></span>"
});

this.co_documento = new Ext.form.ComboBox({
	fieldLabel:'Co documento',
	store: this.storeCO_DOCUMENTO,
	typeAhead: true,
	valueField: 'co_documento',
	displayField:'inicial',
	hiddenName:'tb008_proveedor[co_documento]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:50,
        readOnly:true,
	style:'background:#c9c9c9;',
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
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;',
	width:130
});
//this.co_documento.on("blur",function(){
//    if(ComprasEditar.main.tx_rif.getValue()!=''){
//    ComprasEditar.main.verificarProveedor();
//    }
//});
//
//this.tx_rif.on("blur",function(){
//    ComprasEditar.main.verificarProveedor();
//});

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
	name:'tb008_proveedor[tx_razon_social]',
	value:this.OBJ.tx_razon_social,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;',        
	width:770
});

this.tx_direccion = new Ext.form.TextField({
	fieldLabel:'Direccion',
	name:'tb008_proveedor[tx_direccion]',
	value:this.OBJ.tx_direccion,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;',        
	width:770
});

this.co_ramo = new Ext.form.ComboBox({
	fieldLabel:'Ramo',
	store: this.storeCO_RAMO,
	typeAhead: true,
	valueField: 'co_ramo',
	displayField:'tx_ramo',
	hiddenName:'tb052_compras[co_ramo]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:415,
    //readOnly:true,
	//style:'background:#c9c9c9;',        
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

this.fieldProveedor= new Ext.form.FieldSet({
        title: 'Datos del Proveedor',
        items:[
          this.compositefieldCIRIF,
          this.tx_razon_social,
          this.tx_direccion,
          //this.co_ramo
       ]
});

this.co_tp_contrato = new Ext.form.ComboBox({
	fieldLabel:'Tipo de Contrato',
	store: this.storeCO_TPCONTRATO,
	typeAhead: true,
	valueField: 'co_tp_contrato',
	displayField:'tx_tp_contrato',
	hiddenName:'tb052_compras[co_tp_contrato]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:415,
        readOnly:true,
	style:'background:#c9c9c9;',        
	allowBlank:false
});
this.storeCO_TPCONTRATO.load();
paqueteComunJS.funcion.seleccionarComboByCo({
objCMB: this.co_tp_contrato,
value: this.OBJ.co_tp_contrato,
objStore: this.storeCO_TPCONTRATO
});

this.fecha_inicio = new Ext.form.DateField({
	fieldLabel:'Fecha Inicio',
	name:'tb052_compras[fecha_inicio]',
	value:this.OBJ.fecha_inicio,
        readOnly:true,
	style:'background:#c9c9c9;',        
	allowBlank:false,
	width:100
});
this.fecha_fin = new Ext.form.DateField({
	fieldLabel:'Fecha Fin',
	name:'tb052_compras[fecha_fin]',
	value:this.OBJ.fecha_fin,
        readOnly:true,
	style:'background:#c9c9c9;',        
	allowBlank:false,
	width:100
});
this.fecha_entrega = new Ext.form.DateField({
	fieldLabel:'Fecha Entrega',
	name:'tb052_compras[fecha_entrega]',
	value:this.OBJ.fecha_entrega,
        readOnly:true,
	style:'background:#c9c9c9;',        
	allowBlank:false,
	width:100
});


this.monto_contrato = new Ext.form.NumberField({
	fieldLabel:'Monto Contrato',
	name:'tb052_compras[monto]',
        value: this.OBJ.monto,
        readOnly:true,
	style:'background:#c9c9c9;',        
	allowBlank:false,
	width:415
});

this.tiempo_garantia = new Ext.form.TextField({
	fieldLabel:'Garantia',
	name:'tb052_compras[tiempo_garantia]',
	value:this.OBJ.tiempo_garantia,
        readOnly:true,
	style:'background:#c9c9c9;',        
	width:415
});

this.tx_observacion = new Ext.form.TextArea({
	fieldLabel:'Observacion',
	name:'tb052_compras[tx_observacion]',
	value:this.OBJ.tx_observacion,
        readOnly:true,
	style:'background:#c9c9c9;',        
	allowBlank:false,
	width:775
});
this.fieldContrato= new Ext.form.FieldSet({
        title: 'Datos del Contrato',
        items:[
          this.co_tp_contrato,
          this.fecha_inicio,
          this.fecha_fin,
          this.fecha_entrega,
          this.monto_contrato,
          this.tiempo_garantia,
          this.tx_observacion
       ]
});


this.fecha_compra = new Ext.form.DateField({
	fieldLabel:'Fecha Compra',
	name:'tb052_compras[fecha_compra]',
	value:this.OBJ.fecha_compra,
        readOnly:true,
	style:'background:#c9c9c9;',        
	allowBlank:false,
	width:100
});

this.co_iva_factura = new Ext.form.ComboBox({
	fieldLabel:'IVA',
	store: this.storeCO_IVA_FACTURA,
	typeAhead: true,
	valueField: 'nu_valor',
	displayField:'nu_valor',
	hiddenName:'tb052_compras[co_iva_factura]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:50,
        readOnly:true,
	style:'background:#c9c9c9;',        
	allowBlank:false
});
this.storeCO_IVA_FACTURA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_iva_factura,
	value:  this.OBJ.co_iva_factura,
	objStore: this.storeCO_IVA_FACTURA
});

this.co_iva_factura.on('select',function(cmb,record,index){
        ComprasEditar.main.getTotal();
        if(record.get('nu_valor')!=0){
        ComprasEditar.main.storeCO_PARTIDA.load({
        params:{
         co_accion:ComprasEditar.main.co_accion.getValue()

         }});             
        ComprasEditar.main.co_partida_iva.clearValue();
        ComprasEditar.main.co_partida_iva.show();
        }else{
        ComprasEditar.main.co_partida_iva.hide();
        ComprasEditar.main.co_partida_iva.setValue('');        
        }
},this);

this.co_ente = new Ext.form.ComboBox({
	fieldLabel:'Entregar En',
	store: this.storeCO_ENTE,
	typeAhead: true,
	valueField: 'co_ente',
	displayField:'tx_ente',
	hiddenName:'tb052_compras[co_ente]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:387,
        readOnly:true,
	style:'background:#c9c9c9;',        
	allowBlank:false,
        listeners: {
        getSelectedIndex: function() {
        var v = this.getValue();
        var r = this.findRecord(this.valueField || this.displayField, v);
        return(this.storeCO_ENTE.indexOf(r));
         }
        }
});
this.storeCO_ENTE.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_ente,
	value:  this.OBJ.co_ente,
	objStore: this.storeCO_ENTE
});

this.co_ejecutor = new Ext.form.ComboBox({
	fieldLabel:'Ente Ejecutor',
	store: this.storeCO_EJECUTOR,
	typeAhead: true,
	valueField: 'id',
        id:'co_ejecutor',
	displayField:'de_ejecutor',
	hiddenName:'tb052_compras[co_ejecutor]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:775,
        readOnly:true,
	style:'background:#c9c9c9;',        
	allowBlank:false,
        listeners: {
        getSelectedIndex: function() {
        var v = this.getValue();
        var r = this.findRecord(this.valueField || this.displayField, v);
        return(this.storeCO_EJECUTOR.indexOf(r));
         }
        }
});
this.storeCO_EJECUTOR.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_ejecutor,
	value:  this.OBJ.co_ejecutor,
	objStore: this.storeCO_EJECUTOR
});
this.co_ejecutor.on('select',function(cmb,record,index){
        ComprasEditar.main.co_partida_iva.clearValue();
        ComprasEditar.main.storeCO_PARTIDA.removeAll();
        ComprasEditar.main.co_proyecto.clearValue();
        ComprasEditar.main.co_accion.clearValue();
        ComprasEditar.main.co_hidden_ejecutor.setValue(ComprasEditar.main.co_ejecutor.getValue());
        ComprasEditar.main.storeCO_PROYECTO.load({params:{co_ejecutor:record.get('id')}});
},this);

this.co_proyecto = new Ext.form.ComboBox({
	fieldLabel:'Proyecto/Ac',
	store: this.storeCO_PROYECTO,
	typeAhead: true,
	valueField: 'id',
        id:'co_proyecto',
	displayField:'de_proyecto_ac',
	hiddenName:'tb052_compras[co_proyecto]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:775,
        readOnly:true,
	style:'background:#c9c9c9;',        
	allowBlank:false
});
if(this.OBJ.co_ejecutor!=''){
this.storeCO_PROYECTO.load({
    params:{co_ejecutor:this.OBJ.co_ejecutor},
    callback: function(){
    ComprasEditar.main.co_proyecto.setValue(ComprasEditar.main.OBJ.co_proyecto);
}
    });
}
this.co_proyecto.on('select',function(cmb,record,index){
        ComprasEditar.main.co_accion.clearValue();
        ComprasEditar.main.storeCO_ACCION.load({params:{co_proyecto:record.get('id')}});
},this);

this.co_accion = new Ext.form.ComboBox({
	fieldLabel:'Accion Especifica',
	store: this.storeCO_ACCION,
	typeAhead: true,
	valueField: 'id',
        id:'co_accion',
	displayField:'accion_especifica',
	hiddenName:'tb052_compras[co_accion]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:775,
        readOnly:true,
	style:'background:#c9c9c9;',        
	allowBlank:false
});
if(this.OBJ.co_proyecto!=''){
this.storeCO_ACCION.load({
    params:{co_proyecto:this.OBJ.co_proyecto},
    callback: function(){
    ComprasEditar.main.co_accion.setValue(ComprasEditar.main.OBJ.co_accion);
}
    
        });
}

this.co_accion.on('select',function(cmb,record,index){
        if(ComprasEditar.main.co_iva_factura.getValue()!=0){
        ComprasEditar.main.storeCO_PARTIDA.load({
        params:{
         co_accion:ComprasEditar.main.co_accion.getValue(),
             callback: function(){
             ComprasEditar.main.co_partida_iva.setValue('');
            }

         }});    
        ComprasEditar.main.co_partida_iva.clearValue();
        ComprasEditar.main.storeCO_PARTIDA.removeAll();
        ComprasEditar.main.co_partida_iva.show();

        }else{
        ComprasEditar.main.co_partida_iva.clearValue();
        ComprasEditar.main.storeCO_PARTIDA.removeAll();
        ComprasEditar.main.co_partida_iva.hide();          
        }
},this);

this.co_partida_iva = new Ext.form.ComboBox({
	fieldLabel:'Partida Impuesto',
	store: this.storeCO_PARTIDA,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_partida',
	hiddenName:'tb052_compras[co_partida_iva]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:775,
        readOnly:true,
	style:'background:#c9c9c9;',        
        hidden:true,
        listeners: {
        getSelectedIndex: function() {
        var v = this.getValue();
        var r = this.findRecord(this.valueField || this.displayField, v);
        return(this.storeCO_PARTIDA.indexOf(r));
         }
        }
});

if(this.OBJ.co_iva_factura!=0){
ComprasEditar.main.co_partida_iva.show();
ComprasEditar.main.storeCO_PARTIDA.load({
params:{
 co_accion:this.OBJ.co_accion

 },
callback: function(){
ComprasEditar.main.co_partida_iva.setValue(ComprasEditar.main.OBJ.co_partida_iva);
  try{
ComprasEditar.main.co_partida_iva.selectByValue(ComprasEditar.main.OBJ.co_partida_iva);

    }
    catch(err){
    }
}
        
        });
}

this.displayfieldmonto_compra = new Ext.form.DisplayField({
 value:"<span style='font-size:12px;'><b>Sub Total Compra: </b>"+paqueteComunJS.funcion.getNumeroFormateado(ComprasEditar.main.monto_compra.getValue())+"</b></span>"
});
this.displayfieldmonto_iva = new Ext.form.DisplayField({
 value:"<span style='font-size:12px;'><b>Iva: </b>"+paqueteComunJS.funcion.getNumeroFormateado(ComprasEditar.main.monto_iva.getValue())+"</b></span>"
});
this.displayfieldmonto_total = new Ext.form.DisplayField({
 value:"<span style='font-size:18px;'><b>Total Compra: </b>"+paqueteComunJS.funcion.getNumeroFormateado(ComprasEditar.main.monto_total.getValue())+"</b></span>"
});

this.agregar = new Ext.Button({
    text: 'Agregar',
    iconCls: 'icon-nuevo',
    handler: function () {

       if(ComprasEditar.main.co_accion.getValue()==''){
            Ext.Msg.alert("Alerta","Debe Seleccionar la acción especifica antes de agregar los productos");
            return false;
        }
        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/agregarProducto',
            params: 'codigo=<?php echo $co_requisicion; ?>',
            scripts: true,
            text: "Cargando.."
        });
    }
});

this.editar = new Ext.Button({
    text: 'Editar',
    iconCls: 'icon-editar',
    handler: function () {
        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/editarProducto',
            params: {
            	codigo:ComprasEditar.main.gridPanel.getSelectionModel().getSelected().get('co_detalle_compras')
            },
            scripts: true,
            text: "Cargando.."
        });
    }
});

this.editar.disable();

this.botonEliminar = new Ext.Button({
                text:'Eliminar',
                iconCls: 'icon-eliminar',
                id:'eliminar',
                handler: function(boton){
                    ComprasEditar.main.eliminar();
                }
});

this.botonEliminar.disable();
function renderMonto(val, attr, record) {
     return paqueteComunJS.funcion.getNumeroFormateado(val);
}
this.gridPanel = new Ext.grid.GridPanel({
        title:'Lista de Materiales',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:180,
        width:930,
        tbar:[this.editar],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_detalle_compras', hidden: true,width:10, menuDisabled:true,dataIndex: 'co_detalle_requisicion'},
            {header: 'co_producto', hidden: true,width:10, menuDisabled:true,dataIndex: 'co_producto'},
            {header: 'Codigo', width:80, menuDisabled:true,dataIndex: 'cod_producto'},
            {header: 'Descripción',width:280, menuDisabled:true,dataIndex: 'tx_producto',renderer:textoLargo},
            {header: 'Especificaciones',width:180, menuDisabled:true,dataIndex: 'detalle',renderer:textoLargo},
            {header: 'Cantidad',width:60, menuDisabled:true,dataIndex: 'nu_cantidad'},
            {header: 'Precio Unitario',width:150, menuDisabled:true,dataIndex: 'precio_unitario',renderer:renderMonto},
            {header: 'Monto',width:150, menuDisabled:true,dataIndex: 'monto',renderer:renderMonto}
        ],
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
            ComprasEditar.main.editar.enable();
        }}
});

if(this.OBJ.co_compras!=''){

    ComprasEditar.main.store_lista.baseParams.co_compras=this.OBJ.co_compras;
    this.store_lista.load({
        callback: function(){
           // ComprasEditar.main.getTotal();
        }
    });

}

this.fieldCompra= new Ext.form.FieldSet({
        //title: 'Datos de los Materiales',
        items:[
          this.fecha_compra,
          this.co_iva_factura,
          this.co_ente,
//          this.co_ejecutor,
//          this.co_proyecto,
//          this.co_accion,
//          this.co_partida_iva,
          this.gridPanel

       ]
});

this.guardar = new Ext.Button({
    text:'Generar Orden de Compra',
    iconCls: 'icon-guardar',
    handler:function(){
        var cant = ComprasEditar.main.store_lista.getCount();
        if(cant==0){
            Ext.Msg.alert("Alerta","Debe Agregar al menos un Material");
            return false;
        }

      /*  if(ComprasEditar.main.monto_contrato.getValue()!=ComprasEditar.main.monto_total.getValue()){
            Ext.Msg.alert("Alerta","El monto del contrato no coincide con el total de la compra");
            return false;
        }*/

        if(!ComprasEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos requeridos! Verifique");
            return false;
        }

        var list_producto = paqueteComunJS.funcion.getJsonByObjStore({
                store:ComprasEditar.main.gridPanel.getStore()
        });

        ComprasEditar.main.hiddenJsonProducto.setValue(list_producto);

        ComprasEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/guardarOrdenCompra',
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

                 ComprasEditar.main.winformPanel_.close();
             }
        });


    }
});

this.salir = new Ext.Button({
    text:'Salir',
    iconCls: 'icon-cancelar',
    handler:function(){
        ComprasEditar.main.winformPanel_.close();
    }
});


this.tabuladores = new Ext.TabPanel({
        resizeTabs:true, // turn on tab resizing
        minTabWidth: 115,
        tabWidth:150,border:false,
        enableTabScroll:true,
        autoWidth:true,
        deferredRender:false,
        height:550,
        activeTab: 0,
        defaults: {autoScroll:true},
        items:[
                {
                        title: 'Datos de la Compra',
                        items:[ this.fieldProveedor,
                                this.fieldContrato,]
                },
                {
                        title: 'Materiales',
                        items:[this.fieldCompra]
                }
        ]
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:1000,
    height:600,
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_compras,
                    this.co_proveedor,
                    this.co_contrato_compras,
                    this.co_tipo_solicitud,
                    this.co_hidden_ejecutor,
                    this.co_solicitud,
                    this.co_requisicion,
                    this.nu_compra,
                    this.monto_compra,
                    this.monto_iva,
                    this.monto_total,
                    this.tabuladores,
                    this.hiddenJsonProducto
            ]
});

    var tbar = {
        xtype        : 'toolbar',
        layout       : 'hbox',
        items        : this.nu_compra,
        height       : 25,
        layoutConfig : {
            align : 'left'
        }
    };

this.winformPanel_ = new Ext.Window({
    title:'Compras: Materiales o Bienes',
    modal:true,
    constrain:true,
    width:1000,
    frame:true,
    closabled:true,
    height:600,
    tbar   : tbar,
    items:[
        this.formPanel_

    ],
    bbar: new Ext.ux.StatusBar({
    id: 'basic-statusbar',
    autoScroll:true,
    defaults:{style:'color:black;font-size:30px;',autoWidth:true},
    items:[
    this.displayfieldmonto_compra,'-',
    this.displayfieldmonto_iva,'-',
    this.displayfieldmonto_total
    ]
    }),
    buttons:[
        this.guardar,
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();

}
,getStoreCO_DOCUMENTO:function(){
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
}
,getLista: function(){

    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storelistamateriales',
    root:'data',
    fields:[
                {name: 'co_detalle_compras'},
                {name: 'co_producto'},
                {name: 'cod_producto'},
                {name: 'tx_producto'},
                {name: 'nu_cantidad'},
                {name: 'precio_unitario'},
                {name: 'detalle'},
                {name: 'monto'},
                {name: 'co_requisicion'},
           ]
    });
    return this.store;
},
eliminar:function(){
        var s = ComprasEditar.main.gridPanel.getSelectionModel().getSelections();

        var co_detalle_compras = ComprasEditar.main.gridPanel.getSelectionModel().getSelected().get('co_detalle_compras');

        if(co_detalle_compras!=''){

            Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/eliminarMaterial',
            params:{
                co_detalle_compras: co_detalle_compras
            },
            success:function(result, request ) {
               ComprasEditar.main.store_lista.load();
            }});

        }

        for(var i = 0, r; r = s[i]; i++){
              ComprasEditar.main.store_lista.remove(r);
        }
         ComprasEditar.main.botonEliminar.disable();
         ComprasEditar.main.getTotal();
},
getTotal:function(){

this.monto = 0;
this.cancelar = 0;
this.tcancelar = 0;
this.totaliva = 0;
this.iva = 0;
this.iva = ComprasEditar.main.co_iva_factura.getValue();
this.monto = paqueteComunJS.funcion.getSumaColumnaGrid({
            store:ComprasEditar.main.store_lista,
            campo:'monto'
            });


this.cancelar = parseFloat(this.monto);
if(this.iva==''||this.iva==null||this.iva==0){
this.totaliva = 0;
}else{
this.totaliva = (parseFloat(this.monto)*parseFloat(this.iva))/100;
}

this.tcancelar = parseFloat(this.cancelar) + parseFloat(this.totaliva);
this.tcancelar = this.tcancelar.toFixed(2);
ComprasEditar.main.monto_compra.setValue(this.cancelar);
ComprasEditar.main.monto_iva.setValue(parseFloat(this.totaliva));
ComprasEditar.main.monto_total.setValue(parseFloat(this.tcancelar));
ComprasEditar.main.displayfieldmonto_compra.setValue("<span style='font-size:12px;'><b>Sub Total Compra: </b>"+paqueteComunJS.funcion.getNumeroFormateado(ComprasEditar.main.monto_compra.getValue())+"</b></span>");
ComprasEditar.main.displayfieldmonto_iva.setValue("<span style='font-size:12px;'><b>Iva: </b>"+paqueteComunJS.funcion.getNumeroFormateado(ComprasEditar.main.monto_iva.getValue())+"</b></span>");
ComprasEditar.main.displayfieldmonto_total.setValue("<span style='font-size:18px;'><b>Total Compra: </b>"+paqueteComunJS.funcion.getNumeroFormateado(ComprasEditar.main.monto_total.getValue())+"</b></span>");


},
getStoreCO_IVA_FACTURA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoivafactura',
        root:'data',
        fields:[
            {name: 'nu_valor'}
            ]
    });
    return this.store;
},
getStoreCO_ENTE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoente',
        root:'data',
        fields:[
            {name: 'co_ente'},
            {name: 'tx_ente'}
            ]
    });
    return this.store;
},
getStoreCO_EJECUTOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoejecutor',
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
},
getStoreCO_PROYECTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoproyecto',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_proyecto_ac',
            convert:function(v,r){
            return r.nu_proyecto_ac+' - '+r.de_proyecto_ac;
            }
            }
            ]
    });
    return this.store;
},
getStoreCO_ACCION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoaccion',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'accion_especifica',
            convert:function(v,r){
            return r.nu_accion_especifica+' - '+r.de_accion_especifica;
            }
            }
            ]
    });
    return this.store;
},
getStoreCO_PARTIDA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcopartida',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_partida',
            convert:function(v,r){
            return r.nu_partida+' - '+r.de_partida;
            }
            }
            ]
    });
    return this.store;
},
getStoreCO_TPCONTRATO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcotpcontrato',
        root:'data',
        fields:[
            {name: 'co_tp_contrato'},
            {name: 'tx_tp_contrato'}
            ]
    });
    return this.store;
},
verificarProveedor:function(){
            Ext.Ajax.request({
                method:'GET',
                url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Compras/verificarProveedor',
                params:{
                    co_documento: ComprasEditar.main.co_documento.getValue(),
                    tx_rif: ComprasEditar.main.tx_rif.getValue()
                },
                success:function(result, request ) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if(!obj.data){
                        ComprasEditar.main.co_proveedor.setValue("");
                        ComprasEditar.main.co_documento.setValue("");
                        ComprasEditar.main.tx_rif.setValue("");
                        ComprasEditar.main.tx_razon_social.setValue("");
			ComprasEditar.main.tx_direccion.setValue("");
                        ComprasEditar.main.co_ramo.clearValue();
                        ComprasEditar.main.storeCO_RAMO.removeAll();

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

                        ComprasEditar.main.co_proveedor.setValue(obj.data.co_proveedor);
                        ComprasEditar.main.tx_razon_social.setValue(obj.data.tx_razon_social);
                        ComprasEditar.main.tx_direccion.setValue(obj.data.tx_direccion);
                        ComprasEditar.main.storeCO_RAMO.load({
                        params: {co_proveedor:obj.data.co_proveedor
                                }
                         });
                    }
                }
 });
}
};
Ext.onReady(ComprasEditar.main.init, ComprasEditar.main);
</script>
<div id="formularioAgregar"></div>
