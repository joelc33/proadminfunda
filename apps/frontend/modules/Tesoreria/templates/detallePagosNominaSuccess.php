<script type="text/javascript">
Ext.ns("PagosPanel");
PagosPanel.main = {
    co_liquidacion_pago: [],
    co_pago:     0,    
    co_tipo_solicitud:     0,
    co_solicitud:     0,
    init:function(){
        this.OBJ = doJSON('<?php echo $data ?>');


this.storeP = PagosPanel.main.fgetP(); 
this.storeR = PagosPanel.main.fgetR();
/**
 * <GET PAGOS PENDIENTES>
 **/
    this.storeP.baseParams.co_solicitud = PagosPanel.main.OBJ.co_solicitud;

    this.storeP.load();
/**
 * </GET PAGOS PENDIENTES>
 **/


/**
 * <GET PAGOS REALIZADOS>
 **/
    this.storeR.baseParams.co_solicitud = PagosPanel.main.OBJ.co_solicitud;
    this.storeR.load();

/**
 * </GET PAGOS REALIZADOS>
 **/

this.botonPagar = new Ext.Button({
    text:'Pagar',
    iconCls:'icon-pagos',
    handler:function(){
        this.co_liquidacion_pago = PagosPanel.main.co_liquidacion_pago;
        this.co_solicitud = PagosPanel.main.co_solicitud;
                var msg = Ext.get('muestra_contrib');
                    msg.load({
                    url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Tesoreria/index',
                    scripts: true,
                    params:{
                        co_liquidacion_pago: this.co_liquidacion_pago,
                        co_solicitud: this.co_solicitud,
                        co_tipo_solicitud: PagosPanel.main.OBJ.co_tipo_solicitud
                    },
                    text: 'Cargando...'
                    });
                    msg.show();
        
    }
});


this.botonReportesP = new Ext.Button({
    text:'Reporte',
    iconCls:'icon-reporteVeh',
    handler: function(){
     // window.open("http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']; ?>/reporte/index/i/"+Detalle.main.gridPanel_.getSelectionModel().getSelected().get('co_ruta'));
    }
});

var scrollMenu = new Ext.menu.Menu();
scrollMenu.add({
    text: 'Banco BOD',
    icon: '../images/bod.png',
    handler: function(){
      window.open("http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']; ?>/reporte/pagoBod/i/"+PagosPanel.main.OBJ.co_ruta);
    }
});

scrollMenu.add({
    text: 'Banco de Venezuela',
    icon: '../images/venezuela.jpeg',
    handler: function(){
      window.open("http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']; ?>/reporte/pagoBancodeVenezuela/i/"+PagosPanel.main.OBJ.co_ruta);
    }
});

scrollMenu.add({
    text: 'Banco Provincial',
    icon: '../images/provincial.png',
    handler: function(){
      window.open("http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']; ?>/reporte/pagoProvincial/i/"+PagosPanel.main.OBJ.co_ruta);
    }
});

this.botonTxtPago = new Ext.Button({
    text:'TXT de Pago',
    icon: '../images/ico_list.gif',
    menu: scrollMenu

});


       
this.botonPagar.setDisabled(true);
this.botonReportesP.setDisabled(true);

this.toolbarP = new Ext.Toolbar({
   autoWidth:true,
   items:[
       this.botonPagar,'-',
       this.botonReportesP,'-',
       this.botonTxtPago
   ]
});

var myCboxSelModel = new Ext.grid.CheckboxSelectionModel({
  // override private method to allow toggling of selection on or off for multiple rows.
  handleMouseDown : function(g, rowIndex, e){
    var view = this.grid.getView();
    var isSelected = this.isSelected(rowIndex);
    if(isSelected) {  
      this.deselectRow(rowIndex);
    } 
    else if(!isSelected || this.getCount() > 1) {
      this.selectRow(rowIndex, true);
      view.focusRow(rowIndex);
    }else{
 this.deselectRow(rowIndex);
        }
  },
  singleSelect: false,
  listeners: {
         selectionchange: function(sm, rowIndex, rec) {
         PagosPanel.main.botonPagar.setDisabled(true);
         PagosPanel.main.botonReportesP.setDisabled(true);
var length = sm.selections.length
, record = [];
        if(length>0){
           PagosPanel.main.botonPagar.setDisabled(false);
           PagosPanel.main.botonReportesP.setDisabled(false);            
        for(var i = 0; i<length;i++){
           record.push(sm.selections.items[i].data.co_liquidacion_pago);                    
            PagosPanel.main.co_tipo_solicitud = sm.selections.items[i].data.co_tipo_solicitud;
            PagosPanel.main.co_solicitud = sm.selections.items[i].data.co_solicitud;      
        
            }
            
}
PagosPanel.main.co_liquidacion_pago.push(record);
       console.log(record);
       //alert(record);
            
    }
            

 }
});
this.gridPagosP = new  Ext.grid.GridPanel({
    autoWidth:true,
    height:420,
    store:this.storeP,
    tbar:[
        this.toolbarP
    ],
    sm: myCboxSelModel,
    columns:[
        new Ext.grid.RowNumberer(),
        myCboxSelModel,
        {header: 'co_solicitud',width:60 , hidden:true,groupable: false,sortable: true,  dataIndex: 'co_solicitud'},
        {header: 'co_liquidacion_pago', width:60 , sortable: true, hidden:true,groupable: false,  dataIndex: 'co_liquidacion_pago'},
        {header: 'co_tipo_solicitud', width:60 , sortable: true, hidden:true,groupable: false,  dataIndex: 'co_tipo_solicitud'},
        {header: 'Tipo Solicitud', width:60 , sortable: true, hidden:true,groupable: false,  dataIndex: 'tx_tipo_solicitud'},
        {header: 'N°', width: 80,hideable: false,groupable: false, sortable: true,  dataIndex: 'tx_serial'},
        {header: 'Fecha Emision', width:90 , sortable: true,groupable: false,  dataIndex: 'fe_emision'},
        {header: 'Monto a Pagar',width: 120, sortable: true,groupable: false,xtype: 'numbercolumn',format: '0,0.00 Bs',  dataIndex: 'mo_pagar'},
        {header: 'Monto Pagado', autoWidth: true,summaryType: 'totalPendiente',groupable: false,xtype: 'numbercolumn',format: '0,0.00 Bs', sortable: true,  dataIndex: 'mo_pagado'},
      
    ],
    view: new Ext.grid.GroupingView({
        //groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Pagos" : "Pago"]})',
        forceFit: true,
        showGroupName: false,
        enableNoGroups: false,
        enableGroupingMenu: false,
        hideGroupedColumn: true
    }),
    stripeRows: true,
    autoScroll:true,
    stateful: true
});

this.botonReporteR = new Ext.Button({
    text:'Reporte',
    disabled:true,
    iconCls:'icon-reporteVeh',
    handler: function(){

 window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/ventanilla/web/reportes/reporte_ingVarios.php?codigo='+PagosPanel.main.co_liquidacion_pago);

    }

});

this.toolbarR = new Ext.Toolbar({
   autoWidth:true,
   items:[
       this.botonReporteR,
   ]
});

this.gridPagosR = new  Ext.grid.GridPanel({
    //autoWidth:true,
    height:420,
    tbar:[
        this.toolbarR
    ],
    store:this.storeR,
    columns:[
        new Ext.grid.RowNumberer(),
        {header: 'co_pago',width:60 , hidden:true,groupable: false,sortable: true,  dataIndex: 'co_pago'},
        {header: 'co_liquidacion_pago',width:60 , hidden:true,groupable: false,sortable: true,  dataIndex: 'co_liquidacion_pago'},
        {header: 'Forma de pago', width: 100,hideable: false,groupable: false, sortable: true,  dataIndex: 'tx_forma_pago'},
        {header: 'N° Cheque/Tranf', width:100 , sortable: true,groupable: false,  dataIndex: 'nu_pago'},
        {header: 'Banco', width:80 , sortable: true,groupable: false,  dataIndex: 'tx_banco',renderer:textoLargo},
        {header: 'Cuenta', width:100 , sortable: true,groupable: false,  dataIndex: 'tx_cuenta_bancaria',renderer:textoLargo},
        {header: 'Fecha Pago', width:100 , sortable: true,groupable: false,  dataIndex: 'fe_pago'},
        {header: 'Monto Pagado',width: 200, sortable: true,groupable: false, xtype: 'numbercolumn',format: '0,0.00 Bs', dataIndex: 'nu_monto'},
    ],
    view: new Ext.grid.GroupingView({
        groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Pagos" : "Pago"]})',
        //forceFit: true,
        showGroupName: false,
        enableNoGroups: false,
        enableGroupingMenu: false,
        hideGroupedColumn: true
    }),
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    plugins: this.summaryR,
    sm: new Ext.grid.RowSelectionModel({
                singleSelect: true,
                listeners: {
                         rowselect: function(sm, row, rec) {
                            PagosPanel.main.co_pago = rec.json.co_pago;
                            PagosPanel.main.botonReporteR.setDisabled(false);
                        }
                 }
    })
});

this.tabpanel = new Ext.TabPanel({
    activeTab:0,
    items:[
        {
            title:'Pagos Pendientes',
            items:[this.gridPagosP],
            autoHeight:true
        },
        {
            title:'Pagos Realizados',
            items:[this.gridPagosR],
            autoHeight:true
        }
    ]
})

this.formpanel = new Ext.Panel({
    autoWidth: true,
    autoHeight:true,
    bodyStyle:'padding:2px',
    layout:'form',
    items:[this.tabpanel],
    renderTo: 'contenedorPanel'
});

},
fgetP: function(){
    this.Store = new Ext.data.GroupingStore({
            proxy: new Ext.data.HttpProxy({
                url:'<?php echo $url."/".$modulo ?>/listaPendiente',
                method: 'POST'
            }),
            reader: new Ext.data.JsonReader({
                root: 'data',
                totalProperty: 'total'
            },
            [
                {name: 'co_liquidacion_pago'},
                {name: 'co_solicitud'},
                {name: 'fe_emision'},
                {name: 'mo_pendiente'},
                {name: 'mo_pagado'},
                {name: 'mo_pagar'},
                {name: 'nu_anio'},
                {name: 'tx_serial'},
                {name: 'tx_tipo_solicitud'}
            ]),
            sortInfo:{
                field: 'co_liquidacion_pago',
                direction: "ASC"
            },
            groupField:'tx_tipo_solicitud'

    });
    return this.Store;
},
fgetR: function(){
    this.Store = new Ext.data.GroupingStore({
            proxy: new Ext.data.HttpProxy({
                url:'<?php echo $url."/".$modulo ?>/listaPagos',
                method: 'POST'
            }),
            reader: new Ext.data.JsonReader({
                root: 'data',
                totalProperty: 'total'
            },
            [
                {name: 'co_pago'},
                {name: 'co_liquidacion_pago'},
                {name: 'tx_cuenta_bancaria'},
                {name: 'fe_pago'},
                {name: 'nu_pago'},
                {name: 'nu_monto'},
                {name: 'tx_banco'},
                {name: 'tx_descripcion'},
                {name: 'tx_forma_pago'}
            ]),
            sortInfo:{
                field: 'co_pago',
                direction: "ASC"
            },
            groupField:'tx_forma_pago'

    });
    return this.Store;
}
};
Ext.onReady(PagosPanel.main.init,PagosPanel.main);
</script>
<div id="contenedorPanel"></div>