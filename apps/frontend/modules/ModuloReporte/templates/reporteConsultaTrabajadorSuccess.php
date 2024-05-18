<script type="text/javascript">
Ext.ns("ConsultaTrabajador");
ConsultaTrabajador.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();

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

this.nombre = new Ext.form.TextField({
	fieldLabel:'Nombre',
	name:'nombre',
	value:'',
	width:700,
        listeners: {
        change: function(field, newValue, oldValue) {
        field.setValue(newValue.toUpperCase());
    }
}        
});

this.nu_cedula = new Ext.form.TextField({
	fieldLabel:'Nu cedula',
        name:'nu_cedula',
        maskRe: /[0-9]/, 
	value:'',
	width:155
});

this.compositefieldCIRIF = new Ext.form.CompositeField({
fieldLabel: 'Cédula',
items: [
	this.co_documento,
	this.nu_cedula,
	]
});


/**
* <Form Principal que carga el Filtro>
*/
this.formFiltroPrincipal = new Ext.form.FormPanel({
    title:'Consultar Trabajador',
    iconCls: 'icon-solpendiente',
    collapsible: true,
    titleCollapse: true,
    autoWidth:true,
    border:false,
    labelWidth: 110,
    padding:'10px',
    items   : [
        this.compositefieldCIRIF,
        this.nombre
       
    ],
    keys: [{
		key:[Ext.EventObject.ENTER],
		handler: function() {
			 ConsultaTrabajador.main.aplicarFiltroByFormulario();
		}}
    ],
    buttonAlign:'center',
    buttons:[
        {
            text:'Consultar',
            iconCls:'icon-buscar',
            handler:function(){
                ConsultaTrabajador.main.aplicarFiltroByFormulario();
            }
        },
        {
            text:'Limpiar',
            iconCls:'icon-limpiar',
            handler:function(){
                ConsultaTrabajador.main.limpiarCamposByFormFiltro();
            }
        }
    ]
});

//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

this.detalle= new Ext.Button({
    text:'Ver Detalle',
    iconCls: 'icon-cambio',
    handler: this.onEstatus
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
    tbar:[
        this.detalle
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'Cédula', width:100,hidden:true,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cedula'},
    {header: 'Cédula', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cedula'},
    {header: 'Nombre y Apellido', width:400,  menuDisabled:true, sortable: true,  dataIndex: 'nombre',renderer: textoLargo},
 
    //{header: 'Tipo de solicitud', width:250,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tipo_solicitud',renderer: renderRectificacion}
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
	
         ConsultaTrabajador.main.detalle.enable();
    
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

this.panel.render("contenedorConsultaTrabajador");

//Cargar el grid
this.store_lista.baseParams.paginar = 'si';
this.store_lista.load();
this.store_lista.on('load',function(){
ConsultaTrabajador.main.detalle.disable();
});
},
onEstatus: function(){
        this.msg = Ext.get('formulariosolicitud');
        this.msg.load({
            url:"<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/consulta",
            params:{codigo:ConsultaTrabajador.main.gridPanel_.getSelectionModel().getSelected().get('co_trabajador')},
            scripts: true,
            text: "Cargando.."
        });
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ModuloReporte/storelistaTrabajador',
    root:'data',
    fields:[ 
            {name: 'co_trabajador'},
            {name: 'nu_cedula'},
            {name: 'nombre'},
            {name: 'fe_creacion'},
            {name: 'cant_revision'},
            {name: 'co_tipo_solicitud'},
            {name: 'tx_rif'},
            {name: 'tx_serial'},
            {name: 'tx_razon_social'}
           ]
    });
    return this.store;
}
,getStoreCO_DOCUMENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcodocumento',
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
	var campo = ConsultaTrabajador.main.formFiltroPrincipal.getForm().getValues();

         if(panel_detalle.collapsed == false)
         {
             panel_detalle.toggleCollapse();
         } 


	ConsultaTrabajador.main.store_lista.baseParams={}

	var swfiltrar = false;
	for(campName in campo){
	    if(campo[campName]!=''){
		swfiltrar = true;
		eval(" ConsultaTrabajador.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
	    }
	}
	if(swfiltrar==true){
	    ConsultaTrabajador.main.store_lista.baseParams.BuscarBy = true;
           // ConsultaTrabajador.main.store_lista.baseParams.in_ventanilla = 'true';
	    ConsultaTrabajador.main.store_lista.load();
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
	ConsultaTrabajador.main.formFiltroPrincipal.getForm().reset();
	ConsultaTrabajador.main.store_lista.baseParams={};
	ConsultaTrabajador.main.store_lista.load();
}
};
Ext.onReady(ConsultaTrabajador.main.init, ConsultaTrabajador.main);
</script>
<div id="contenedorConsultaTrabajador"></div>
<div id="formulariosolicitud"></div>
