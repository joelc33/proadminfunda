<script type="text/javascript">
Ext.ns("listaRevision");
listaRevision.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.storeCO_PROCESO = this.getStoreCO_PROCESO();

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


/**
* <Form Principal que carga el Filtro>
*/
this.formFiltroPrincipal = new Ext.form.FormPanel({
    title:'Lista de Solicitudes Pendientes por Revisión',
    iconCls: 'icon-solpendiente',
    collapsible: true,
    titleCollapse: true,
    autoWidth:true,
    border:false,
    labelWidth: 110,
    padding:'10px',
    items   : [
	this.co_solicitud,
        this.co_proceso/*,
        this.compositefieldCIRIF,
        this.tx_razon_social*/
    ],
    keys: [{
		key:[Ext.EventObject.ENTER],
		handler: function() {
			 listaRevision.main.aplicarFiltroByFormulario();
		}}
    ],
    buttonAlign:'center',
    buttons:[
        {
            text:'Consultar',
            iconCls:'icon-buscar',
            handler:function(){
                listaRevision.main.aplicarFiltroByFormulario();
            }
        },
        {
            text:'Limpiar',
            iconCls:'icon-limpiar',
            handler:function(){
                listaRevision.main.limpiarCamposByFormFiltro();
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

function renderArchivo(val, attr, record) {
    
    if(val!=null){
        return '<a href="#" onclick="listaRevision.main.getDocumento()">Ver Documento</a>'        
    }
    
}


this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de tramites pendientes por revisión',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:396,
    columns: [
    new Ext.grid.RowNumberer(),
        {header: 'co_revision', hidden: true, width:100,menuDisabled:true,dataIndex: 'co_revision'}, 
        {header: 'N° Solicitud', width:80,menuDisabled:true,dataIndex: 'co_solicitud'}, 
        {header: 'Tipo de solicitud', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tipo_solicitud'},
        {header: 'Proceso', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_proceso'},
        {header: 'Enviado Por', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'tx_login'},
        {header: 'Fecha Envio', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_creacion'},
        {header: 'Documento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mime_documento',renderer: renderArchivo}
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
	
         listaRevision.main.estado.enable();
         listaRevision.main.revision.enable();
        
         var msg = Ext.get('detalle');
         msg.load({
                url: '<?php echo $_SERVER['SCRIPT_NAME']?>/Revision/detalleEntidades',
                scripts: true,
                params:
                {
                    codigo: listaRevision.main.store_lista.getAt(rowIndex).get('co_revision')

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

this.panel = new Ext.Panel({
//	title: 'Lista de contribuyente',
	border:false,
	items: [this.formFiltroPrincipal,this.gridPanel_]
});

this.panel.render("contenedorlistaRevision");

//Cargar el grid
this.store_lista.baseParams.paginar = 'si';
this.store_lista.baseParams.in_ventanilla = 'true';
this.store_lista.load();
this.store_lista.on('load',function(){
listaRevision.main.estado.disable();
listaRevision.main.revision.disable();
});
},getDocumento: function(co_revision){        
    window.open("<?php echo $_SERVER['SCRIPT_NAME']; ?>/Documento/archivoRecibidoRevision?co_revision="+listaRevision.main.gridPanel_.getSelectionModel().getSelected().get('co_revision'));
},
onRevision: function(){

         
        this.msg = Ext.get('formulariosolicitud');
        this.msg.load({
            url:"<?php echo $_SERVER["SCRIPT_NAME"] ?>/Revision",
            params:{codigo:listaRevision.main.gridPanel_.getSelectionModel().getSelected().get('co_solicitud')},
            scripts: true,
            text: "Cargando.."
        });
         
         
      
},
onEstatus: function(){
        this.msg = Ext.get('formulariosolicitud');
        this.msg.load({
            url:"<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/estado",
            params:{codigo:listaRevision.main.gridPanel_.getSelectionModel().getSelected().get('co_solicitud')},
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
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Revision/storelista',
    root:'data',
    fields:[ 
            {name: 'tx_login'},
            {name: 'tx_tipo_solicitud'},
            {name: 'co_solicitud'},
            {name: 'fe_creacion'},
            {name: 'mime_documento'},
            {name: 'co_revision'},
            {name: 'tx_proceso'}
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
aplicarFiltroByFormulario: function(){
	//Capturamos los campos con su value para posteriormente verificar cual
	//esta lleno y trabajar en base a ese.
	var campo = listaRevision.main.formFiltroPrincipal.getForm().getValues();

         if(panel_detalle.collapsed == false)
         {
             panel_detalle.toggleCollapse();
         } 


	listaRevision.main.store_lista.baseParams={}

	var swfiltrar = false;
	for(campName in campo){
	    if(campo[campName]!=''){
		swfiltrar = true;
		eval(" listaRevision.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
	    }
	}
	if(swfiltrar==true){
	    listaRevision.main.store_lista.baseParams.BuscarBy = true;
            listaRevision.main.store_lista.baseParams.in_ventanilla = 'true';
	    listaRevision.main.store_lista.load();
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
	listaRevision.main.formFiltroPrincipal.getForm().reset();
	listaRevision.main.store_lista.baseParams={};
	listaRevision.main.store_lista.load();
}
};
Ext.onReady(listaRevision.main.init, listaRevision.main);
</script>
<div id="contenedorlistaRevision"></div>
<div id="formulariosolicitud"></div>
<div id="filtrosolicitud"></div>
<div id="formulariocontribuyente"></div>
