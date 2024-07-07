<script type="text/javascript">
Ext.ns("TesoreriaIngresoLista");
function renderRectificacion(val, attr, record) {    
    
    if(record.data.cant_revision>0)
   {
       if(val!=null)
         return '<p style="color:gray"><b>'+val+'</b></p>'     
       
   } /*else if(record.data.co_ruta_actual!=null)
   {        
      if(val!=null)
       return '<p style="color:red"><b>'+val+'</b></p>'        
   }
   else if (record.data.in_obs_soporte==true)
   {        
      if(val!=null)
       return '<p style="color:blue"><b>'+val+'</b></p>'        
   }*/
   else{
       return val
   }
}
TesoreriaIngresoLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

function formatoNro(val){
    
        if(val==null){
            val = 0;
        }
	return '<p align="right">'+paqueteComunJS.funcion.getNumeroFormateado(val)+'</p>';
}
//objeto store
this.store_lista = this.getLista();

this.storeCO_PROCESO = this.getStoreCO_PROCESO();

this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();

this.co_solicitud = new Ext.form.TextField({
	fieldLabel:'N° Solicitud',
	name:'co_solicitud',
        maskRe: /[0-9]/,
	value:'',
	width:100
});

this.co_proceso = new Ext.form.ComboBox({
	fieldLabel:'Proceso',
	store: this.storeCO_PROCESO,
	typeAhead: true,
	valueField: 'co_proceso',
	displayField:'tx_proceso',
	hiddenName:'co_proceso',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	allowBlank:false
});
this.storeCO_PROCESO.load();

this.co_documento = new Ext.form.ComboBox({
	fieldLabel:'documento',
	store: this.storeCO_DOCUMENTO,
	typeAhead: true,
	valueField: 'co_documento',
	displayField:'inicial',
	hiddenName:'co_documento',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'...',
	selectOnFocus: true,
	mode: 'local',
	width:40,
	allowBlank:false
});

this.storeCO_DOCUMENTO.load();

this.tx_razon_social = new Ext.form.TextField({
	fieldLabel:'Nombre',
	name:'tx_razon_social',
	value:'',
	width:700
});

this.nu_cedula_rif = new Ext.form.TextField({
	fieldLabel:'Nu cedula',
        name:'nu_cedula_rif',
        maskRe: /[0-9]/, 
	value:'',
	width:155
});

this.compositefieldCIRIF = new Ext.form.CompositeField({
fieldLabel: 'Cedula / Rif',
items: [
	this.co_documento,
	this.nu_cedula_rif,
	]
});

/**
* <Form Principal que carga el Filtro>
*/
this.formFiltroPrincipal = new Ext.form.FormPanel({
    title:'Lista de Ingresos Pendientes',
    iconCls: 'icon-solpendiente',
    collapsible: true,
    titleCollapse: true,
    autoWidth:true,
    border:false,
    labelWidth: 110,
    padding:'10px',
    items   : [
        this.compositefieldCIRIF,
        this.tx_razon_social,        
	this.co_solicitud,
//        this.co_proceso
    ],
    keys: [{
		key:[Ext.EventObject.ENTER],
		handler: function() {
			 TesoreriaIngresoLista.main.aplicarFiltroByFormulario();
		}}
    ],
    buttonAlign:'center',
    buttons:[
        {
            text:'Consultar',
            iconCls:'icon-buscar',
            handler:function(){
                TesoreriaIngresoLista.main.aplicarFiltroByFormulario();
            }
        },
        {
            text:'Limpiar',
            iconCls:'icon-limpiar',
            handler:function(){
                TesoreriaIngresoLista.main.limpiarCamposByFormFiltro();
            }
        }
    ]
});

this.botonPagar = new Ext.Button({
    text:'Ingresar',
    iconCls:'icon-pagos',
    handler:function(){
        this.co_liquidacion_pago = TesoreriaIngresoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_cuenta_detalle');
        this.co_solicitud = TesoreriaIngresoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_solicitud');
        this.co_tipo_solicitud = TesoreriaIngresoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_tipo_solicitud');
                var msg = Ext.get('muestra_contrib');
                    msg.load({
                    url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngreso/ingresar',
                    scripts: true,
                    params:{
                        co_liquidacion_pago: this.co_liquidacion_pago,
                        co_solicitud: this.co_solicitud,
                        co_tipo_solicitud: this.co_tipo_solicitud
                    },
                    text: 'Cargando...'
                    });
                    msg.show();
        
    }
});

