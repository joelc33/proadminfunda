<script type="text/javascript">
Ext.ns("DetalleCierreContable");
DetalleCierreContable.main = {
init:function(){

//objeto store
this.store_lista = this.getLista();

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

function formatoNro(val){
    
        if(val==null){
            val = 0;
        }
	return '<p align="right">'+paqueteComunJS.funcion.getNumeroFormateado(val)+'</p>';
}


this.gridPanel_ = new Ext.grid.GridPanel({
    //title:'Detalle',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:530,
    border:false,
//    tbar:[
//        this.editar,'-',this.excel,'-',this.excelDecreto,'-',this.excelSaldoInicial
//    ],
    columns: [
    new Ext.grid.RowNumberer(),
        {header: 'co_tipo_asiento', hidden:true, width:250,  menuDisabled:true, sortable: true, dataIndex: 'co_tipo_asiento'},
        {header: 'co_cuenta_contable', hidden:true, width:250,  menuDisabled:true, sortable: true, dataIndex: 'co_cuenta_contable'},
        {header: 'Nro. Solicitud', width:100,  menuDisabled:true, sortable: true, dataIndex: 'co_solicitud'},
        {header: 'Cuenta Contable', width:150,  menuDisabled:true, sortable: true, renderer: textoLargo, dataIndex: 'tx_cuenta'},
        {header: 'Descripcion', width:250,  menuDisabled:true, sortable: true, renderer: textoLargo, dataIndex: 'tx_descripcion'},
        {header: 'Monto Debito', width:150,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'mo_debito'},
        {header: 'Monto Credito', width:150,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'mo_credito'}
   ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    bbar: new Ext.PagingToolbar({
        pageSize: 100000,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })  
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
    items:[],
    buttonAlign:'center',
    buttons:[
        {
            text:'Consultar',
            iconCls:'icon-buscar',
            handler:function(){
                DetalleCierreContable.main.aplicarFiltroByFormulario();
            }
        }
    ]
});
this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        DetalleCierreContable.main.winformPanel_.close();
    }
});

this.total_credito = new Ext.form.DisplayField({
    value:"<span style='font-size:12px;'><b>Total Credito: </b>0,00</b></span>"
});
this.total_debito = new Ext.form.DisplayField({
    value:"<span style='font-size:12px;'><b>Total Debito: </b>0,00</b></span>"
});
this.winformPanel_ = new Ext.Window({
    title:'Detalle Movimiento Contable '+this.OBJ.tx_tipo_asiento+ ' del '+this.OBJ.fecha,
    modal:true,
    constrain:true,
    width:1000,
    frame:true,
    closabled:true,
    height:620,
    items:[
        //this.formFiltroPrincipal,
        this.gridPanel_
    ],
    buttons:[
        this.salir
    ],
        bbar: new Ext.ux.StatusBar({
            id: 'basic-statusbar',
            autoScroll:true,
            defaults:{style:'color:black;font-size:30px;',autoWidth:true},
            items:[ this.total_debito,'-',
                    this.total_credito]
        }),      
    buttonAlign:'center'
});
this.winformPanel_.show();
this.store_lista.baseParams.co_tipo_asiento = this.OBJ.co_tipo_asiento;
this.store_lista.baseParams.fecha = this.OBJ.fecha;
this.store_lista.load({
    callback: function(){
                var monto_credito = paqueteComunJS.funcion.getSumaColumnaGrid({
                    store:DetalleCierreContable.main.store_lista,
                    campo:'mo_credito'
                });
                var monto_debito = paqueteComunJS.funcion.getSumaColumnaGrid({
                    store:DetalleCierreContable.main.store_lista,
                    campo:'mo_debito'
                });                
                    
                DetalleCierreContable.main.total_credito.setValue("<span style='font-size:12px;'><b>Total Credito: </b>"+paqueteComunJS.funcion.getNumeroFormateado(monto_credito)+"</b></span>"); 
                
                DetalleCierreContable.main.total_debito.setValue("<span style='font-size:12px;'><b>Total Debito: </b>"+paqueteComunJS.funcion.getNumeroFormateado(monto_debito)+"</b></span>"); 

    }
});
CierrePresupuestoEgreso.main.mascara.hide();
},
aplicarFiltroByFormulario: function(){
	//Capturamos los campos con su value para posteriormente verificar cual
	//esta lleno y trabajar en base a ese.
	var campo = DetalleCierreContable.main.formFiltroPrincipal.getForm().getValues();

        DetalleCierreContable.main.store_lista.baseParams={}

	var swfiltrar = false;
	for(campName in campo){
	    if(campo[campName]!=''){
		swfiltrar = true;
		eval(" DetalleCierreContable.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
	    }
	}
	if(swfiltrar==true){
	    DetalleCierreContable.main.store_lista.baseParams.BuscarBy = true;
           // DetalleCierreContable.main.store_lista.baseParams.in_ventanilla = 'true';
	    DetalleCierreContable.main.store_lista.load();
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
	DetalleCierreContable.main.formFiltroPrincipal.getForm().reset();
	DetalleCierreContable.main.store_lista.baseParams={};
	DetalleCierreContable.main.store_lista.load();
}, 
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CierreContable/storelistaDetalleTipoAsiento',
    root:'data',
    fields:[
            {name: 'co_tipo_asiento'},
            {name: 'co_cuenta_contable'},
            {name: 'co_solicitud'},
            {name: 'tx_cuenta'},
            {name: 'tx_descripcion'},
            {name: 'fecha'},
            {name: 'mo_debito'},
            {name: 'mo_credito'}
           ]
    });
    return this.store;
}
};
Ext.onReady(DetalleCierreContable.main.init, DetalleCierreContable.main);
</script>
