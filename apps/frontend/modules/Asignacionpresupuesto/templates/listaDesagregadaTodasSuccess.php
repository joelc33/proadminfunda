<script type="text/javascript">
Ext.ns("PartidapresupuestoListaDesagregada");
PartidapresupuestoListaDesagregada.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
    
this.storeCO_EJECUTOR   = this.getStoreCO_EJECUTOR();
this.storeCO_APLICACION = this.getStoreCO_APLICACION();
this.storeCO_DECRETO    = this.getStoreCO_DECRETO();
this.storeANIO          = this.getStoreANIO();

//this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

    
this.co_ejecutor = new Ext.form.ComboBox({
	fieldLabel:'Ente Ejecutor',
	store: this.storeCO_EJECUTOR,
	typeAhead: true,
	valueField: 'id',
        id:'co_ejecutor',
	displayField:'ejecutor',
	hiddenName:'co_ejecutor',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:800,
        listeners: {
            getSelectedIndex: function() {             
                var v = this.getValue();
                var r = this.findRecord(this.valueField || this.displayField, v);
                return(this.storeCO_EJECUTOR.indexOf(r));
             },
        select: function(){
            PartidapresupuestoListaDesagregada.main.storeCO_DECRETO.load({
                params:{
                    co_ejecutor:this.getValue()
                }
            });
            
            PartidapresupuestoListaDesagregada.main.storeCO_APLICACION.load({
                params:{
                    co_ejecutor:this.getValue()
                }
            });             
        }             
        }
});
this.storeCO_EJECUTOR.load();

this.co_aplicacion = new Ext.form.ComboBox({
	fieldLabel:'Aplicacion',
	store: this.storeCO_APLICACION,
	typeAhead: true,
	valueField: 'co_aplicacion',
	displayField:'aplicacion',
        id:'tip_apl',
	hiddenName:'tip_apl',
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
            PartidapresupuestoListaDesagregada.main.storeCO_DECRETO.load({
                params:{
                    aplicacion:this.getValue(),
                    co_ejecutor: PartidapresupuestoListaDesagregada.main.co_ejecutor.getValue()
                }
            });
        }
    }
});

this.co_decreto = new Ext.form.ComboBox({
	fieldLabel:'Decreto',
	store: this.storeCO_DECRETO,
	typeAhead: true,
	valueField: 'nu_fi',
	displayField:'nu_fi',
	hiddenName:'nu_fi',
        id:'nu_fi',
	//readOnly:(this.OBJ.co_proveedor!='')?true:false,
	//style:(this.OBJ.co_proveedor!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Decreto',
	selectOnFocus: true,
	mode: 'local',
	width:700,
	allowBlank:false
});

this.anio_fiscal = new Ext.form.ComboBox({
	fieldLabel:'Año Fiscal',
	store: this.storeANIO,
	typeAhead: true,
	valueField: 'tx_anio_fiscal',
	displayField:'tx_anio_fiscal',
	hiddenName:'tx_anio_fiscal',
        id:'nu_fi',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	allowBlank:false
});

this.storeANIO.load();

this.monto = new Ext.form.NumberField({
	fieldLabel:'Monto Disponible',
	name:'monto',
      	width:215
});


this.nu_decreto = new Ext.form.NumberField({
	fieldLabel:'Nº Decreto',
	name:'nu_decreto',
      	width:215
});

this.editar= new Ext.Button({
    text:'Movimientos',
    iconCls: 'icon-reporteest',
    handler:function(){
	//PartidapresupuestoLista.main.mascara.show();
        this.msg = Ext.get('formularioPartidapresupuesto');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/lista',
         scripts: true,
         text: "Cargando..",
         params:{
             codigo: PartidapresupuestoListaDesagregada.main.gridPanel_.getSelectionModel().getSelected().get('id')
         }
        });
    }
});

this.formFiltroPrincipal = new Ext.form.FormPanel({
    title:'Lista ',
    iconCls: 'icon-solpendiente',
    collapsible: true,
    titleCollapse: true,
    autoWidth:true,
    border:false,
    labelWidth: 110,
    padding:'10px',
    items   : [
        this.co_ejecutor,
        this.co_aplicacion,
        this.co_decreto,
        this.anio_fiscal
    ],
    keys: [{
            key:[Ext.EventObject.ENTER],
            handler: function() {
                     PartidapresupuestoListaDesagregada.main.aplicarFiltroByFormulario();
            }}
    ],
    buttonAlign:'center',
    buttons:[
        {
            text:'Consultar',
            iconCls:'icon-buscar',
            handler:function(){
                    PartidapresupuestoListaDesagregada.main.aplicarFiltroByFormulario();
            }
        }
    ]
});

this.excel = new Ext.Button({
    text:'Exportar a XLS',
    iconCls:'icon-libro',
    handler: this.onExportarPresupuesto
});