this.botonPagar.setDisabled(true);
//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    //title:'Lista de TesoreriaIngreso',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:396,
    tbar:[
        this.botonPagar
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_cuenta_detalle',hidden:true, menuDisabled:true,dataIndex: 'co_cuenta_detalle'},
    {header: 'N° Solicitud', width:100,menuDisabled:true,dataIndex: 'co_solicitud',renderer: renderRectificacion}, 
    {header: 'RIF', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_rif'},
    {header: 'Razon Social', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tx_razon_social'},
    {header: 'Tipo de solicitud', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tipo_solicitud',renderer: renderRectificacion},
    {header: 'fecha', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_pago',renderer: renderRectificacion},
    {header: 'Monto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_cuota',renderer: formatoNro},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{
        cellclick:function(Grid, rowIndex, columnIndex,e ){
        
        TesoreriaIngresoLista.main.botonPagar.enable();
        
        var cant_revision =  TesoreriaIngresoLista.main.store_lista.getAt(rowIndex).get('cant_revision');
                
        if(cant_revision>0){
            TesoreriaIngresoLista.main.estado.disable();  
        }        
    
//        var msg = Ext.get('detalle');
//        msg.load({
//            url: '<?php echo $_SERVER['SCRIPT_NAME']?>/TesoreriaIngreso/detalle',
//            scripts: true,
//            params:
//            {
//                codigo: TesoreriaIngresoLista.main.store_lista.getAt(rowIndex).get('co_solicitud'),
//                co_tipo_solicitud: TesoreriaIngresoLista.main.store_lista.getAt(rowIndex).get('co_tipo_solicitud'),
//                co_proceso: TesoreriaIngresoLista.main.store_lista.getAt(rowIndex).get('co_proceso')
//
//            },
//            text: 'Cargando...'
//        });
//    
//
//        if(panel_detalle.collapsed == true)
//        {
//        panel_detalle.toggleCollapse();
//        } 

    }},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.panel = new Ext.Panel({
//	title: 'Lista de contribuyente',
	border:false,
	items: [
        this.formFiltroPrincipal,
        this.gridPanel_
    ]
});

this.panel.render("contenedorTesoreriaIngresoLista");

this.store_lista.load();
this.store_lista.on('load',function(){
TesoreriaIngresoLista.main.botonPagar.disable();
});
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngreso/storelista',
    root:'data',
    fields:[
            {name: 'mo_cuota'},
            {name: 'co_cuenta_detalle'},
            {name: 'tx_tipo_solicitud'},
            {name: 'co_solicitud'},
            {name: 'fe_pago'},
            {name: 'cant_revision'},
            {name: 'co_tipo_solicitud'},
            {name: 'tx_rif'},
            {name: 'tx_razon_social'}
    ]
    });
    return this.store;
}
,getStoreCO_PROCESO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/storefkcoproceso',
        root:'data',
        fields:[
            {name: 'co_proceso'},
            {name: 'tx_proceso'}
            ]
    });
    return this.store;
},
getStoreCO_DOCUMENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Tesoreria/storefkcodocumento',
        root:'data',
        fields:[
            {name: 'co_documento'},
            {name: 'inicial'}
            ]
    });
    return this.store;
},
aplicarFiltroByFormulario: function(){
	//Capturamos los campos con su value para posteriormente verificar cual
	//esta lleno y trabajar en base a ese.
	var campo = TesoreriaIngresoLista.main.formFiltroPrincipal.getForm().getValues();

         if(panel_detalle.collapsed == false)
         {
             panel_detalle.toggleCollapse();
         } 


	TesoreriaIngresoLista.main.store_lista.baseParams={}

	var swfiltrar = false;
	for(campName in campo){
	    if(campo[campName]!=''){
		swfiltrar = true;
		eval(" TesoreriaIngresoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
	    }
	}
	if(swfiltrar==true){
	    TesoreriaIngresoLista.main.store_lista.baseParams.BuscarBy = true;
           // pendientePagosLista.main.store_lista.baseParams.in_ventanilla = 'true';
	    TesoreriaIngresoLista.main.store_lista.load();
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
TesoreriaIngresoLista.main.formFiltroPrincipal.getForm().reset();
TesoreriaIngresoLista.main.store_lista.baseParams={};
TesoreriaIngresoLista.main.store_lista.load();
}
};
Ext.onReady(TesoreriaIngresoLista.main.init, TesoreriaIngresoLista.main);
</script>
<div id="contenedorTesoreriaIngresoLista"></div>
<div id="formularioTesoreriaIngreso"></div>
<div id="filtroTesoreriaIngreso"></div>
