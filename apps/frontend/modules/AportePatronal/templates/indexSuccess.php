<script type="text/javascript">
Ext.ns("AportePatronalEditar");
AportePatronalEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
this.store_lista   = this.getLista();

this.Registro = Ext.data.Record.create([
                     {name: 'co_solicitud_aporte', type:'number'},
                     {name: 'co_detalle_compras', type:'number'},
                     {name: 'co_aporte_patronal_nomina', type:'number'},
                     {name: 'co_aporte_patronal', type: 'string'},
                     {name: 'tx_aporte_patronal_nomina', type: 'string'},
                     {name: 'tx_aporte_patronal', type:'string'},
                     {name: 'monto',type:'string'}
                ]);

//<ClavePrimaria>

this.hiddenJsonAporte  = new Ext.form.Hidden({
        name:'json_aporte',
        value:''
});

this.co_proveedor = new Ext.form.Hidden({
    name:'tb160_solicitud_aporte_patronal[co_proveedor]',
    value:this.OBJ.co_proveedor});

this.monto_total = new Ext.form.Hidden({
    name:'tb160_solicitud_aporte_patronal[mo_total]',
    value:this.OBJ.mo_total});

//this.co_aporte_patronal = new Ext.form.Hidden({
//    name:'tb160_solicitud_aporte_patronal[co_aporte_patronal]',
//    value:this.OBJ.co_aporte_patronal
//});

this.co_compra = new Ext.form.Hidden({
    name:'tb160_solicitud_aporte_patronal[co_compra]',
    value:this.OBJ.co_compra
});

this.co_solicitud = new Ext.form.Hidden({
	name:'tb160_solicitud_aporte_patronal[co_solicitud]',
	value:this.OBJ.co_solicitud,
	allowBlank:false
});

this.co_documento = new Ext.form.ComboBox({
	fieldLabel:'Co documento',
	store: this.storeCO_DOCUMENTO,
	typeAhead: true,
        id:'co_documento',
	valueField: 'co_documento',
	displayField:'inicial',
	hiddenName:'tb160_solicitud_aporte_patronal[co_documento]',
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
	name:'tb160_solicitud_aporte_patronal[tx_rif]',
        id:'tx_rif',
	value:this.OBJ.tx_rif,       
	allowBlank:false,
	width:130
});
this.co_documento.on("blur",function(){
    if(AportePatronalEditar.main.tx_rif.getValue()!=''){
    AportePatronalEditar.main.verificarProveedor();
    }
});

this.tx_rif.on("blur",function(){
    AportePatronalEditar.main.verificarProveedor();
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
	name:'tb160_solicitud_aporte_patronal[tx_razon_social]',
	value:this.OBJ.tx_razon_social,
        readOnly:(this.OBJ.co_factura!='')?true:false,
	style:(this.OBJ.co_factura!='')?'background:#c9c9c9;':'',
	allowBlank:false,
	width:770
});

this.tx_direccion = new Ext.form.TextField({
	fieldLabel:'Direccion',
	name:'tb160_solicitud_aporte_patronal[tx_direccion]',
	value:this.OBJ.tx_direccion,
	allowBlank:false,
        readOnly:(this.OBJ.co_factura!='')?true:false,
	style:(this.OBJ.co_factura!='')?'background:#c9c9c9;':'',
	width:770
});

this.fieldProveedor= new Ext.form.FieldSet({
        title: 'Datos del Proveedor',
        items:[
          this.compositefieldCIRIF,
          this.tx_razon_social,
          this.tx_direccion
       ]
});



this.displayfieldmonto = new Ext.form.DisplayField({
 value:"<span style='font-size:12px;'><b>Monto Total: </b>0</b></span>"
});

this.agregar = new Ext.Button({
    text: 'Agregar',
    iconCls: 'icon-nuevo',
    handler: function () {
        
        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/AportePatronal/agregarAporte',
            params: 'codigo=<?php echo $co_requisicion; ?>',
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
                    AportePatronalEditar.main.eliminar();
                }
});

this.cargarAporte = new Ext.Button({
    text: 'Cargar Ahorro Patronal 85',
    iconCls: 'icon-nuevo',
    handler: function () {
        
        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/AportePatronal/agregarAhorroPatronal',
            params: {codigo: AportePatronalEditar.main.OBJ.co_solicitud},
            scripts: true,
            text: "Cargando.."
        });
    }
});

this.botonEliminar.disable();
function renderMonto(val, attr, record) {
     return paqueteComunJS.funcion.getNumeroFormateado(val);
}
this.gridPanel = new Ext.grid.GridPanel({
        title:'Lista de Aportes Patronales',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:350,
        width:940,
        autoScroll:true,
        tbar:[this.agregar,'-',this.botonEliminar,'-',this.cargarAporte],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_aporte_patronal_nomina', hidden: true,width:10, menuDisabled:true,dataIndex: 'co_aporte_patronal_nomina'},
            {header: 'co_detalle_compras', hidden: true,width:10, menuDisabled:true,dataIndex: 'co_detalle_compras'},
            {header: 'Nomina',width:380, menuDisabled:true,dataIndex: 'tx_aporte_patronal_nomina'},
            {header: 'Descripción', width:280, menuDisabled:true,dataIndex: 'tx_aporte_patronal'},
            {header: 'Monto',width:200, menuDisabled:true,dataIndex: 'monto',renderer:renderMonto}
        ],
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
            AportePatronalEditar.main.botonEliminar.enable();
        }}
});

if(this.OBJ.co_compra!=''){
    this.store_lista.baseParams.co_compra=this.OBJ.co_compra;
    this.store_lista.load({
        callback: function(){
            AportePatronalEditar.main.getCalcular();
        }
    });
}

