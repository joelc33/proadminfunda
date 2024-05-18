<script type="text/javascript">
Ext.ns("FondoAvanceEditar");
FondoAvanceEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_PROVEEDOR = this.getStoreCO_PROVEEDOR();
this.storeCO_APLICACION = this.getStoreCO_APLICACION();
this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
this.storeCO_PARTIDA  = this.getStoreCO_PARTIDA();
this.storeCO_PROYECTO = this.getStoreCO_PROYECTO();
this.storeCO_ACCION   = this.getStoreCO_ACCION();
this.storeCO_EJECUTOR = this.getStoreCO_EJECUTOR();
this.storeCO_DECRETO = this.getStoreCO_DECRETO();

//objeto store
this.store_lista = this.getLista();

//<ClavePrimaria>
this.co_compromiso_asignacion = new Ext.form.Hidden({
    name:'co_compromiso_asignacion',
    value:this.OBJ.co_compromiso_asignacion});
//</ClavePrimaria>

this.co_proveedor = new Ext.form.Hidden({
    name:'tb146_compromiso_asignacion[co_proveedor]',
    value:this.OBJ.co_proveedor});

this.co_solicitud = new Ext.form.Hidden({
    name:'tb146_compromiso_asignacion[co_solicitud]',
    value:this.OBJ.co_solicitud});

this.co_usuario = new Ext.form.Hidden({
    name:'tb146_compromiso_asignacion[co_usuario]',
    value:this.OBJ.co_usuario
});

this.co_detalle_compra  = new Ext.form.Hidden({
        name:'tb146_compromiso_asignacion[co_detalle_compra]',
        value:this.OBJ.co_detalle_compras
});

this.co_compras  = new Ext.form.Hidden({
        name:'tb146_compromiso_asignacion[co_compras]',
        value:this.OBJ.co_compras
});

this.hiddenDetalleCompra  = new Ext.form.Hidden({
        name:'hiddenDetalleCompra'
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
	width:130
});
this.co_documento.on("blur",function(){
    if(FondoAvanceEditar.main.tx_rif.getValue()!=''){
    FondoAvanceEditar.main.verificarProveedor();
    }
});

this.tx_rif.on("blur",function(){
    FondoAvanceEditar.main.verificarProveedor();
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
	name:'tb008_proveedor[tx_razon_social]',
	value:this.OBJ.tx_razon_social,
        readOnly:(this.OBJ.co_factura!='')?true:false,
	style:(this.OBJ.co_factura!='')?'background:#c9c9c9;':'',
	allowBlank:false,
	width:600
});

this.tx_direccion = new Ext.form.TextField({
	fieldLabel:'Direccion',
	name:'tb008_proveedor[tx_direccion]',
	value:this.OBJ.tx_direccion,
	allowBlank:false,
        readOnly:(this.OBJ.co_factura!='')?true:false,
	style:(this.OBJ.co_factura!='')?'background:#c9c9c9;':'',
	width:600
});

this.fieldProveedor= new Ext.form.FieldSet({
        title: 'Datos del Organo / Ente',
        items:[
          this.compositefieldCIRIF,
          this.tx_razon_social,
          this.tx_direccion
       ]
});


this.tx_descripcion = new Ext.form.TextArea({
	fieldLabel:'Descripción',
	name:'tb146_compromiso_asignacion[tx_descripcion]',
	value:this.OBJ.tx_descripcion,
	allowBlank:false,
	width:500
});

this.nu_cancelacion = new Ext.form.NumberField({
	fieldLabel:'Nro. Cancelación',
	name:'tb146_compromiso_asignacion[nu_cancelacion]',
	value:this.OBJ.nu_cancelacion,
	allowBlank:false,
        width:100
});

this.fe_compromiso = new Ext.form.DateField({
	fieldLabel:'Fecha',
	name:'tb146_compromiso_asignacion[fe_compromiso]',
	value:this.OBJ.fe_compromiso,
	allowBlank:false,
	width:100
});

/*
this.nu_monto = new Ext.form.NumberField({
	fieldLabel:'Monto Total',
	name:'tb146_compromiso_asignacion[nu_monto]',
	value:this.OBJ.nu_monto,
	allowBlank:false,
        width:500
});*/

this.fieldAsignacion= new Ext.form.FieldSet({
        title: 'Datos de la Asignación',
        items:[
            this.tx_descripcion,
            this.nu_cancelacion,
            this.fe_compromiso,
            //this.nu_monto
       ]
});


this.co_ejecutor = new Ext.form.ComboBox({
	fieldLabel:'Ente Ejecutor',
	store: this.storeCO_EJECUTOR,
	typeAhead: true,
	valueField: 'id',
    id:'co_ejecutor',
	displayField:'ejecutor',
	hiddenName:'tb146_compromiso_asignacion[co_ejecutor]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
    emptyText:'Seleccione Ejecutor',
	selectOnFocus: true,
	mode: 'local',
	width:700,
	allowBlank:false,
    listeners:{
        select: function(){
            FondoAvanceEditar.main.storeCO_APLICACION.load({
                params:{
                    co_ejecutor:this.getValue()
                },
                callback: function(){
                    FondoAvanceEditar.main.co_aplicacion.setValue(FondoAvanceEditar.main.OBJ.co_aplicacion);
                    FondoAvanceEditar.main.co_decreto.setValue(FondoAvanceEditar.main.OBJ.co_aplicacion);
                }
            });
            FondoAvanceEditar.main.store_lista.removeAll();
            FondoAvanceEditar.main.mo_disponible.setValue('');
        }
    }
});

