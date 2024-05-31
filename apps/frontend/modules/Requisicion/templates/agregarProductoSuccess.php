<script type="text/javascript">
Ext.ns("listaProducto");
listaProducto.main = {
init:function(){

this.storeCO_UNIDAD = this.getStoreCO_UNIDAD();

this.store_lista = this.getStoreCO_PRODUCTO();

this.co_producto = new Ext.form.Hidden({
    name:'co_producto'
});


this.tx_codigo = new Ext.form.TextField({
	fieldLabel:'Código',
	name:'codigo',
	allowBlank:false,
	width:80
});

this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'Producto',
	name:'producto',
	allowBlank:false,
	width:510
});

this.formFiltroPrincipal = new Ext.form.FormPanel({
    title:'Buscar Materiales / Bienes / Servicios',
    titleCollapse: true,
    autoWidth:true,
    border:true,
    padding:'10px',    
    items:[ this.tx_codigo,
            this.tx_descripcion],
    keys: [{
		key:[Ext.EventObject.ENTER],
		handler: function() {
			listaProducto.main.aplicarFiltroByFormulario();
		}}
    ],
    buttonAlign:'center',
    buttons:[
        {
            text:'Consultar',
            iconCls:'icon-buscar',
            handler:function(){
                listaProducto.main.aplicarFiltroByFormulario();
            }
        },
        {
            text:'Limpiar',
            iconCls:'icon-limpiar',
            handler:function(){
                listaProducto.main.limpiarCamposByFormFiltro();
            }
        }
    ]
});




this.cod_producto = new Ext.form.TextField({
	fieldLabel:'Código',
	name:'cod_producto',
	allowBlank:false,
	readOnly:true,
	style:'background:#c9c9c9;',
	width:80
});

this.tx_producto = new Ext.form.TextField({
	fieldLabel:'Producto',
	name:'tx_producto',
	allowBlank:false,
	readOnly:true,
	style:'background:#c9c9c9;',
	width:510
});


this.nu_cantidad = new Ext.form.NumberField({
	fieldLabel:'Cantidad',
	name:'nu_cantidad',
	allowBlank:false,
	width:80
});

this.tx_observacion = new Ext.form.TextArea({
	fieldLabel:'Especificaciones',
	name:'tx_observacion',
	width:600
});

this.tx_observacion.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                            listaProducto.main.tx_observacion.setValue(listaProducto.main.tx_observacion.getValue().toUpperCase());

                        }
                    }, this);
                        
this.tx_observacion.on('blur',function(){
                        listaProducto.main.tx_observacion.setValue(listaProducto.main.tx_observacion.getValue().toUpperCase());
                    }); 

this.co_unidad_producto = new Ext.form.ComboBox({
	fieldLabel:'Unidad',
	store: this.storeCO_UNIDAD,
	typeAhead: true,
	valueField: 'co_unidad_producto',
	displayField:'tx_unidad_producto',
	hiddenName:'tb011_cuenta_bancaria[co_unidad_producto]',
	//readOnly:(this.OBJ.co_tipo_cuenta!='')?true:false,
	//style:(this.main.OBJ.co_tipo_cuenta!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'...',
	selectOnFocus: true,
	mode: 'local',
	width:250,
	resizable:true,
	allowBlank:false
});
this.storeCO_UNIDAD.load();

this.compositefield = new Ext.form.CompositeField({
fieldLabel: 'Producto',
width:600,
items: [
           this.cod_producto,
           this.tx_producto
	]
});


this.fieldDatos= new Ext.form.FieldSet({
    title: 'Datos del Materiales / Bienes / Servicio Seleccionado',
    items:[this.compositefield,
           this.nu_cantidad,
           this.co_unidad_producto,
           this.tx_observacion]
});

this.gridPanel = new Ext.grid.GridPanel({
        title:'Lista de Materiales / Bienes / Servicios',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:190,  
        width:750,   
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_producto', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_producto'},    
            {header: 'Codigo',width:80, menuDisabled:true,dataIndex: 'cod_producto'},
            {header: 'Descripción',width:600, menuDisabled:true,dataIndex: 'tx_producto'},
                
        ],
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
            listaProducto.main.co_producto.setValue(listaProducto.main.store_lista.getAt(rowIndex).get('co_producto'));
            listaProducto.main.cod_producto.setValue(listaProducto.main.store_lista.getAt(rowIndex).get('cod_producto'));
            listaProducto.main.tx_producto.setValue(listaProducto.main.store_lista.getAt(rowIndex).get('tx_producto'));
        }},
        bbar: new Ext.PagingToolbar({
            pageSize: 5,
            store: this.store_lista,
            displayInfo: true,
            displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
            emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
        })
});


