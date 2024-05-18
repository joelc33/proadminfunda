<script type="text/javascript">
Ext.ns("CuentaContable");
CuentaContable.main = {
init:function(){
//this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.store_lista = this.getLista();
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

function renderMonto(val, attr, record) {
     return paqueteComunJS.funcion.getNumeroFormateado(val);
}

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Cuentas Contables (Doble Click Para Seleccionar)',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:420,
    tbar:[
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_cuenta_contable',hidden:true, menuDisabled:true,dataIndex: 'co_cuenta_contable'},
    {header: 'Cuenta', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tx_cuenta'},
    {header: 'Denominación', width:500,  menuDisabled:true, sortable: true,  dataIndex: 'tx_descripcion',renderer:textoLargo},
    {header: 'Nivel', width:60,  menuDisabled:true, sortable: true,  dataIndex: 'nu_nivel'},
    {header: 'Saldo Mes', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'saldo',renderer:renderMonto},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
    },
    celldblclick:function(Grid, rowIndex, columnIndex,e ){
        
        agregarAjuste.main.co_cuenta_contable.setValue(CuentaContable.main.gridPanel_.getSelectionModel().getSelected().get('co_cuenta_contable'));
        agregarAjuste.main.cuenta.setValue(CuentaContable.main.gridPanel_.getSelectionModel().getSelected().get('tx_cuenta'));
        agregarAjuste.main.denominacion.setValue(CuentaContable.main.gridPanel_.getSelectionModel().getSelected().get('tx_descripcion'));
        CuentaContable.main.winformPanel_.close();
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

this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'Descripcion Cuenta',
	name:'tx_descripcion',
	value:''
});

this.nu_cuenta_contable = new Ext.form.TextField({
	fieldLabel:'Cuenta Contable (sin puntos)',
	name:'nu_cuenta_contable',
	value:''
});

this.nu_nivel = new Ext.form.NumberField({
	fieldLabel:'Nivel',
	name:'nu_nivel',
	value:''
});

this.formFiltroPrincipal = new Ext.form.FormPanel({
    title:'Busqueda',
    iconCls: 'icon-solpendiente',
    collapsible: true,
    titleCollapse: true,
    autoWidth:true,
    border:false,
    labelWidth: 110,
    padding:'10px',
    items   : [
        this.tx_descripcion,
        this.nu_cuenta_contable,
        this.nu_nivel
    ],
    keys: [{
            key:[Ext.EventObject.ENTER],
            handler: function() {
                     CuentaContable.main.aplicarFiltroByFormulario();
            }}
    ],
    buttonAlign:'center',
    buttons:[
        {
            text:'Consultar',
            iconCls:'icon-buscar',
            handler:function(){
                    CuentaContable.main.aplicarFiltroByFormulario();
            }
        },
        {
            text:'Limpiar',
            iconCls:'icon-limpiar',
            handler:function(){
                    CuentaContable.main.limpiarCamposByFormFiltro();
            }
        }                
    ]
});


this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        CuentaContable.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    fileUpload: true,
    frame:true,
    width:1000,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
        //this.formFiltroPrincipal,
                this.gridPanel_
    ]
});

this.winformPanel_ = new Ext.Window({
    title:'Buscar Cuenta ',
    modal:true,
    constrain:true,
    width:1000,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.formFiltroPrincipal,
        this.formPanel_
    ],
    buttons:[
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();

},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ComprobanteAjuste/storelistaCuenta',
    root:'data',
    fields:[
            {name: 'co_cuenta_contable'},
            {name: 'tx_cuenta'},
            {name: 'tx_descripcion'},
            {name: 'nu_nivel'},
            {name: 'saldo'}
           ]
    });
    return this.store;
},
aplicarFiltroByFormulario: function(){
	//Capturamos los campos con su value para posteriormente verificar cual
	//esta lleno y trabajar en base a ese.
	var campo = CuentaContable.main.formFiltroPrincipal.getForm().getValues();

        CuentaContable.main.store_lista.baseParams={}

	var swfiltrar = false;
	for(campName in campo){
	    if(campo[campName]!=''){
		swfiltrar = true;
		eval(" CuentaContable.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
	    }
	}
	if(swfiltrar==true){
	    CuentaContable.main.store_lista.baseParams.BuscarBy = true;
	    CuentaContable.main.store_lista.load();
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
	CuentaContable.main.formFiltroPrincipal.getForm().reset();
	CuentaContable.main.store_lista.baseParams={};
	CuentaContable.main.store_lista.load();
}
};
Ext.onReady(CuentaContable.main.init, CuentaContable.main);
</script>
<div id="formularioPlandecuenta"></div>
<div id="contenedor"></div>
<div id="formulario"></div>
<div id="filtroCuentaContable"></div>