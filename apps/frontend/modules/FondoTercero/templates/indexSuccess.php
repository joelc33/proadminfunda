<script type="text/javascript">
Ext.ns("fondoEditar");
fondoEditar.main= {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
this.store_lista   = this.getLista();

this.Registro = Ext.data.Record.create([
                     {name: 'co_detalle_fondo', type:'number'},
                     {name: 'co_tipo_retencion', type: 'number'},
                     {name: 'tx_tipo_retencion', type: 'number'},
                     {name: 'monto', type: 'number'},
                     {name: 'tx_observacion', type:'string'},
                     {name: 'fe_desde', type:'string'},
                     {name: 'fe_hasta', type:'string'},
                     {name: 'co_factura_retencion', type:'string'},
                     {name: 'banco', type: 'number'},
                     {name: 'cuenta', type: 'number'}
                ]);

this.co_fondo_tercero = new Ext.form.Hidden({
	name:'co_fondo_tercero',
	value:this.OBJ.co_fondo_tercero,
	allowBlank:false
});

this.co_solicitud = new Ext.form.Hidden({
	name:'fondo[co_solicitud]',
	value:this.OBJ.co_solicitud,
	allowBlank:false
});

this.co_tipo_solicitud = new Ext.form.Hidden({
	name:'fondo[co_tipo_solicitud]',
	value:this.OBJ.co_tipo_solicitud,
	allowBlank:false
});

this.hiddenJsonPagos  = new Ext.form.Hidden({
        name:'json_pagos',
        value:''
});

this.mo_pagar  = new Ext.form.Hidden({
        name:'fondo[mo_pagar]',
        value:this.OBJ.mo_pagar
});
this.co_proveedor  = new Ext.form.Hidden({
        name:'fondo[co_proveedor]',
        value:this.OBJ.co_proveedor
});

this.co_documento = new Ext.form.ComboBox({
	fieldLabel:'Co documento',
	store: this.storeCO_DOCUMENTO,
	typeAhead: true,
	valueField: 'co_documento',
	displayField:'inicial',
	hiddenName:'fondo[co_documento]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
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
	name:'fondo[tx_rif]',
	value:this.OBJ.tx_rif,
	allowBlank:false,
	width:130
});
this.co_documento.on("blur",function(){
    if(fondoEditar.main.tx_rif.getValue()!=''){
    fondoEditar.main.verificarProveedor();
    }
});

this.tx_rif.on("blur",function(){
    fondoEditar.main.verificarProveedor();
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
	name:'fondo[tx_razon_social]',
	value:this.OBJ.tx_razon_social,
	allowBlank:false,
	width:770
});

this.tx_direccion = new Ext.form.TextField({
	fieldLabel:'Direccion',
	name:'fondo[tx_direccion]',
	value:this.OBJ.tx_direccion,
	allowBlank:false,
	width:770
});

this.nu_declaracion = new Ext.form.TextField({
	fieldLabel:'N° Declaración',
	name:'fondo[nu_declaracion]',
	value:this.OBJ.nu_declaracion,
	width:185
});

this.fecha = new Ext.form.DateField({
	fieldLabel:'Fecha',
	name:'fondo[fecha]',
	value:new Date(),
	allowBlank:false,
	width:100,
        minValue:this.OBJ.fe_ini,
        maxValue:new Date()  
});

this.tx_observacion = new Ext.form.TextArea({
	fieldLabel:'Descripción',
	name:'fondo[tx_observacion]',
	value:this.OBJ.tx_observacion,
        allowBlank:false,
	width:770
});

this.fieldDatos= new Ext.form.FieldSet({
        title: 'Datos del Tramite',
        items:[
          this.compositefieldCIRIF,
          this.tx_razon_social,
          this.tx_direccion,
//          this.nu_declaracion,
          this.fecha,
          this.tx_observacion          
       ]
});




this.agregar = new Ext.Button({
    text: 'Agregar',
    iconCls: 'icon-nuevo',
    handler: function () {
        
       if(fondoEditar.main.tx_rif.getValue()==''){
        Ext.Msg.alert("Alerta","Debe agregar el rif y la razon social a pagar");
        return false;
        }
        this.co_proveedor = fondoEditar.main.co_proveedor.getValue();
        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoTercero/agregarPago',
            params: 'co_proveedor='+this.co_proveedor,
            scripts: true,
            text: "Cargando.."
        });
    }
});

