<script type="text/javascript">
Ext.ns("EmpleadoLista");
EmpleadoLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});
this.cedula_titular;
//objeto store
this.store_lista = this.getLista();
this.storeCO_TIPO_EMPLEADO = this.getTipoEmpleado();
this.storeOrganismo = this.getOrganismo();


this.tipo_empleado = new Ext.form.ComboBox({
	fieldLabel:'Tipo Empleado',
	store: this.storeCO_TIPO_EMPLEADO,
	typeAhead: true,
	valueField: 'tipo_empleado',
	displayField:'tipo_empleado',
	hiddenName:'tipo_empleado',
	//readOnly:(this.OBJ.co_proceso!='')?true:false,
	//style:(this.main.OBJ.co_proceso!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_EMPLEADO.load();
//
this.organismo = new Ext.form.ComboBox({
	fieldLabel:'Organismo',
	store: this.storeOrganismo,
	typeAhead: true,
	valueField: 'organismo',
	displayField:'organismo',
	hiddenName:'organismo',
	//readOnly:(this.OBJ.co_documento!='')?true:false,
	//style:(this.main.OBJ.co_documento!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false
});

this.storeOrganismo.load();

this.nombre = new Ext.form.TextField({
	fieldLabel:'Nombre y Apellido',
	name:'nombre_apellido',
	value:'',
	width:700
});

this.nu_cedula_rif = new Ext.form.TextField({
    fieldLabel:'Cedula',
    name:'cedula_titular',
    maskRe: /[0-9]/, 
    value:'',
    width:155
});

/**
* <Form Principal que carga el Filtro>
*/
this.formFiltroPrincipal = new Ext.form.FormPanel({
    title:'Buscar Empleado',
    iconCls: 'icon-solpendiente',
    collapsible: true,
    titleCollapse: true,
    autoWidth:true,
    border:false,
    labelWidth: 110,
    padding:'10px',
    items   : [
        this.nu_cedula_rif,
        this.nombre,
        this.tipo_empleado,
        this.organismo
       
    ],
    keys: [{
		key:[Ext.EventObject.ENTER],
		handler: function() {
			 EmpleadoLista.main.aplicarFiltroByFormulario();
		}}
    ],
    buttonAlign:'center',
    buttons:[
        {
            text:'Consultar',
            iconCls:'icon-buscar',
            handler:function(){
                EmpleadoLista.main.aplicarFiltroByFormulario();
            }
        },
        {
            text:'Limpiar',
            iconCls:'icon-limpiar',
            handler:function(){
                EmpleadoLista.main.limpiarCamposByFormFiltro();
            }
        }
    ]
});



//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        EmpleadoLista.main.mascara.show();
        this.msg = Ext.get('formularioEmpleado');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empleado/editar',
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = EmpleadoLista.main.gridPanel_.getSelectionModel().getSelected().get('cedula_titular');
	EmpleadoLista.main.mascara.show();
        this.msg = Ext.get('formularioEmpleado');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empleado/editar/cedula_titular/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Eliminar un registro
this.eliminar= new Ext.Button({
    text:'Eliminar',
    iconCls: 'icon-eliminar',
    handler:function(){
	this.codigo  = EmpleadoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_empleado');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empleado/eliminar',
            params:{
                co_empleado:EmpleadoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_empleado')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    EmpleadoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                EmpleadoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroEmpleado');
        EmpleadoLista.main.mascara.show();
        EmpleadoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empleado/filtro',
             scripts: true
        });
    }
});


this.verBeneficiario= new Ext.Button({
    text:'Ver Beneficiario',
    iconCls: 'icon-usuario',
    handler:function(){
	 var msg = Ext.get('detalle');
         msg.load({
                url: '<?php echo $_SERVER['SCRIPT_NAME']?>/Empleado/detalleBeneficiario',
                scripts: true,
                params:
                {
                    cedula: EmpleadoLista.main.cedula_titular                   
                },
                text: 'Cargando...'
         });
    }
});


this.editar.disable();
this.eliminar.disable();
this.verBeneficiario.disable();