this.store_lista.load();

this.fieldDatosGrid= new Ext.form.FieldSet({
    items:[this.gridPanel]
});


this.guardar = new Ext.Button({
    text:'Agregar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!listaProducto.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        
        var e = new RequisicionEditar.main.Registro({        
                    co_detalle_requisicion:'',
                    co_producto: listaProducto.main.co_producto.getValue(),
                    cod_producto:listaProducto.main.cod_producto.getValue(),
                    tx_producto: listaProducto.main.tx_producto.getValue()+' - '+listaProducto.main.tx_observacion.getValue(),
                    nu_cantidad: listaProducto.main.nu_cantidad.getValue(),
                    tx_observacion: listaProducto.main.tx_observacion.getValue(),
                    co_unidad_producto: listaProducto.main.co_unidad_producto.getValue(),
                    tx_unidad_producto: listaProducto.main.co_unidad_producto.lastSelectionText
        });

        var cant = RequisicionEditar.main.store_lista.getCount();
        (cant == 0) ? 0 : RequisicionEditar.main.store_lista.getCount() + 1;
        RequisicionEditar.main.store_lista.insert(cant, e);

        RequisicionEditar.main.gridPanel.getView().refresh();
        
        
        var list_producto = paqueteComunJS.funcion.getJsonByObjStore({
                store:RequisicionEditar.main.gridPanel.getStore()
        });
        
        RequisicionEditar.main.cant_total = paqueteComunJS.funcion.getSumaColumnaGrid({
                 store:RequisicionEditar.main.store_lista,
                 campo:'nu_cantidad'
        });

        RequisicionEditar.main.cantidad_total.setValue("<span style='font-size:12px;'><b>Cantidad Total: </b>"+parseInt(RequisicionEditar.main.cant_total)+"</b></span>");     
       
        
        listaProducto.main.co_producto.setValue("");
        listaProducto.main.cod_producto.setValue("");
        listaProducto.main.tx_producto.setValue("");
        listaProducto.main.nu_cantidad.setValue("");
        listaProducto.main.tx_observacion.setValue(""); 
         listaProducto.main.co_unidad_producto.setValue(""); 
        
//        listaProducto.main.store_lista.baseParams.lista_producto = list_producto;
//        listaProducto.main.store_lista.load();
        
        Ext.utiles.msg('Mensaje', "El material de agrego exitosamente");
   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        listaProducto.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
  //  frame:true,
    width:800,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
           this.fieldDatosGrid,
           this.fieldDatos]
});

this.winformPanel_ = new Ext.Window({
    title:'Lista de Materiales',
    modal:true,
    constrain:true,
    width:810,
  //  frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.formFiltroPrincipal,
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
aplicarFiltroByFormulario: function(){
	//Capturamos los campos con su value para posteriormente verificar cual
	//esta lleno y trabajar en base a ese.
	var campo = listaProducto.main.formFiltroPrincipal.getForm().getValues();

	listaProducto.main.store_lista.baseParams={}

	var swfiltrar = false;
	for(campName in campo){
	    if(campo[campName]!=''){
		swfiltrar = true;
		eval("listaProducto.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
	    }
	}
	if(swfiltrar==true){
	    listaProducto.main.store_lista.baseParams.BuscarBy = true;
	    listaProducto.main.store_lista.load();
	}else{
	    listaProducto.main.formFiltroPrincipal.getForm().reset();
            listaProducto.main.store_lista.baseParams={};
            listaProducto.main.store_lista.load();
	}

	},
	limpiarCamposByFormFiltro: function(){
	listaProducto.main.formFiltroPrincipal.getForm().reset();
	listaProducto.main.store_lista.baseParams={};
	listaProducto.main.store_lista.load();
        
}
,getStoreCO_PRODUCTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Requisicion/storefkcoproducto',
        root:'data',
        fields:[
            {name: 'co_producto'},
            {name: 'cod_producto'},
            {name: 'tx_producto'}
            ]
    });
    return this.store;
},getStoreCO_UNIDAD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Requisicion/storefkcounidadproducto',
        root:'data',
        fields:[
            {name: 'co_unidad_producto'},
            {name: 'tx_unidad_producto'}
            ]
    });
    return this.store;
}
};
Ext.onReady(listaProducto.main.init, listaProducto.main);
</script>