function formatoNro(val){
	return '<p align="right">'+paqueteComunJS.funcion.getNumeroFormateado(val)+'</p>';
}

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    //title:'Lista de Partidapresupuesto',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:400,
    border:false,
    tbar:[
        this.editar,'-',this.excel
    ],
    columns: [
    new Ext.grid.RowNumberer(),
        {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},    
        {header: 'Codigo', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'nu_partida'},        
        {header: 'Descripcion', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'de_partida'},
        {header: 'Inicial', width:100,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'mo_inicial'},
        {header: 'Modificado', width:100,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'mo_actualizado'},
        {header: 'Comprometido', width:80,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'mo_comprometido'},
        {header: 'Causado', width:100,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'mo_causado'},
        {header: 'Pagado', width:100,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'mo_pagado'},
        {header: 'Disponible', width:150,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'mo_disponible'},
        {header: 'Aplicación', width:350,  menuDisabled:true, sortable: true,  dataIndex: 'aplicacion'}
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    bbar: new Ext.PagingToolbar({
        pageSize: 15,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});
this.formFiltroPrincipal.render("filtroPartidapresupuesto");
this.gridPanel_.render("contenedorPartidapresupuestoListaDesagregada");

//this.winformPanel_ = new Ext.Window({
//    title:'Formulario: Partidas',
//    modal:true,
//    constrain:true,
//    width:1300,
//    frame:true,
//    closabled:true,
//    autoHeight:true,
//    items:[
//        this.formFiltroPrincipal,
//        this.gridPanel_
//    ]
//});
//this.winformPanel_.show();
//PartidapresupuestoListaDesagregada.main.mascara.hide();

//PartidapresupuestoListaDesagregada.main.store_lista.baseParams.nu_partida=PartidapresupuestoListaDesagregada.main.OBJ.nu_partida;
//PartidapresupuestoListaDesagregada.main.store_lista.baseParams.co_accion_especifica=PartidapresupuestoListaDesagregada.main.OBJ.co_accion_especifica;
//this.store_lista.load();

},
aplicarFiltroByFormulario: function(){
	//Capturamos los campos con su value para posteriormente verificar cual
	//esta lleno y trabajar en base a ese.
	var campo = PartidapresupuestoListaDesagregada.main.formFiltroPrincipal.getForm().getValues();

        PartidapresupuestoListaDesagregada.main.store_lista.baseParams={}

	var swfiltrar = false;
	for(campName in campo){
	    if(campo[campName]!=''){
		swfiltrar = true;
		eval(" PartidapresupuestoListaDesagregada.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
	    }
	}
	if(swfiltrar==true){
	    PartidapresupuestoListaDesagregada.main.store_lista.baseParams.BuscarBy = true;
           // PartidapresupuestoListaDesagregada.main.store_lista.baseParams.in_ventanilla = 'true';
	    PartidapresupuestoListaDesagregada.main.store_lista.load();
	}else{
	    Ext.MessageBox.show({
		       title: 'Notificación',
		       msg: 'Debe ingresar un parametro de busqueda',
		       buttons: Ext.MessageBox.OK,
		       icon: Ext.MessageBox.WARNING
	    });
	}

	},
	limpiarCamposByFormFiltro: function(){
	PartidapresupuestoListaDesagregada.main.formFiltroPrincipal.getForm().reset();
	PartidapresupuestoListaDesagregada.main.store_lista.baseParams={};
	PartidapresupuestoListaDesagregada.main.store_lista.load();
}, 
onExportarPresupuesto : function() {
    
   var co_ejecutor = PartidapresupuestoListaDesagregada.main.co_ejecutor.getValue();
   var co_aplicacion = PartidapresupuestoListaDesagregada.main.co_aplicacion.getValue();
   var co_decreto = PartidapresupuestoListaDesagregada.main.co_decreto.getValue();
    
   window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/presupuesto_XLS.php?co_ejecutor='+co_ejecutor+'&co_aplicacion='+co_aplicacion+'&co_decreto='+co_decreto);
},
getStoreCO_EJECUTOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoejecutor',
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
}
,getStoreCO_APLICACION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/storefkcoaplicacion',
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
},getStoreANIO: function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Asignacionpresupuesto/storefkAnioFiscal',
        root:'data',
        fields:[
            {name: 'tx_anio_fiscal'},
        ]
    });
    return this.store;
}
,getStoreCO_DECRETO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/storefkcodecreto',
        root:'data',
        fields:[
            {name: 'nu_fi'},
            ]
    });
    return this.store;
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Asignacionpresupuesto/storelistaDesagregadaTodas',
    root:'data',
    fields:[
            {name: 'id'},
            {name: 'id_tb084_accion_especifica'},
            {name: 'nu_partida'},
            {name: 'de_partida'},
            {name: 'mo_inicial'},
            {name: 'mo_actualizado'},
            {name: 'mo_precomprometido'},
            {name: 'mo_comprometido'},
            {name: 'mo_causado'},
            {name: 'mo_pagado'},
            {name: 'mo_disponible'},
            {name: 'tx_cuenta'},
            {name: 'nu_nivel'},
            {name: 'aplicacion'}
           ]
    });
    return this.store;
}
};
Ext.onReady(PartidapresupuestoListaDesagregada.main.init, PartidapresupuestoListaDesagregada.main);
</script>
<div id="filtroPartidapresupuesto"></div>
<div id="contenedorPartidapresupuestoListaDesagregada"></div>
<div id="formularioPartidapresupuesto"></div>
<div id="filtroPartidapresupuesto"></div>
