<script type="text/javascript">
Ext.ns("pendienteEntidadesLista");
pendienteEntidadesLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){


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
	//readOnly:(this.OBJ.co_proceso!='')?true:false,
	//style:(this.main.OBJ.co_proceso!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
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
	//readOnly:(this.OBJ.co_documento!='')?true:false,
	//style:(this.main.OBJ.co_documento!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'...',
	selectOnFocus: true,
	mode: 'local',
	width:40,
	resizable:true,
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
    title:'Lista de Solicitudes Pendientes',
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
        this.co_proceso
       
    ],
    keys: [{
		key:[Ext.EventObject.ENTER],
		handler: function() {
			 pendienteEntidadesLista.main.aplicarFiltroByFormulario();
		}}
    ],
    buttonAlign:'center',
    buttons:[
        {
            text:'Consultar',
            iconCls:'icon-buscar',
            handler:function(){
                pendienteEntidadesLista.main.aplicarFiltroByFormulario();
            }
        },
        {
            text:'Limpiar',
            iconCls:'icon-limpiar',
            handler:function(){
                pendienteEntidadesLista.main.limpiarCamposByFormFiltro();
            }
        }
    ]
});

//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

this.estado= new Ext.Button({
    text:'Cambiar Estatus',
    iconCls: 'icon-cambio',
    handler: this.onEstatus
});

this.revision= new Ext.Button({
    text:'Enviar a Revisión',
    iconCls: 'icon-volver',
    handler: this.onRevision
});

function renderRectificacion(val, attr, record) {    
    
     if(record.data.cant_revision>0)
    {
        if(val!=null)
          return '<p style="color:gray"><b>'+val+'</b></p>'     
        
    } 
    else{
        return val
    }
}

this.gridPanel_ = new Ext.grid.GridPanel({
//    title:'Lista de solicitud',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:396,
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'N° Solicitud', width:100,menuDisabled:true,dataIndex: 'co_solicitud',renderer: renderRectificacion}, 
    {header: 'RIF', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_rif',renderer: renderRectificacion},
    {header: 'Razon Social', width:350,  menuDisabled:true, sortable: true,  dataIndex: 'tx_razon_social',renderer: textoLargo},
 
    {header: 'Tipo de solicitud', width:250,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tipo_solicitud',renderer: renderRectificacion},
//    {header: 'Proceso', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'tx_proceso',renderer: renderRectificacion},
    {header: 'Orden de Pago', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'tx_serial',renderer: renderRectificacion},
  //  {header: 'Creado Por', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'tx_login',renderer: renderRectificacion},
  //  {header: 'Fecha', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_creacion',renderer: renderRectificacion}
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
	
         pendienteEntidadesLista.main.estado.enable();
         pendienteEntidadesLista.main.revision.enable();
         
         var cant_revision =  pendienteEntidadesLista.main.store_lista.getAt(rowIndex).get('cant_revision');
                 
         if(cant_revision>0){
            pendienteEntidadesLista.main.estado.disable();  
         }        
        
         var msg = Ext.get('detalle');
         msg.load({
                url: '<?php echo $_SERVER['SCRIPT_NAME']?>/Solicitud/detalleEntidadesAnular',
                scripts: true,
                params:
                {
                    codigo: pendienteEntidadesLista.main.store_lista.getAt(rowIndex).get('co_solicitud'),
                    co_tipo_solicitud: pendienteEntidadesLista.main.store_lista.getAt(rowIndex).get('co_tipo_solicitud'),
                    co_proceso: pendienteEntidadesLista.main.store_lista.getAt(rowIndex).get('co_proceso')

                },
                text: 'Cargando...'
         });
        
    
         if(panel_detalle.collapsed == true)
         {
            panel_detalle.toggleCollapse();
         } 
    
    }},
    bbar: new Ext.PagingToolbar({
        pageSize: 15,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});
this.store_lista.load();
this.panel = new Ext.Panel({
//	title: 'Lista de contribuyente',
	border:false,
	items: [this.formFiltroPrincipal,this.gridPanel_]
});

this.panel.render("contenedorpendienteEntidadesLista");

},
onRevision: function(){

         
        this.msg = Ext.get('formulariosolicitud');
        this.msg.load({
            url:"<?php echo $_SERVER["SCRIPT_NAME"] ?>/Revision",
            params:{codigo:pendienteEntidadesLista.main.gridPanel_.getSelectionModel().getSelected().get('co_solicitud')},
            scripts: true,
            text: "Cargando.."
        });
         
         
      
},
onEstatus: function(){
        this.msg = Ext.get('formulariosolicitud');
        this.msg.load({
            url:"<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/estado",
            params:{codigo:pendienteEntidadesLista.main.gridPanel_.getSelectionModel().getSelected().get('co_solicitud')},
            scripts: true,
            text: "Cargando.."
        });
},
onReporte:function(){
        this.msg = Ext.get('formulariosolicitud');
        this.msg.load({
         url:"<?php echo $_SERVER["SCRIPT_NAME"] ?>/reporte/ReporteSolicitudesPendientesVentanilla",
         scripts: true,
         text: "Cargando.."
        });
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Directorio/storelistaanulado',
    root:'data',
    fields:[ 
            {name: 'tx_login'},
            {name: 'tx_tipo_solicitud'},
            {name: 'co_solicitud'},
            {name: 'fe_creacion'},
            {name: 'cant_revision'},
            {name: 'tx_proceso'},
            {name: 'co_tipo_solicitud'},
            {name: 'co_proceso'},
            {name: 'tx_rif'},
            {name: 'tx_serial'},
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
},
aplicarFiltroByFormulario: function(){
	//Capturamos los campos con su value para posteriormente verificar cual
	//esta lleno y trabajar en base a ese.
	var campo = pendienteEntidadesLista.main.formFiltroPrincipal.getForm().getValues();

         if(panel_detalle.collapsed == false)
         {
             panel_detalle.toggleCollapse();
         } 


	pendienteEntidadesLista.main.store_lista.baseParams={}

	var swfiltrar = false;
	for(campName in campo){
	    if(campo[campName]!=''){
		swfiltrar = true;
		eval(" pendienteEntidadesLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
	    }
	}
	if(swfiltrar==true){
	    pendienteEntidadesLista.main.store_lista.baseParams.BuscarBy = true;
           // pendienteEntidadesLista.main.store_lista.baseParams.in_ventanilla = 'true';
	    pendienteEntidadesLista.main.store_lista.load();
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
	pendienteEntidadesLista.main.formFiltroPrincipal.getForm().reset();
	pendienteEntidadesLista.main.store_lista.baseParams={};
	pendienteEntidadesLista.main.store_lista.load();
}
};
Ext.onReady(pendienteEntidadesLista.main.init, pendienteEntidadesLista.main);
</script>
<div id="contenedorpendienteEntidadesLista"></div>
<div id="formulariosolicitud"></div>
<div id="filtrosolicitud"></div>
<div id="formulariocontribuyente"></div>
