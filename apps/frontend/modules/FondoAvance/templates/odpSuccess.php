<script type="text/javascript">
Ext.ns("CompromisoAsignacionEditar");
CompromisoAsignacionEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_PROVEEDOR = this.getStoreCO_PROVEEDOR();
this.storeCO_SOLICITUD = this.getStoreCO_SOLICITUD();
this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
this.storeCO_PARTIDA  = this.getStoreCO_PARTIDA();
this.storeCO_PROYECTO = this.getStoreCO_PROYECTO();
this.storeCO_ACCION   = this.getStoreCO_ACCION();
this.storeCO_EJECUTOR = this.getStoreCO_EJECUTOR();
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



this.co_compras  = new Ext.form.Hidden({
        name:'tb146_compromiso_asignacion[co_compras]',
        value:this.OBJ.co_compras
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
this.co_documento.on("blur",function(){
    if(CompromisoAsignacionEditar.main.tx_rif.getValue()!=''){
    CompromisoAsignacionEditar.main.verificarProveedor();
    }
});

this.tx_rif.on("blur",function(){
    CompromisoAsignacionEditar.main.verificarProveedor();
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
        readOnly:true,
	style:'background:#c9c9c9;',
	allowBlank:false,
	width:600
});

this.tx_direccion = new Ext.form.TextField({
	fieldLabel:'Direccion',
	name:'tb008_proveedor[tx_direccion]',
	value:this.OBJ.tx_direccion,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;',
	width:600
});

this.fieldProveedor= new Ext.form.FieldSet({
        title: 'Datos del Proveedor',
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
        readOnly:true,
	style:'background:#c9c9c9;',
	width:400
});

this.nu_cancelacion = new Ext.form.NumberField({
	fieldLabel:'Nro. Cancelación',
	name:'tb146_compromiso_asignacion[nu_cancelacion]',
	value:this.OBJ.nu_cancelacion,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;',
        width:50
});

this.fe_compromiso = new Ext.form.DateField({
	fieldLabel:'Fecha',
	name:'tb146_compromiso_asignacion[fe_compromiso]',
	value:this.OBJ.fe_compromiso,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;',
	width:100
});

this.nu_monto = new Ext.form.NumberField({
	fieldLabel:'Monto Total',
	name:'tb146_compromiso_asignacion[nu_monto]',
	value:this.OBJ.nu_monto,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;',
        width:200
});

this.fieldAsignacion= new Ext.form.FieldSet({
        title: 'Datos de la Asignación',
        items:[
            this.co_compras,
            this.tx_descripcion,
            this.nu_cancelacion,
            this.fe_compromiso,
            this.nu_monto
       ]
});


//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Fondo Avance',
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


//CompromisoAsignacionEditar.main.store_lista.load({
//    params:{
//        co_decreto:CompromisoAsignacionEditar.main.OBJ.getValue(),
//        aplicacion: CompromisoAsignacionEditar.main.OBJ.getValue(),
//        co_ejecutor: CompromisoAsignacionEditar.main.OBJ.co_ejecutor()
//    }             
//});



this.fieldDatosPartida= new Ext.form.FieldSet({
        title: 'Datos de las partidas',
        items:[
               this.gridPanel_]
});

this.guardar = new Ext.Button({
    text:'Generar ODP',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!CompromisoAsignacionEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        CompromisoAsignacionEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoAvance/generarODP',
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
                 CompromisoAsignacionEditar.main.winformPanel_.close();
             }
        });

   
    }
});

if(this.OBJ.co_orden_pago!=null){
    this.guardar.disable();
}

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        CompromisoAsignacionEditar.main.winformPanel_.close();
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
                    //this.fieldDatosPartida,
                    this.co_solicitud,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Compromiso Asignacion',
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
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storefkcoejecutor',
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
    Ext.Ajax.request({
        method:'GET',
        url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Presupuesto/cargarDisponible',
        params:{
            co_partida: CompromisoAsignacionEditar.main.co_partida.getValue()
        },
        success:function(result, request ) {
            obj = Ext.util.JSON.decode(result.responseText);
            CompromisoAsignacionEditar.main.mo_disponible.setValue(paqueteComunJS.funcion.getNumeroFormateado(obj.data.mo_disponible));
        }
    });
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
,getStoreCO_SOLICITUD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CompromisoAsignacion/storefkcosolicitud',
        root:'data',
        fields:[
            {name: 'co_solicitud'}
            ]
    });
    return this.store;
},
verificarProveedor:function(){
            Ext.Ajax.request({
                method:'GET',
                url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Compras/verificarProveedor',
                params:{
                    co_documento: CompromisoAsignacionEditar.main.co_documento.getValue(),
                    tx_rif: CompromisoAsignacionEditar.main.tx_rif.getValue()
                },
                success:function(result, request ) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if(!obj.data){
                        CompromisoAsignacionEditar.main.co_proveedor.setValue("");
                        CompromisoAsignacionEditar.main.co_documento.setValue("");
                        CompromisoAsignacionEditar.main.tx_rif.setValue("");
                        CompromisoAsignacionEditar.main.tx_razon_social.setValue("");

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

                        CompromisoAsignacionEditar.main.co_proveedor.setValue(obj.data.co_proveedor);
                        CompromisoAsignacionEditar.main.tx_razon_social.setValue(obj.data.tx_razon_social);
                        CompromisoAsignacionEditar.main.tx_direccion.setValue(obj.data.tx_direccion);
                       
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
Ext.onReady(CompromisoAsignacionEditar.main.init, CompromisoAsignacionEditar.main);
</script>
