<script type="text/javascript">
Ext.ns("solicitudLista");
solicitudLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});


this.co_solicitud = new Ext.form.TextField({
	fieldLabel:'N° Solicitud',
	name:'co_solicitud',
        maskRe: /[0-9]/,
	value:'',
	width:100
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
	this.co_solicitud/*,
        this.compositefieldCIRIF,
        this.tx_razon_social*/
    ],
    keys: [{
		key:[Ext.EventObject.ENTER],
		handler: function() {
			 solicitudLista.main.aplicarFiltroByFormulario();
		}}
    ],
    buttonAlign:'center',
    buttons:[
        {
            text:'Consultar',
            iconCls:'icon-buscar',
            handler:function(){
                solicitudLista.main.aplicarFiltroByFormulario();
            }
        },
        {
            text:'Limpiar',
            iconCls:'icon-limpiar',
            handler:function(){
                solicitudLista.main.limpiarCamposByFormFiltro();
            }
        }
    ]
});

//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

//Estado registro
this.estado= new Ext.Button({
    text:'Enviar Tramite',
    iconCls: 'icon-volver',
    handler: function(){
   
        /* */ 
        Ext.MessageBox.confirm('Confirmación', '¿Realmente desea enviar este tramite?', function(boton){
                if(boton=="yes"){
                    this.msg = Ext.get('formulariosolicitud');
                    this.msg.load({
                    url:"<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/enviarEntidades",
                    params:{co_solicitud:solicitudLista.main.gridPanel_.getSelectionModel().getSelected().get('co_solicitud')},
                    scripts: true,
                    text: "Cargando.."
                    });   
                }
           });/**/
		   
	}
    
});

this.nueva_solicitud= new Ext.Button({
    text: 'Nueva solicitud',
    iconCls: 'icon-nuevo',
            handler:function(){
//                                contribuyenteLista.main.mascara.show();
                    this.msg = Ext.get('formulariocontribuyente');
                    this.msg.load({
                    url:"<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/nuevaSolicitud",
                    scripts: true,
                    text: "Cargando.."
            });
    }
});

this.anular = new Ext.Button({
    text:'Anular Tramite',
    iconCls: 'icon-anteriores',
    handler: function(){
   
        /* */ 
        Ext.MessageBox.confirm('Confirmación', '¿Realmente desea anular este tramite?', function(boton){
                if(boton=="yes"){
                    this.msg = Ext.get('formulariosolicitud');
                    this.msg.load({
                    url:"<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/enviarAnular",
                    params:{co_solicitud:solicitudLista.main.gridPanel_.getSelectionModel().getSelected().get('co_solicitud')},
                    scripts: true,
                    text: "Cargando.."
                    });   
                }
           });/**/
		   
	}
    
});


this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de solicitud',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:396,
    tbar:[
        <?php 
          if($sf_request->getAttribute('in_activo')==true){
        ?>
        this.nueva_solicitud,'-',
        <?php 
          }
        ?>    
        this.estado,'-',
        this.anular
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'N° Solicitud', width:100,menuDisabled:true,dataIndex: 'co_solicitud'}, 
    {header: 'Tipo de solicitud', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tipo_solicitud'},
    {header: 'Creado Por', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'tx_login'},
    {header: 'Fecha', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_creacion'}
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
	
         solicitudLista.main.estado.enable();
         solicitudLista.main.anular.enable();
        
         var msg = Ext.get('detalle');
         msg.load({
                url: '<?php echo $_SERVER['SCRIPT_NAME']?>/Solicitud/detalle',
                scripts: true,
                params:
                {
                    codigo: solicitudLista.main.store_lista.getAt(rowIndex).get('co_solicitud'),
                    co_tipo_solicitud: solicitudLista.main.store_lista.getAt(rowIndex).get('co_tipo_solicitud'),
                    co_proceso: solicitudLista.main.store_lista.getAt(rowIndex).get('co_proceso')

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

this.panel.render("contenedorsolicitudLista");

//Cargar el grid
this.store_lista.baseParams.paginar = 'si';
this.store_lista.baseParams.in_ventanilla = 'true';
this.store_lista.load();
this.store_lista.on('load',function(){
solicitudLista.main.estado.disable();
solicitudLista.main.anular.disable();
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
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/storelista',
    root:'data',
    fields:[ 
            {name: 'tx_login'},
            {name: 'tx_tipo_solicitud'},
            {name: 'co_solicitud'},
            {name: 'fe_creacion'},
            {name: 'co_tipo_solicitud'},
            {name: 'co_proceso'}
           ]
    });
    return this.store;
},
aplicarFiltroByFormulario: function(){
	//Capturamos los campos con su value para posteriormente verificar cual
	//esta lleno y trabajar en base a ese.
	var campo = solicitudLista.main.formFiltroPrincipal.getForm().getValues();

         if(panel_detalle.collapsed == false)
         {
             panel_detalle.toggleCollapse();
         } 


	solicitudLista.main.store_lista.baseParams={}

	var swfiltrar = false;
	for(campName in campo){
	    if(campo[campName]!=''){
		swfiltrar = true;
		eval(" solicitudLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
	    }
	}
	if(swfiltrar==true){
	    solicitudLista.main.store_lista.baseParams.BuscarBy = true;
            solicitudLista.main.store_lista.baseParams.in_ventanilla = 'true';
	    solicitudLista.main.store_lista.load();
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
	solicitudLista.main.formFiltroPrincipal.getForm().reset();
	solicitudLista.main.store_lista.baseParams={};
	solicitudLista.main.store_lista.load();
}
};
Ext.onReady(solicitudLista.main.init, solicitudLista.main);
</script>
<div id="contenedorsolicitudLista"></div>
<div id="formulariosolicitud"></div>
<div id="filtrosolicitud"></div>
<div id="formulariocontribuyente"></div>
