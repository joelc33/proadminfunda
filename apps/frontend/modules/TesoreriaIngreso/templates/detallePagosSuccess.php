<script type="text/javascript">
Ext.ns("PagosPanel");
PagosPanel.main = {
    co_liquidacion_pago: [],
    co_pago:     0,    
    co_tipo_solicitud:     0,
    co_solicitud:     0,
    co_ruta:0,
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
    text:'Ingresar',
    iconCls:'icon-pagos',
    handler:function(){
        this.co_liquidacion_pago = PagosPanel.main.co_liquidacion_pago;
        this.co_solicitud = PagosPanel.main.co_solicitud;
                var msg = Ext.get('muestra_contrib');
                    msg.load({
                    url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngreso/ingresar',
                    scripts: true,
                    params:{
                        co_liquidacion_pago: this.co_liquidacion_pago,
                        co_solicitud: PagosPanel.main.OBJ.co_solicitud,
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

//this.botonTxtPago = new Ext.Button({
//    text:'TXT de Pago',
//    iconCls:'icon-reporteVeh',
//    handler: function(){
//      window.open("http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']; ?>/reporte/txtpago/i/"+PagosPanel.main.OBJ.co_ruta);
//    }
//});
        



var scrollMenu = new Ext.menu.Menu();
scrollMenu.add({
    text: 'Soporte Ingreso',
    icon: '../images/ico_list.gif',
    handler: function(){
        if(PagosPanel.main.co_pago!=0){
             window.open("http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']; ?>/../reportes/SoportePago.php?codigo="+PagosPanel.main.co_pago);
        }else{
          Ext.MessageBox.alert('Alerta', "Debe seleccionar un pago");
        }
      
    }
    
    //co_pago
});

scrollMenu.add({
    text: 'Soporte Pago Ingreso',
    icon: '../images/ico_list.gif',
    handler: function(){
        window.open("http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']; ?>/../reportes/SoportePagoOrdenes.php?codigo="+PagosPanel.main.OBJ.co_solicitud);
    }    
});

scrollMenu.add({
    text: 'Archivo de Ingreso',
    iconCls:'icon-pagos',
    handler: function(){
      window.open("http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']; ?>/reporte/archivoPago/i/"+PagosPanel.main.OBJ.co_ruta);
    }    
});

this.botonTxtPago = new Ext.Button({
    text:'Reporte de Ingreso',
    icon: '../images/ico_list.gif',
    menu: scrollMenu

});

this.botonPagar.setDisabled(true);

this.toolbarP = new Ext.Toolbar({
   autoWidth:true,
   items:[
       this.botonPagar
   ]
});

this.toolbarR = new Ext.Toolbar({
   autoWidth:true,
   items:[
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
                var length = sm.selections.length, record = [];
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
        {header: 'Concepto', width:60 , sortable: true, hidden:true,groupable: false,  dataIndex: 'de_cuenta_concepto'},
        //{header: 'N°', width: 80,hideable: false,groupable: false, sortable: true,  dataIndex: 'tx_serial'},
        {header: 'Descripcion', width:90 , sortable: true,groupable: false,  dataIndex: 'de_cuota'},
        {header: 'Fecha de Pago', width:90 , sortable: true,groupable: false,  dataIndex: 'fe_pago'},
        {header: 'Monto Cuota',width: 120, sortable: true,groupable: false, renderer: formatoNumero,  dataIndex: 'mo_cuota'},
        {header: 'Monto Pagado', autoWidth: true, summaryType: 'totalPendiente',groupable: false, renderer: formatoNumero, sortable: true,  dataIndex: 'mo_pagado'},
      
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

this.toolbarR.setDisabled();

this.gridPagosR = new  Ext.grid.GridPanel({
    //autoWidth:true,
    height:420,
    tbar:[
        this.toolbarR
    ],
    store:this.storeR,
    columns:[
        new Ext.grid.RowNumberer(),
        {header: 'co_solicitud',width:60 , hidden:true,groupable: false,sortable: true,  dataIndex: 'co_solicitud'},
        {header: 'co_liquidacion_pago', width:60 , sortable: true, hidden:true,groupable: false,  dataIndex: 'co_liquidacion_pago'},
        {header: 'co_tipo_solicitud', width:60 , sortable: true, hidden:true,groupable: false,  dataIndex: 'co_tipo_solicitud'},
        {header: 'Concepto', width:60 , sortable: true, hidden:true,groupable: false,  dataIndex: 'de_cuenta_concepto'},
        //{header: 'N°', width: 80,hideable: false,groupable: false, sortable: true,  dataIndex: 'tx_serial'},
        {header: 'Descripcion', width:90 , sortable: true,groupable: false,  dataIndex: 'de_cuota'},
        {header: 'Fecha de Pago', width:90 , sortable: true,groupable: false,  dataIndex: 'fe_pago'},
        {header: 'Monto Cuota',width: 120, sortable: true,groupable: false, renderer: formatoNumero,  dataIndex: 'mo_cuota'},
        {header: 'Monto Pagado', autoWidth: true, summaryType: 'totalPendiente',groupable: false, renderer: formatoNumero, sortable: true,  dataIndex: 'mo_pagado'},
    ],
    view: new Ext.grid.GroupingView({
        groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Ingresos" : "Ingreso"]})',
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
                    PagosPanel.main.co_ruta = rec.json.co_ruta;
                    PagosPanel.main.toolbarR.setDisabled(false);
                }
         }
    })
});

this.tabpanel = new Ext.TabPanel({
    activeTab:0,
    items:[
        {
            title:'Ingresos Pendientes',
            items:[this.gridPagosP],
            autoHeight:true
        },
        {
            title:'Ingresos Realizados',
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
                {name: 'fe_pago'},
                {name: 'mo_pendiente'},
                {name: 'mo_pagado'},
                {name: 'de_cuota'},
                {name: 'mo_cuota'},
                {name: 'nu_anio'},
                {name: 'tx_serial'},
                {name: 'de_cuenta_concepto'}
            ]),
            sortInfo:{
                field: 'co_liquidacion_pago',
                direction: "ASC"
            },
            groupField:'de_cuenta_concepto'

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
                {name: 'co_liquidacion_pago'},
                {name: 'co_solicitud'},
                {name: 'fe_pago'},
                {name: 'mo_pendiente'},
                {name: 'mo_pagado'},
                {name: 'de_cuota'},
                {name: 'mo_cuota'},
                {name: 'nu_anio'},
                {name: 'tx_serial'},
                {name: 'de_cuenta_concepto'}
            ]),
            sortInfo:{
                field: 'co_liquidacion_pago',
                direction: "ASC"
            },
            groupField:'de_cuenta_concepto'

    });
    return this.Store;
}
};
Ext.onReady(PagosPanel.main.init,PagosPanel.main);
</script>
<div id="contenedorPanel"></div>