this.botonEliminar = new Ext.Button({
                text:'Eliminar',
                iconCls: 'icon-eliminar',
                id:'eliminar',
                handler: function(boton){
                    fondoEditar.main.eliminar();
                }
});

this.botonEliminar.disable();
function renderMonto(val, attr, record) {
     return paqueteComunJS.funcion.getNumeroFormateado(val);
}

this.displayfieldmonto = new Ext.form.DisplayField({
 value:"<span style='font-size:12px;'><b>Total a Pagar: </b></span>"
});
this.gridPanel = new Ext.grid.GridPanel({
        //title:'Lista de Materiales',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:230,
        width:940,
        tbar:[this.agregar,'-',this.botonEliminar],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_detalle_fondo', hidden: true,width:10, menuDisabled:true,dataIndex: 'co_detalle_fondo'},
            {header: 'co_fondo_tercero', hidden: true,width:10, menuDisabled:true,dataIndex: 'co_fondo_tercero'},
            {header: 'co_tipo_retencion', hidden: true,width:10, menuDisabled:true,dataIndex: 'co_tipo_retencion'},
            {header: 'Tipo de Retencion', width:200, menuDisabled:true,dataIndex: 'tx_tipo_retencion'},
            {header: 'Fecha Desde', width:100, menuDisabled:true,dataIndex: 'fe_desde'},
            {header: 'Fecha Hasta', width:100, menuDisabled:true,dataIndex: 'fe_hasta'},
//            {header: 'Observación',width:200, menuDisabled:true,dataIndex: 'tx_observacion',renderer:textoLargo},
            {header: 'Monto',width:150, menuDisabled:true,dataIndex: 'monto',renderer:renderMonto}
            
        ],
        stripeRows: true,
        autoScroll:true,
        stateful: true,
    bbar: new Ext.ux.StatusBar({
    id: 'basic-statusbar',
    autoScroll:true,
    defaults:{style:'color:black;font-size:30px;',autoWidth:true},
    items:[
    this.displayfieldmonto
    ]
    }),
        listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
            fondoEditar.main.botonEliminar.enable();
        }}
});
if(this.OBJ.co_fondo_tercero!=''){
    fondoEditar.main.store_lista.baseParams.co_fondo_tercero=this.OBJ.co_fondo_tercero;
    this.store_lista.load({
            callback: function(){
            fondoEditar.main.getTotal();
        }});            

}
this.fieldGrid= new Ext.form.FieldSet({
        //title: 'Datos de los Materiales',
        items:[
          this.gridPanel

       ]
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){
        var cant = fondoEditar.main.store_lista.getCount();
        if(cant==0){
            Ext.Msg.alert("Alerta","Debe Agregar al menos un Pago");
            return false;
        }

        if(!fondoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos requeridos! Verifique");
            return false;
        }        

        var list_pagos = paqueteComunJS.funcion.getJsonByObjStore({
                store:fondoEditar.main.gridPanel.getStore()
        });

        fondoEditar.main.hiddenJsonPagos.setValue(list_pagos);

        fondoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoTercero/guardar',
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
//                solicitudLista.main.store_lista.load();
//                Detalle.main.store_lista.load();
                 fondoEditar.main.winformPanel_.close();
             }
        });


    }
});

