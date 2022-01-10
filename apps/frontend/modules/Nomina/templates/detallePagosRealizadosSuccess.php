<script type="text/javascript">
Ext.ns("PagosPanel");
PagosPanel.main = {
    co_liquidacion_pago:     0,
    co_pago:     0,    
    co_tipo_solicitud:     0,
    co_solicitud:     0,
    arreglo_nomina: [],
    init:function(){
        this.OBJ = doJSON('<?php echo $data ?>');

this.storeR = PagosPanel.main.fgetR();


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
        
this.botonPagar.setDisabled(true);

var scrollMenu = new Ext.menu.Menu();
scrollMenu.add({
    text: 'Presupuestarias',
    icon: '../images/ico_list.gif',
    handler: function(){

        PagosPanel.main.hiddenJsonNomina.setValue(PagosPanel.main.arreglo_nomina);

        //this.codigo  = PagosPanel.main.gridPagosR.getSelectionModel().getSelected().get('co_nomina');
        this.codigo  = PagosPanel.main.hiddenJsonNomina.getValue();
        if(this.codigo!=0){
             window.open("<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/presupuesto/codigo/"+this.codigo);
        }else{
          Ext.MessageBox.alert('Alerta', "Debe seleccionar una nomina!");
        }
      
    }
    
    //co_pago
});

scrollMenu.add({
    text: 'Lista Unificada',
    icon: '../images/ico_list.gif',
    handler: function(){

        PagosPanel.main.hiddenJsonNomina.setValue(PagosPanel.main.arreglo_nomina);

        //this.codigo  = PagosPanel.main.gridPagosR.getSelectionModel().getSelected().get('co_nomina');
        this.codigo  = PagosPanel.main.hiddenJsonNomina.getValue();
        if(this.codigo!=0){
             window.open("<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/unificado/codigo/"+this.codigo);
        }else{
          Ext.MessageBox.alert('Alerta', "Debe seleccionar una nomina!");
        }
    }    
});

scrollMenu.add({
    text: 'Lista Unificada Cheques Embargos',
    icon: '../images/ico_list.gif',
    handler: function(){

        PagosPanel.main.hiddenJsonNomina.setValue(PagosPanel.main.arreglo_nomina);

        //this.codigo  = PagosPanel.main.gridPagosR.getSelectionModel().getSelected().get('co_nomina');
        this.codigo  = PagosPanel.main.hiddenJsonNomina.getValue();
        if(this.codigo!=0){
             window.open("<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/unificadoCheque/codigo/"+this.codigo);
        }else{
          Ext.MessageBox.alert('Alerta', "Debe seleccionar una nomina!");
        }
    }    
});

scrollMenu.add({
    text: 'Lista Patria BOD',
    icon: '../images/ico_list.gif',
    handler: function(){

        PagosPanel.main.hiddenJsonNomina.setValue(PagosPanel.main.arreglo_nomina);

        //this.codigo  = PagosPanel.main.gridPagosR.getSelectionModel().getSelected().get('co_nomina');
        this.codigo  = PagosPanel.main.hiddenJsonNomina.getValue();
        if(this.codigo!=0){
             window.open("<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/patriaBod/codigo/"+this.codigo);
        }else{
          Ext.MessageBox.alert('Alerta', "Debe seleccionar una nomina!");
        }
    }    
});

scrollMenu.add({
    text: 'Lista Patria VENEZUELA',
    icon: '../images/ico_list.gif',
    handler: function(){

        PagosPanel.main.hiddenJsonNomina.setValue(PagosPanel.main.arreglo_nomina);

        //this.codigo  = PagosPanel.main.gridPagosR.getSelectionModel().getSelected().get('co_nomina');
        this.codigo  = PagosPanel.main.hiddenJsonNomina.getValue();
        if(this.codigo!=0){
             window.open("<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/patriaVenezuela/codigo/"+this.codigo);
        }else{
          Ext.MessageBox.alert('Alerta', "Debe seleccionar una nomina!");
        }
    }    
});

scrollMenu.add({
    text: 'Lista Patria PROVINCIAL',
    icon: '../images/ico_list.gif',
    handler: function(){

        PagosPanel.main.hiddenJsonNomina.setValue(PagosPanel.main.arreglo_nomina);

        //this.codigo  = PagosPanel.main.gridPagosR.getSelectionModel().getSelected().get('co_nomina');
        this.codigo  = PagosPanel.main.hiddenJsonNomina.getValue();
        if(this.codigo!=0){
             window.open("<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/patriaProvincial/codigo/"+this.codigo);
        }else{
          Ext.MessageBox.alert('Alerta', "Debe seleccionar una nomina!");
        }
    }    
});

this.botonTxtPago = new Ext.Button({
    text:'Archivos de Pago',
    icon: '../images/ico_list.gif',
    menu: scrollMenu
});

var scrollMenuReporte = new Ext.menu.Menu();
scrollMenuReporte.add({
    text: 'Resumen por Conceptos',
    icon: '../images/monto.png',
    handler: function(){

        PagosPanel.main.hiddenJsonNomina.setValue(PagosPanel.main.arreglo_nomina);

        //this.codigo  = PagosPanel.main.gridPagosR.getSelectionModel().getSelected().get('co_nomina');
        this.codigo  = PagosPanel.main.hiddenJsonNomina.getValue();
        if(this.codigo!=0){
             /*window.open("<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/presupuesto/codigo/"+this.codigo);*/
             window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/rrhhResumenConcepto.php?codigo='+this.codigo);
        }else{
          Ext.MessageBox.alert('Alerta', "Debe seleccionar una nomina!");
        }
      
    }

});

scrollMenuReporte.add({
    text: 'Resumen de Depositos',
    icon: '../images/monto.png',
    handler: function(){

        PagosPanel.main.hiddenJsonNomina.setValue(PagosPanel.main.arreglo_nomina);

        //this.codigo  = PagosPanel.main.gridPagosR.getSelectionModel().getSelected().get('co_nomina');
        this.codigo  = PagosPanel.main.hiddenJsonNomina.getValue();
        if(this.codigo!=0){
             /*window.open("<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/presupuesto/codigo/"+this.codigo);*/
             window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/rrhhResumenDeposito.php?codigo='+this.codigo);
        }else{
          Ext.MessageBox.alert('Alerta', "Debe seleccionar una nomina!");
        }
      
    }

});

scrollMenuReporte.add({
    text: 'Resumen de Depositos Embargos',
    icon: '../images/monto.png',
    handler: function(){

        PagosPanel.main.hiddenJsonNomina.setValue(PagosPanel.main.arreglo_nomina);

        //this.codigo  = PagosPanel.main.gridPagosR.getSelectionModel().getSelected().get('co_nomina');
        this.codigo  = PagosPanel.main.hiddenJsonNomina.getValue();
        if(this.codigo!=0){
             /*window.open("<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/presupuesto/codigo/"+this.codigo);*/
             window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/rrhhResumenDepositoEmbargo.php?codigo='+this.codigo);
        }else{
          Ext.MessageBox.alert('Alerta', "Debe seleccionar una nomina!");
        }
      
    }

});

scrollMenuReporte.add({
    text: 'Detalle Fondo de Terceros Embargo',
    icon: '../images/monto.png',
    handler: function(){

        PagosPanel.main.hiddenJsonNomina.setValue(PagosPanel.main.arreglo_nomina);

        //this.codigo  = PagosPanel.main.gridPagosR.getSelectionModel().getSelected().get('co_nomina');
        this.codigo  = PagosPanel.main.hiddenJsonNomina.getValue();
        if(this.codigo!=0){
             /*window.open("<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/presupuesto/codigo/"+this.codigo);*/
             window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/rrhhDetalleTerceroEmbargo.php?codigo='+this.codigo);
        }else{
          Ext.MessageBox.alert('Alerta', "Debe seleccionar una nomina!");
        }
      
    }

});

scrollMenuReporte.add({
    text: 'Imprimir Cheques Embargos',
    icon: '../images/monto.png',
    handler: function(){

        PagosPanel.main.hiddenJsonNomina.setValue(PagosPanel.main.arreglo_nomina);
        this.codigo  = PagosPanel.main.hiddenJsonNomina.getValue();
        if(this.codigo!=0){
                var msg = Ext.get('muestra_contrib');
                    msg.load({
                    url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/ChequeEmbargo',
                    scripts: true,
                    params:{
                        codigo:this.codigo
                    },
                    text: 'Cargando...'
                    });
                    msg.show();
        }else{
          Ext.MessageBox.alert('Alerta', "Debe seleccionar una nomina!");
        }
      
    }

});

scrollMenuReporte.add({
    text: 'Detalle Firmas Embargo',
    icon: '../images/monto.png',
    handler: function(){

        PagosPanel.main.hiddenJsonNomina.setValue(PagosPanel.main.arreglo_nomina);

        //this.codigo  = PagosPanel.main.gridPagosR.getSelectionModel().getSelected().get('co_nomina');
        this.codigo  = PagosPanel.main.hiddenJsonNomina.getValue();
        if(this.codigo!=0){
             /*window.open("<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/presupuesto/codigo/"+this.codigo);*/
             window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/rrhhDetalleFirmaEmbargo.php?codigo='+this.codigo);
        }else{
          Ext.MessageBox.alert('Alerta', "Debe seleccionar una nomina!");
        }
      
    }

});

scrollMenuReporte.add({
    text: 'Resumen de Conceptos Por Nomina',
    icon: '../images/monto.png',
    handler: function(){

        PagosPanel.main.hiddenJsonNomina.setValue(PagosPanel.main.arreglo_nomina);

        //this.codigo  = PagosPanel.main.gridPagosR.getSelectionModel().getSelected().get('co_nomina');
        this.codigo  = PagosPanel.main.hiddenJsonNomina.getValue();
        if(this.codigo!=0){
             /*window.open("<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/presupuesto/codigo/"+this.codigo);*/
             window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/rrhhResumenConceptoNomina.php?codigo='+this.codigo);
        }else{
          Ext.MessageBox.alert('Alerta', "Debe seleccionar una nomina!");
        }
      
    }

});

scrollMenuReporte.add({
    text: 'Resumen por Nomina',
    icon: '../images/monto.png',
    handler: function(){

        PagosPanel.main.hiddenJsonNomina.setValue(PagosPanel.main.arreglo_nomina);

        //this.codigo  = PagosPanel.main.gridPagosR.getSelectionModel().getSelected().get('co_nomina');
        this.codigo  = PagosPanel.main.hiddenJsonNomina.getValue();
        if(this.codigo!=0){
             /*window.open("<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/presupuesto/codigo/"+this.codigo);*/
             window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/rrhhResumenNomina.php?codigo='+this.codigo);
        }else{
          Ext.MessageBox.alert('Alerta', "Debe seleccionar una nomina!");
        }
      
    }

});

scrollMenuReporte.add({
    text: 'Resumen por Sucursal',
    icon: '../images/monto.png',
    handler: function(){

        PagosPanel.main.hiddenJsonNomina.setValue(PagosPanel.main.arreglo_nomina);

        //this.codigo  = PagosPanel.main.gridPagosR.getSelectionModel().getSelected().get('co_nomina');
        this.codigo  = PagosPanel.main.hiddenJsonNomina.getValue();
        if(this.codigo!=0){
             /*window.open("<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/presupuesto/codigo/"+this.codigo);*/
             window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/rrhhResumenSucursal.php?codigo='+this.codigo);
        }else{
          Ext.MessageBox.alert('Alerta', "Debe seleccionar una nomina!");
        }
      
    }

});

this.botonTxtReportes = new Ext.Button({
    text:'Reportes de Pago',
    icon: '../images/impresora.png',
    menu: scrollMenuReporte
});

this.botonFechaPago = new Ext.Button({
    text:'Asignar Fecha Pago',
    iconCls:'icon-calendar',
    handler: function(){

        PagosPanel.main.hiddenJsonNomina.setValue(PagosPanel.main.arreglo_nomina);
        this.codigo  = PagosPanel.main.hiddenJsonNomina.getValue();
        if(this.codigo!=0){
            var msg = Ext.get('muestra_contrib');
                msg.load({
                    url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/fecha',
                    scripts: true,
                    params:{
                        codigo: this.codigo
                    },
                    text: 'Cargando...'
                });
                msg.show();
        }else{
            Ext.MessageBox.alert('Alerta', "Debe seleccionar una nomina!");
        }
    }
});
        
this.botonFechaPago.setDisabled(true);

this.hiddenJsonNomina = new Ext.form.Hidden({
        name:'json_nomina',
        value:''
});

var myCboxSelModel = new Ext.grid.CheckboxSelectionModel({
    // override private method to allow toggling of selection on or off for multiple rows.
    handleMouseDown : function(g, rowIndex, e){
        var view = this.grid.getView();
        var isSelected = this.isSelected(rowIndex);
        if(isSelected) {  
            this.deselectRow(rowIndex);
        }else if(!isSelected || this.getCount() > 1) {
            this.selectRow(rowIndex, true);
            view.focusRow(rowIndex);
        }else{
            this.deselectRow(rowIndex);
        }
    },
    singleSelect: false,
    listeners: {
        selectionchange: function(sm, rowIndex, rec) {

            //PagosPanel.main.abrir.enable();
            //PagosPanel.main.cerrar.enable();
            PagosPanel.main.botonFechaPago.enable();

        var length = sm.selections.length, record = [];
        if(length>0){
            
            for(var i = 0; i<length;i++){

                //record.push( { id: sm.selections.items[i].data.id, nu_valor: sm.selections.items[i].data.nu_valor } );
                //record.push( {co_nomina: sm.selections.items[i].data.co_nomina, co_solicitud: sm.selections.items[i].data.co_solicitud });
                record.push( {co_nomina: sm.selections.items[i].data.co_nomina });
            
            }
            
        }
            delete PagosPanel.main.arreglo_nomina.splice(0,PagosPanel.main.arreglo_nomina.length);
            PagosPanel.main.arreglo_nomina.push(JSON.stringify(record));
            console.log(record);
            //alert(record);
                
        }
    }
});

this.gridPagosR = new  Ext.grid.GridPanel({
    //autoWidth:true,
    sm: myCboxSelModel,
    height:420,
    tbar:[
        this.botonTxtPago,'-',this.botonTxtReportes,'-',this.botonFechaPago
    ],
    store:this.storeR,
    columns:[
        new Ext.grid.RowNumberer(),
        myCboxSelModel,
        {header: 'co_nomina',hidden:true, menuDisabled:true,dataIndex: 'co_nomina'},
        {header: 'co_solicitud',hidden:true, menuDisabled:true,dataIndex: 'co_solicitud'},
        {header: 'Nomina', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nomina', renderer:textoLargo },
        {header: 'Sub-Grupo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'cod_grupo_nomina', renderer:textoLargo},
        {header: 'Frecuencia de Pago', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_nom_frecuencia_pago', renderer:textoLargo},
        {header: 'Inicio', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_inicio'},
        {header: 'Cierre', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_fin'},
        {header: 'Fecha de Pago', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_pago'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
});

this.formpanel = new Ext.Panel({
    autoWidth: true,
    autoHeight:true,
    bodyStyle:'padding:0px',
    layout:'form',
    border:false,
    items:[this.gridPagosR],
    renderTo: 'contenedorPanel'
});

},
fgetR: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/storelistaFinal',
    root:'data',
    fields:[
    {name: 'co_nomina'},
    {name: 'co_solicitud'},
    {name: 'co_tp_nomina'},
    {name: 'co_nom_frecuencia_pago'},
    {name: 'nu_nomina'},
    {name: 'de_nomina'},
    {name: 'de_observacion'},
    {name: 'fe_inicio'},
    {name: 'fe_fin'},
    {name: 'fe_pago'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'in_procesado'},
    {name: 'id_tbrh060_nomina_estatus'},
    {name: 'cod_grupo_nomina'},
    {
        name: 'nomina',
        convert: function(v, r) {
                return r.cod_nomina + ' - ' + r.co_tp_nomina;
        }
    }
           ]
    });
    return this.store;
}
};
Ext.onReady(PagosPanel.main.init,PagosPanel.main);
</script>
<div id="contenedorPanel"></div>