this.fieldCompra= new Ext.form.FieldSet({
        //title: 'Datos de los Materiales',
        items:[
           this.gridPanel
       ]
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){
        var cant = AportePatronalEditar.main.store_lista.getCount();
        if(cant==0){
            Ext.Msg.alert("Alerta","Debe Agregar al menos un Material");
            return false;
        }              
       
        var list_aporte = paqueteComunJS.funcion.getJsonByObjStore({
                store:AportePatronalEditar.main.gridPanel.getStore()
        });

        AportePatronalEditar.main.hiddenJsonAporte.setValue(list_aporte);

        AportePatronalEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/AportePatronal/guardar',
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
                //pendienteEntidadesLista.main.store_lista.load();
                Detalle.main.store_lista.load();
                AportePatronalEditar.main.winformPanel_.close();
             }
        });


    }
});

this.salir = new Ext.Button({
    text:'Salir',
    iconCls: 'icon-cancelar',
    handler:function(){
        AportePatronalEditar.main.winformPanel_.close();
    }
});


this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:1000,
    height:570,
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
            //this.co_aporte_patronal,
            this.hiddenJsonAporte,
            this.co_solicitud,
            this.co_compra,
            this.monto_total,
            this.co_proveedor,
            this.fieldProveedor,
            this.fieldCompra
          ]
});

  

this.winformPanel_ = new Ext.Window({
    title:'Aporte Patronal',
    modal:true,
    constrain:true,
    width:1000,
    frame:true,
    closabled:true,
    height:570,
    items:[
        this.formPanel_

    ],
    buttons:[
        this.guardar,
        this.salir
    ],
    bbar: new Ext.ux.StatusBar({
    id: 'basic-statusbar',
    autoScroll:true,
    defaults:{style:'color:black;font-size:30px;',autoWidth:true},
    items:[
    this.displayfieldmonto
    ]
    }),
    buttonAlign:'center'
});
this.winformPanel_.show();

},
getCalcular:function(){

        var monto  = paqueteComunJS.funcion.getSumaColumnaGrid({
            store:AportePatronalEditar.main.store_lista,
            campo:'monto'
        });
        
                
        AportePatronalEditar.main.monto_total.setValue(monto);
        AportePatronalEditar.main.displayfieldmonto.setValue("<span style='font-size:12px;'><b>Monto Total: </b>"+paqueteComunJS.funcion.getNumeroFormateado(monto)+"</b></span>");
        
        
        if(monto > 0){
             Ext.get('co_documento').setStyle('background-color','#c9c9c9');
             AportePatronalEditar.main.co_documento.setReadOnly(true);
             
             Ext.get('tx_rif').setStyle('background-color','#c9c9c9');
             AportePatronalEditar.main.tx_rif.setReadOnly(true);
        }else{             
             Ext.get('co_documento').setStyle('background-color','#FFFFFF');
             AportePatronalEditar.main.co_documento.setReadOnly(false);
             
             Ext.get('tx_rif').setStyle('background-color','#FFFFFF');
             AportePatronalEditar.main.tx_rif.setReadOnly(false);
        }
       
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
,getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/AportePatronal/storelistaAporte',
    root:'data',
    fields:[
             {name: 'co_solicitud_aporte'},
             {name: 'co_detalle_compras'},
             {name: 'co_aporte_patronal_nomina'},
             {name: 'co_aporte_patronal'},
             {name: 'tx_aporte_patronal_nomina'},
             {name: 'tx_aporte_patronal'},
             {name: 'monto',type:'string'}
           ]
    });
    return this.store;
},
eliminar:function(){
        var s = AportePatronalEditar.main.gridPanel.getSelectionModel().getSelections();

        var co_detalle_compras        = AportePatronalEditar.main.gridPanel.getSelectionModel().getSelected().get('co_detalle_compras');
        var co_aporte_patronal_nomina = AportePatronalEditar.main.gridPanel.getSelectionModel().getSelected().get('co_aporte_patronal_nomina');

        if(co_detalle_compras!=''){

            Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/AportePatronal/eliminarAporte',
            params:{
                co_detalle_compras: co_detalle_compras,
                co_aporte_patronal_nomina: co_aporte_patronal_nomina
            },
            success:function(result, request ) {
                AportePatronalEditar.main.getCalcular();
            }});

        }

        for(var i = 0, r; r = s[i]; i++){
              AportePatronalEditar.main.store_lista.remove(r);
        }
         AportePatronalEditar.main.botonEliminar.disable();
        
},
verificarProveedor:function(){
            Ext.Ajax.request({
                method:'GET',
                url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Compras/verificarProveedor',
                params:{
                    co_documento: AportePatronalEditar.main.co_documento.getValue(),
                    tx_rif: AportePatronalEditar.main.tx_rif.getValue()
                },
                success:function(result, request ) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if(!obj.data){
                        AportePatronalEditar.main.co_proveedor.setValue("");
                        AportePatronalEditar.main.co_documento.setValue("");
                        AportePatronalEditar.main.tx_rif.setValue("");
                        AportePatronalEditar.main.tx_razon_social.setValue("");
			AportePatronalEditar.main.tx_direccion.setValue("");
                      
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

                        AportePatronalEditar.main.co_proveedor.setValue(obj.data.co_proveedor);
                        AportePatronalEditar.main.tx_razon_social.setValue(obj.data.tx_razon_social);
                        AportePatronalEditar.main.tx_direccion.setValue(obj.data.tx_direccion);                      
                    }
                }
 });
}
};
Ext.onReady(AportePatronalEditar.main.init, AportePatronalEditar.main);
</script>
<div id="formularioAgregar"></div>