this.storeCO_EJECUTOR.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_ejecutor,
	value:  this.OBJ.co_ejecutor,
	objStore: this.storeCO_EJECUTOR
});

this.co_aplicacion = new Ext.form.ComboBox({
	fieldLabel:'Aplicacion',
	store: this.storeCO_APLICACION,
	typeAhead: true,
	valueField: 'tx_tip_aplicacion',
	displayField:'aplicacion',
	hiddenName:'tb146_compromiso_asignacion[co_aplicacion]',
	//readOnly:(this.OBJ.co_proveedor!='')?true:false,
	//style:(this.main.OBJ.co_proveedor!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Aplicacion',
	selectOnFocus: true,
	mode: 'local',
	width:700,
	allowBlank:false,
        listeners:{
        select: function(){
            FondoAvanceEditar.main.storeCO_DECRETO.load({
                params:{
                    aplicacion:this.getValue(),
                    co_ejecutor: FondoAvanceEditar.main.co_ejecutor.getValue()
                }
            });
         FondoAvanceEditar.main.store_lista.removeAll();
         FondoAvanceEditar.main.co_decreto.setValue('');
         FondoAvanceEditar.main.mo_disponible.setValue('');
        }
    }
});

//this.storeCO_APLICACION.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_aplicacion,
	value:  this.OBJ.co_aplicacion,
	objStore: this.storeCO_APLICACION
});

this.co_decreto = new Ext.form.ComboBox({
	fieldLabel:'Decreto',
	store: this.storeCO_DECRETO,
	typeAhead: true,
	valueField: 'nu_fi',
	displayField:'nu_fi',
	hiddenName:'tb146_compromiso_asignacion[co_decreto]',
	//readOnly:(this.OBJ.co_proveedor!='')?true:false,
	//style:(this.OBJ.co_proveedor!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Decreto',
	selectOnFocus: true,
	mode: 'local',
	width:700,
	resizable:true,
	allowBlank:false,
    listeners:{
        select: function(){
            FondoAvanceEditar.main.store_lista.load({
                params:{
                    co_decreto:this.getRawValue(),
                    aplicacion: FondoAvanceEditar.main.co_aplicacion.getValue(),
                    co_ejecutor: FondoAvanceEditar.main.co_ejecutor.getValue()
                },
                callback: function(){
                    FondoAvanceEditar.main.cargarDisponible();
                }                
            });
        }
    }
});

//this.storeCO_APLICACION.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_decreto,
	value:  this.OBJ.co_decreto,
	objStore: this.storeCO_DECRETO
});

/*
this.storeCO_EJECUTOR.load({
    callback:function(){
        if(FondoAvanceEditar.main.OBJ.co_ejecutor!=''){
            FondoAvanceEditar.main.co_ejecutor.setValue(FondoAvanceEditar.main.OBJ.co_ejecutor);
            
            FondoAvanceEditar.main.storeCO_PROYECTO.load({
                    params:{co_ejecutor:FondoAvanceEditar.main.OBJ.co_ejecutor},
                    callback: function(){
                        FondoAvanceEditar.main.co_proyecto.setValue(FondoAvanceEditar.main.OBJ.co_proyecto);
                        
                        
                        
                    }
            });
        } 
    }
});*/

/*

this.co_proyecto = new Ext.form.ComboBox({
	fieldLabel:'Proyecto/Ac',
	store: this.storeCO_PROYECTO,
	typeAhead: true,
	valueField: 'id',
        id:'co_proyecto',
	displayField:'de_proyecto_ac',
	hiddenName:'tb146_compromiso_asignacion[co_proyecto]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:700,
	allowBlank:false
});


this.co_proyecto.on('select',function(cmb,record,index){
        FondoAvanceEditar.main.co_accion.clearValue();
        FondoAvanceEditar.main.storeCO_ACCION.load({params:{co_proyecto:record.get('id')}});
},this);

this.co_accion = new Ext.form.ComboBox({
	fieldLabel:'Accion Especifica',
	store: this.storeCO_ACCION,
	typeAhead: true,
	valueField: 'id',
        id:'co_accion',
	displayField:'accion_especifica',
	hiddenName:'tb146_compromiso_asignacion[co_accion]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:700,
	allowBlank:false,
        listeners:{
            select: function(){
                FondoAvanceEditar.main.storeCO_PARTIDA.baseParams.co_accion = this.getValue();
                FondoAvanceEditar.main.storeCO_PARTIDA.baseParams.co_clase_producto = FondoAvanceEditar.main.OBJ.co_clase_producto;                
                FondoAvanceEditar.main.storeCO_PARTIDA.load();
            }
        }
});

this.co_partida = new Ext.form.ComboBox({
	fieldLabel:'Partida',
	store: this.storeCO_PARTIDA,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_partida',
	hiddenName:'tb146_compromiso_asignacion[co_presupuesto]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:700,
	allowBlank:false,
        listeners:{
            select: function(){
                FondoAvanceEditar.main.cargarDisponible();
            }
        }
});*/