//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Empleado',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:400,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.eliminar,'-',this.verBeneficiario
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_empleado',hidden:true, menuDisabled:true,dataIndex: 'co_empleado'},
   // {header: 'Cedula titular', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'cedula_titular'},
    {header: 'Cédula', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'cedula_titular'},
    {header: 'Nombre Apellido', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'nombre_apellido'},
   // {header: 'Nacionalidad', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nacionalidad'},
   // {header: 'Parentesco', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'parentesco'},
    {header: 'Fecha Nacimiento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_nacimiento'},
    {header: 'Sexo', width:50,  menuDisabled:true, sortable: true,  dataIndex: 'sexo'},
    {header: 'Tipo Empleado', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tipo_empleado'},
    {header: 'Organismo', width:250,  menuDisabled:true, sortable: true,  dataIndex: 'organismo'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{
        celldblclick:function(Grid, rowIndex, columnIndex,e ){
               
         var msg = Ext.get('detalle');
         msg.load({
                url: '<?php echo $_SERVER['SCRIPT_NAME']?>/Empleado/detalleBeneficiario',
                scripts: true,
                params:
                {
                    cedula: EmpleadoLista.main.store_lista.getAt(rowIndex).get('cedula_titular')                   
                },
                text: 'Cargando...'
         });
        
    
//         if(panel_detalle.collapsed == true)
//         {
//            panel_detalle.toggleCollapse();
//         } 
    
        },
        cellclick:function(Grid, rowIndex, columnIndex,e ){

            EmpleadoLista.main.editar.enable();
            EmpleadoLista.main.eliminar.enable();            
            EmpleadoLista.main.verBeneficiario.enable();
            
            EmpleadoLista.main.cedula_titular = EmpleadoLista.main.store_lista.getAt(rowIndex).get('cedula_titular');

        }
    },    
    bbar: new Ext.PagingToolbar({
        pageSize: 14,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.formFiltroPrincipal.render("contenedorFiltro");
this.gridPanel_.render("contenedorEmpleadoLista");

this.store_lista.baseParams.parentesco = 'TITULAR';
this.store_lista.load();
},
aplicarFiltroByFormulario: function(){
	//Capturamos los campos con su value para posteriormente verificar cual
	//esta lleno y trabajar en base a ese.
	var campo = EmpleadoLista.main.formFiltroPrincipal.getForm().getValues();

         if(panel_detalle.collapsed == false)
         {
             panel_detalle.toggleCollapse();
         } 


	EmpleadoLista.main.store_lista.baseParams={}

	var swfiltrar = false;
	for(campName in campo){
	    if(campo[campName]!=''){
		swfiltrar = true;
		eval(" EmpleadoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
	    }
	}
	if(swfiltrar==true){
	    EmpleadoLista.main.store_lista.baseParams.BuscarBy = true;
           // EmpleadoLista.main.store_lista.baseParams.in_ventanilla = 'true';
	    EmpleadoLista.main.store_lista.load();
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
	EmpleadoLista.main.formFiltroPrincipal.getForm().reset();
	EmpleadoLista.main.store_lista.baseParams={};
	EmpleadoLista.main.store_lista.load();
},getOrganismo: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empleado/storelistaOrganimo',
    root:'data',
    fields:[
            {name: 'organismo'}
           ]
    });
    return this.store;
}
,getTipoEmpleado: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empleado/storelistaTipoEmpleado',
    root:'data',
    fields:[
            {name: 'tipo_empleado'}
           ]
    });
    return this.store;
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empleado/storelista',
    root:'data',
    fields:[
            {name: 'co_empleado'},
            {name: 'cedula_titular'},
            {name: 'nombre_apellido'},
            {name: 'nacionalidad'},
            {name: 'parentesco'},
            {name: 'cedula'},
            {name: 'fe_nacimiento'},
            {name: 'sexo'},
            {name: 'tipo_empleado'},
            {name: 'organismo'},
            {name: 'nac_cedula'},
           ]
    });
    return this.store;
}
};
Ext.onReady(EmpleadoLista.main.init, EmpleadoLista.main);
</script>
<div id="contenedorFiltro"></div>
<div id="contenedorEmpleadoLista"></div>
<div id="formularioEmpleado"></div>
<div id="filtroEmpleado"></div>
