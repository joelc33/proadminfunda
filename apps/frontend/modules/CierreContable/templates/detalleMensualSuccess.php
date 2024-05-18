<script type="text/javascript">
Ext.ns("DetalleCierreContableMensual");
DetalleCierreContableMensual.main = {
init:function(){

//objeto store
this.store_lista = this.getLista();

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.editar= new Ext.Button({
    text:'Detalle',
    iconCls: 'icon-reporteest',
    handler:function(){
	//DetalleCierreContableMensual.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoEgreso');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CierreContable/detalle',
         params:{
                co_comprobante_contable:DetalleCierreContableMensual.main.gridPanel_.getSelectionModel().getSelected().get('co_comprobante_contable')
            },
         scripts: true,
         text: "Cargando.."
        });
    }
});
this.editar.disable();
function formatoNro(val){
    
        if(val==null){
            val = 0;
        }
	return '<p align="right">'+paqueteComunJS.funcion.getNumeroFormateado(val)+'</p>';
}
function renderMonto(val, attr, record) { 
     return paqueteComunJS.funcion.getNumeroFormateado(val);     
} 

this.gridPanel_ = new Ext.grid.GridPanel({
    //title:'Detalle',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:530,
    border:false,
    tbar:[
        this.editar//,'-',this.excel,'-',this.excelDecreto,'-',this.excelSaldoInicial
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_comprobante_contable',hidden:true, menuDisabled:true,dataIndex: 'co_comprobante_contable'},
    {header: 'Fecha', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'fe_comprobante'},
    {header: 'Tipo Documento', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tipo_asiento'},
    {header: 'Nro Comprobante', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_comprobante'},
    {header: 'Monto Debito', width:180,  menuDisabled:true, sortable: true,  dataIndex: 'mo_debito',renderer:renderMonto},
    {header: 'Monto Credito', width:180,  menuDisabled:true, sortable: true,  dataIndex: 'mo_credito',renderer:renderMonto}
   ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){DetalleCierreContableMensual.main.editar.enable()}},
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
                DetalleCierreContableMensual.main.aplicarFiltroByFormulario();
            }
        }
    ]
});
this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        DetalleCierreContableMensual.main.winformPanel_.close();
    }
});
this.total_credito = new Ext.form.DisplayField({
    value:"<span style='font-size:12px;'><b>Total Credito: </b>0,00</b></span>"
});
this.total_debito = new Ext.form.DisplayField({
    value:"<span style='font-size:12px;'><b>Total Debito: </b>0,00</b></span>"
});

this.winformPanel_ = new Ext.Window({
    title:'Detalle Cierre Mensual',
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
            id: 'basic-statusbarMensual',
            autoScroll:true,
            defaults:{style:'color:black;font-size:30px;',autoWidth:true},
            items:[ this.total_debito,'-',
                    this.total_credito]
        }),    
    buttonAlign:'center'
});
this.winformPanel_.show();
this.store_lista.baseParams.nu_anio = this.OBJ.nu_anio;
this.store_lista.baseParams.co_mes = this.OBJ.co_mes;
this.store_lista.load({
    callback: function(){
                var monto_credito = paqueteComunJS.funcion.getSumaColumnaGrid({
                    store:DetalleCierreContableMensual.main.store_lista,
                    campo:'mo_credito'
                });
                var monto_debito = paqueteComunJS.funcion.getSumaColumnaGrid({
                    store:DetalleCierreContableMensual.main.store_lista,
                    campo:'mo_debito'
                });                
                    
                DetalleCierreContableMensual.main.total_credito.setValue("<span style='font-size:12px;'><b>Total Credito: </b>"+paqueteComunJS.funcion.getNumeroFormateado(monto_credito)+"</b></span>"); 
                
                DetalleCierreContableMensual.main.total_debito.setValue("<span style='font-size:12px;'><b>Total Debito: </b>"+paqueteComunJS.funcion.getNumeroFormateado(monto_debito)+"</b></span>"); 

    }
});
CierrePresupuestoEgreso.main.mascara.hide();
},
aplicarFiltroByFormulario: function(){
	//Capturamos los campos con su value para posteriormente verificar cual
	//esta lleno y trabajar en base a ese.
	var campo = DetalleCierreContableMensual.main.formFiltroPrincipal.getForm().getValues();

        DetalleCierreContableMensual.main.store_lista.baseParams={}

	var swfiltrar = false;
	for(campName in campo){
	    if(campo[campName]!=''){
		swfiltrar = true;
		eval(" DetalleCierreContableMensual.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
	    }
	}
	if(swfiltrar==true){
	    DetalleCierreContableMensual.main.store_lista.baseParams.BuscarBy = true;
           // DetalleCierreContableMensual.main.store_lista.baseParams.in_ventanilla = 'true';
	    DetalleCierreContableMensual.main.store_lista.load();
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
	DetalleCierreContableMensual.main.formFiltroPrincipal.getForm().reset();
	DetalleCierreContableMensual.main.store_lista.baseParams={};
	DetalleCierreContableMensual.main.store_lista.load();
}, 
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CierreContable/storelistaDetalleMensual',
    root:'data',
    fields:[
            {name: 'co_comprobante_contable'},
            {name: 'nu_comprobante'},
            {name: 'mo_debito'},
            {name: 'mo_credito'},
            {name: 'tx_tipo_asiento'},
            {name: 'fe_comprobante'}
           ]
    });
    return this.store;
}
};
Ext.onReady(DetalleCierreContableMensual.main.init, DetalleCierreContableMensual.main);
</script>