this.mo_disponible = new Ext.form.TextField({
	fieldLabel:'Monto Total',
	name:'mo_disponible',
        readOnly:true,
	style:'background:#c9c9c9;',
	width:500
});

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Partidas',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:200,
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},
    {header: 'Codigo', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'nu_partida'},
    {header: 'Denominacion', width:400,  menuDisabled:true, sortable: true,  dataIndex: 'de_partida'},
    {header: 'Monto', width:200,  menuDisabled:true, sortable: true, renderer: formatoNumero, dataIndex: 'mo_disponible'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){FondoAvanceLista.main.editar.enable();FondoAvanceLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 2000,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.fieldDatosPartida= new Ext.form.FieldSet({
        title: 'Datos del Presupuesto',
        items:[
            this.co_detalle_compra,
            this.co_compras,
            this.hiddenDetalleCompra,
            this.co_ejecutor,
            this.co_aplicacion,
            this.co_decreto,
            /*this.co_proyecto,
            this.co_accion,
            this.co_partida,*/
            this.mo_disponible
        ]
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!FondoAvanceEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        
        resultado = paqueteComunJS.funcion.getJsonByObjStore({
            store:FondoAvanceEditar.main.gridPanel_.getStore()
        });

        FondoAvanceEditar.main.hiddenDetalleCompra.setValue(resultado);        
        FondoAvanceEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoAvance/guardar',
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
                // CompromisoAsignacionLista.main.store_lista.load();
                 FondoAvanceEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        FondoAvanceEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:900,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_compromiso_asignacion,
                    this.co_proveedor,
                    this.fieldProveedor,
                    this.fieldAsignacion,
                    this.fieldDatosPartida,
                    this.co_solicitud,
                    this.gridPanel_
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Carga de Datos',
    modal:true,
    constrain:true,
    width:900,
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
getStoreCO_PARTIDA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storefkcopartida',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'mo_disponible'},
            {name: 'de_partida',
            convert:function(v,r){
            return r.nu_partida+' - '+r.de_partida;
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
getStoreCO_EJECUTOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storefkcoejecutororgano',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_ejecutor'},
            {name: 'ejecutor',
                convert:function(v,r){
                    return r.nu_ejecutor+' - '+r.de_ejecutor;
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
cargarDisponible:function(){

            this.monto = paqueteComunJS.funcion.getSumaColumnaGrid({
                        store:FondoAvanceEditar.main.store_lista,
                        campo:'mo_disponible'
                        });
            FondoAvanceEditar.main.mo_disponible.setValue(this.monto);

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
,getStoreCO_PROVEEDOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CompromisoAsignacion/storefkcoproveedor',
        root:'data',
        fields:[
            {name: 'co_proveedor'}
            ]
    });
    return this.store;
}
,getStoreCO_APLICACION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoAvance/storefkcoaplicacion',
        root:'data',
        fields:[
            {name: 'co_aplicacion'},
            {name: 'nu_anio_fiscal'},
            {name: 'tx_tip_aplicacion'},
            {name: 'tx_aplicacion'},
            {name: 'tx_genera_cheque'},
            {name: 'tx_tip_gasto'},
            {name: 'aplicacion',
                convert:function(v,r){
                    return r.tx_tip_aplicacion+' - '+r.tx_aplicacion;
                }
            }
            ]
    });
    return this.store;
}
,getStoreCO_DECRETO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoAvance/storefkcodecreto',
        root:'data',
        fields:[
            {name: 'nu_fi'},
            ]
    });
    return this.store;
},
verificarProveedor:function(){
            Ext.Ajax.request({
                method:'GET',
                url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Compras/verificarProveedor',
                params:{
                    co_documento: FondoAvanceEditar.main.co_documento.getValue(),
                    tx_rif: FondoAvanceEditar.main.tx_rif.getValue()
                },
                success:function(result, request ) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if(!obj.data){
                        FondoAvanceEditar.main.co_proveedor.setValue("");
                        FondoAvanceEditar.main.co_documento.setValue("");
                        FondoAvanceEditar.main.tx_rif.setValue("");
                        FondoAvanceEditar.main.tx_razon_social.setValue("");

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

                        FondoAvanceEditar.main.co_proveedor.setValue(obj.data.co_proveedor);
                        FondoAvanceEditar.main.tx_razon_social.setValue(obj.data.tx_razon_social);
                        FondoAvanceEditar.main.tx_direccion.setValue(obj.data.tx_direccion);
                       
                    }
                }
 });
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoAvance/storefkgasto',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'nu_partida'},
    {name: 'de_partida'},
    {name: 'mo_disponible'}
           ]
    });
    return this.store;
}
};
Ext.onReady(FondoAvanceEditar.main.init, FondoAvanceEditar.main);
</script>
