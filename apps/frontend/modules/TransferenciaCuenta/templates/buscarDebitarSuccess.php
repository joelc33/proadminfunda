<script type="text/javascript">
Ext.ns("BuscarDebitar");
BuscarDebitar.main = {
init:function(){


this.store_lista_cuenta   = this.getListaCuenta();

this.tx_cuenta = new Ext.form.TextField({
	fieldLabel:'Cuenta Contable',
	name:'tx_cuenta',
	value:'',
	width:200
});

this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'Descripción',
	name:'tx_descripcion',
	value:'',
	width:600
});


this.formFiltroPrincipal = new Ext.form.FormPanel({
    title:'Buscar Cuenta Contable',
    iconCls: 'icon-solpendiente',
    collapsible: true,
    titleCollapse: true,
    autoWidth:true,
    border:false,
    labelWidth: 110,
    padding:'10px',
    items   : [
        this.tx_cuenta,
        this.tx_descripcion       
    ],
    keys: [{
		key:[Ext.EventObject.ENTER],
		handler: function() {
			 BuscarDebitar.main.aplicarFiltroByFormulario();
		}}
    ],
    buttonAlign:'center',
    buttons:[
        {
            text:'Consultar',
            iconCls:'icon-buscar',
            handler:function(){
                BuscarDebitar.main.aplicarFiltroByFormulario();
            }
        },
        {
            text:'Limpiar',
            iconCls:'icon-limpiar',
            handler:function(){
                BuscarDebitar.main.limpiarCamposByFormFiltro();
            }
        }
    ]
});

function renderMonto(val, attr, record) { 
     return paqueteComunJS.funcion.getNumeroFormateado(val);     
} 

this.gridPanelCuenta = new Ext.grid.GridPanel({
        title:'Lista de Cuentas Contables',
        iconCls: 'icon-libro',
        store: this.store_lista_cuenta,
        loadMask:true,
        height:400,  
        width:1000,
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_cuenta_contable', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_cuenta_contable'},
            {header: 'Cuenta Contable',width:200, menuDisabled:true,dataIndex: 'tx_cuenta'},
        //    {header: 'Descripción',width:320, menuDisabled:true,dataIndex: 'tx_descripcion',renderer:textoLargo},
            {header: 'Cuenta Bancaria',width:200, menuDisabled:true,dataIndex: 'tx_cuenta_bancaria'},
            {header: 'Banco',width:320, menuDisabled:true,dataIndex: 'tx_banco',renderer:textoLargo},
            {header: 'Saldo',width:200, menuDisabled:true,dataIndex: 'mo_saldo',renderer:renderMonto}            
        ],
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
             BuscarDebitar.main.guardar.enable();
        }},
        bbar: new Ext.PagingToolbar({
            pageSize: 15,
            store: this.store_lista_cuenta,
            displayInfo: true,
            displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
            emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
        }) 
});

this.store_lista_cuenta.baseParams.co_cuenta_contable_creditar = TransferenciaEditar.main.co_cuenta_creditar.getValue();
this.store_lista_cuenta.load();

this.guardar = new Ext.Button({
    text:'Aceptar',
    iconCls: 'icon-guardar',
    handler:function(){
           
      var co_cuenta_contable  = BuscarDebitar.main.gridPanelCuenta.getSelectionModel().getSelected().get('co_cuenta_contable');
      var nu_cuenta_contable  = BuscarDebitar.main.gridPanelCuenta.getSelectionModel().getSelected().get('tx_cuenta');
      var tx_descripcion      = BuscarDebitar.main.gridPanelCuenta.getSelectionModel().getSelected().get('tx_descripcion');
      var co_cuenta_bancaria  = BuscarDebitar.main.gridPanelCuenta.getSelectionModel().getSelected().get('co_cuenta_bancaria');
      var tx_cuenta_bancaria  = BuscarDebitar.main.gridPanelCuenta.getSelectionModel().getSelected().get('tx_cuenta_bancaria');
      var tx_banco  = BuscarDebitar.main.gridPanelCuenta.getSelectionModel().getSelected().get('tx_banco');
      var mo_saldo  = BuscarDebitar.main.gridPanelCuenta.getSelectionModel().getSelected().get('mo_saldo');
      var co_banco  = BuscarDebitar.main.gridPanelCuenta.getSelectionModel().getSelected().get('co_banco');
      
      TransferenciaEditar.main.co_cuenta_debita.setValue(co_cuenta_contable);
      TransferenciaEditar.main.tx_cuenta_debitar.setValue(nu_cuenta_contable);
      TransferenciaEditar.main.tx_descripcion_debitar.setValue(tx_descripcion);
      
      TransferenciaEditar.main.co_cuenta_bancaria_debitar.setValue(co_cuenta_bancaria);
      TransferenciaEditar.main.tx_cuenta_bancaria_debitar.setValue(tx_cuenta_bancaria);
      TransferenciaEditar.main.tx_banco_debitar.setValue(tx_banco);
      TransferenciaEditar.main.saldo_disponible.setValue(mo_saldo);
      TransferenciaEditar.main.nu_saldo_debitar.setValue(paqueteComunJS.funcion.getNumeroFormateado(mo_saldo));
      TransferenciaEditar.main.co_banco_debitar.setValue(co_banco);
      
      BuscarDebitar.main.winformPanel_.close();
           
    }
});

this.guardar.disable();

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        BuscarDebitar.main.winformPanel_.close();
    }
});
            

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:1040,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
        this.gridPanelCuenta
    ]   
});



this.winformPanel_ = new Ext.Window({
    title:'Transferencia entre Cuenta',
    modal:true,
    constrain:true,
    width:1040,
    frame:true,
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
	var campo = BuscarDebitar.main.formFiltroPrincipal.getForm().getValues();
        BuscarDebitar.main.guardar.disable();
        
       	BuscarDebitar.main.store_lista_cuenta.baseParams={}

	var swfiltrar = false;
	for(campName in campo){
	    if(campo[campName]!=''){
		swfiltrar = true;
		eval("BuscarDebitar.main.store_lista_cuenta.baseParams."+campName+" = '"+campo[campName]+"';");
	    }
	}
	if(swfiltrar==true){
	    BuscarDebitar.main.store_lista_cuenta.baseParams.BuscarBy = true;
   	    BuscarDebitar.main.store_lista_cuenta.load();
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
	BuscarDebitar.main.formFiltroPrincipal.getForm().reset();
	BuscarDebitar.main.store_lista_cuenta.baseParams={};
	BuscarDebitar.main.store_lista_cuenta.load();
        BuscarDebitar.main.guardar.disable();
},getListaCuenta: function(){

    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TransferenciaCuenta/storelistaCuentaBancaria',
    root:'data',
    fields:[
                {name: 'co_cuenta_contable'},
                {name: 'tx_descripcion'},
                {name: 'nu_cuenta_contable'},
                {name: 'tx_cuenta'},
                {name: 'co_banco'},
                {name: 'tx_banco'},
                {name: 'co_cuenta_bancaria'},
                {name: 'tx_cuenta_bancaria'},
                {name: 'mo_saldo'}
           ]
    });
    return this.store;   

}
};
Ext.onReady(BuscarDebitar.main.init, BuscarDebitar.main);
</script>