this.salir = new Ext.Button({
    text:'Salir',
    iconCls: 'icon-cancelar',
    handler:function(){
        fondoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:1000,
    height:600,
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
                    this.co_fondo_tercero,
                    this.co_proveedor,
                    this.co_solicitud,
                    this.co_tipo_solicitud,
                    this.mo_pagar,
                    this.hiddenJsonPagos,
                    this.fieldDatos,
                    this.fieldGrid
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Pago: Fondo de Tercero',
    modal:true,
    constrain:true,
    width:1000,
    frame:true,
    closabled:true,
    height:600,
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

}
,getStoreCO_DOCUMENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoTercero/storefkcodocumento',
        root:'data',
        fields:[
            {name: 'co_documento'},
            {name: 'inicial'}
            ]
    });
    return this.store;
}
,getLista: function(){

    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoTercero/storelistadetallefondo',
    root:'data',
    fields:[
                {name: 'co_detalle_fondo'},
                {name: 'co_fondo_tercero'},
                {name: 'co_tipo_retencion'},
                {name: 'tx_tipo_retencion'},
                {name: 'tx_observacion'},
                {name: 'monto'},
                {name: 'fe_desde'},
                {name: 'fe_hasta'}
           ]
    });
    return this.store;
},
getTotal:function(){

this.total = 0;
this.tcancelar = 0;
this.total = paqueteComunJS.funcion.getSumaColumnaGrid({
            store:fondoEditar.main.store_lista,
            campo:'monto'
            });         

this.tcancelar = parseFloat(this.total);
this.tcancelar = this.tcancelar.toFixed(2);
fondoEditar.main.mo_pagar.setValue(this.tcancelar);
fondoEditar.main.displayfieldmonto.setValue("<span style='font-size:12px;'><b>Total a Pagar: </b>"+paqueteComunJS.funcion.getNumeroFormateado(fondoEditar.main.mo_pagar.getValue())+"</b></span>");

},
eliminar:function(){
        var s = fondoEditar.main.gridPanel.getSelectionModel().getSelections();

        var co_detalle_fondo = fondoEditar.main.gridPanel.getSelectionModel().getSelected().get('co_detalle_fondo');
        var co_fondo_tercero = fondoEditar.main.gridPanel.getSelectionModel().getSelected().get('co_fondo_tercero');

        if(co_detalle_fondo!=''){

            Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoTercero/eliminar',
            params:{
                co_detalle_fondo: co_detalle_fondo,
                co_fondo_tercero: co_fondo_tercero,
                co_solicitud: fondoEditar.main.OBJ.co_solicitud
        
            },
            success:function(result, request ) {
//               fondoEditar.main.store_lista.load();
            }});

        }

        for(var i = 0, r; r = s[i]; i++){
              fondoEditar.main.store_lista.remove(r);
        }
        fondoEditar.main.botonEliminar.disable();
//         solicitudLista.main.store_lista.load();
//                Detalle.main.store_lista.load();
     
        fondoEditar.main.getTotal();
      var cant = fondoEditar.main.store_lista.getCount();
      if (cant==0){
        fondoEditar.main.co_documento.setReadOnly(false);
        fondoEditar.main.tx_razon_social.setReadOnly(false);
        fondoEditar.main.tx_direccion.setReadOnly(false);        
        fondoEditar.main.tx_rif.setReadOnly(false);
      }
                
},
verificarProveedor:function(){
            Ext.Ajax.request({
                method:'GET',
                url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/FondoTercero/verificarProveedor',
                params:{
                    co_documento: fondoEditar.main.co_documento.getValue(),
                    tx_rif: fondoEditar.main.tx_rif.getValue()
                },
                success:function(result, request ) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if(!obj.data){
                        fondoEditar.main.co_proveedor.setValue("");
                        fondoEditar.main.co_documento.setValue("");
                        fondoEditar.main.tx_rif.setValue("");
                        fondoEditar.main.tx_razon_social.setValue("");
			fondoEditar.main.tx_direccion.setValue("");

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

                        fondoEditar.main.co_proveedor.setValue(obj.data.co_proveedor);
                        fondoEditar.main.tx_razon_social.setValue(obj.data.tx_razon_social);
                        fondoEditar.main.tx_direccion.setValue(obj.data.tx_direccion);
                    }
                }
 });
}
};
Ext.onReady(fondoEditar.main.init, fondoEditar.main);
</script>
<div id="formularioAgregar"></div>
