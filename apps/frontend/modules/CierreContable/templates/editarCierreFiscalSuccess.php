<script type="text/javascript">
Ext.ns("DetalleCierrePresupuestoEgreso");
DetalleCierrePresupuestoEgreso.main = {
init:function(){

//objeto store
this.store_lista = this.getLista();

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.store_mes = this.getDataMes();
//</ClavePrimaria>

this.hiddenJsonMovimiento  = new Ext.form.Hidden({
        name:'json_movimiento',
        value:''
});

this.fe_desde = new Ext.form.DateField({
	fieldLabel:'Desde',
	name:'fe_desde',
        readOnly:true,
	value:this.OBJ.fe_desde,
	maxValue:this.OBJ.fe_hasta,
	width:100
});

this.fe_hasta = new Ext.form.DateField({
	fieldLabel:'Hasta',
	name:'fe_hasta',
        readOnly:true,
        value:this.OBJ.fe_hasta,
        minValue:this.OBJ.fe_desde,
	maxValue:this.OBJ.fe_hasta,
	width:100
});

this.tx_organismo = new Ext.form.TextField({
	fieldLabel:'Organismo',
	name:'tx_organismo',
	value:this.OBJ.tx_organismo,
	allowBlank:false,
	width:600
});

function formatoNro(val){
    
        if(val==null){
            val = 0;
        }
	return '<p align="right">'+paqueteComunJS.funcion.getNumeroFormateado(val)+'</p>';
}

this.co_mes = new Ext.form.ComboBox({
    fieldLabel : 'Mes',
    displayField:'tx_mes',
    store: this.store_mes,
    typeAhead: true,
    valueField: 'co_mes',
    hiddenName:'co_mes',
    name: 'co_mes',
    id: 'co_mes',
    triggerAction: 'all',
    emptyText:'Seleccione...',
    selectOnFocus:true,
    mode:'local',
    width:100,
    resizable:true
});

//this.store_mes.load();

this.editar= new Ext.Button({
    text:'Ver Detalle',
    iconCls: 'icon-reporteest',
    handler:function(){
	//CierrePresupuestoEgreso.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoEgreso');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CierreContable/detalle',
         params:{
                co_comprobante_contable:DetalleCierrePresupuestoEgreso.main.gridPanel_.getSelectionModel().getSelected().get('co_comprobante_contable')
            },
         scripts: true,
         text: "Cargando.."
        });
    }
});
this.editar.disable();

function renderTipoAsiento(val, attr, record) { 
    if(parseFloat(record.data.mo_debe) < parseFloat(record.data.mo_haber)){
        return '<p style="color:red"><b>'+record.data.fecha+'</b></p>';     
     }else{
       return record.data.fecha; 
         }
}

function renderMonto(val, attr, record) { 
     return paqueteComunJS.funcion.getNumeroFormateado(val);     
} 

function renderContabilizado(val, attr, record) { 
    if(record.data.in_contabilizado=='SI')
    {
       return '<p style="color:green">'+val+'</p>'    
        
    }else
    {
      return '<p style="color:red">'+val+'</p>'
    }
     
} 

this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Detalle comprobantes',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:440,
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
    {header: 'Monto Debito', width:130,  menuDisabled:true, sortable: true,  dataIndex: 'mo_debito',renderer:renderMonto},
    {header: 'Monto Credito', width:130,  menuDisabled:true, sortable: true,  dataIndex: 'mo_credito',renderer:renderMonto},
    {header: 'Contabilizado', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'in_contabilizado',renderer:renderContabilizado}
    ],
   listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){DetalleCierrePresupuestoEgreso.main.editar.enable();}},
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })    
});

this.store_lista.load();

this.ejercicio = new Ext.form.NumberField({
	fieldLabel:'Ejercicio',
	name:'ejercicio',
	value:this.OBJ.ejercicio,
	allowBlank:false,
        readOnly:true,
	width:100
});


this.guardar = new Ext.Button({
    text:'Pocesar',
    iconCls: 'icon-guardar',
    handler:function(){       

      Ext.MessageBox.confirm('Confirmación', '¿Realmente desea procesar el cierre?', function(boton){
      if(boton=="yes"){
          
            DetalleCierrePresupuestoEgreso.main.guardar.setDisabled(true);          
            if(!DetalleCierrePresupuestoEgreso.main.formFiltroPrincipal.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
                return false;
            }

            DetalleCierrePresupuestoEgreso.main.formFiltroPrincipal.getForm().submit({
                method:'POST',
                url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CierreContable/guardarCierreFiscal',
                waitMsg: 'Enviando datos, por favor espere..',
                waitTitle:'Enviando',
                failure: function(form, action) {
                    Ext.MessageBox.alert('Error en transacción', action.result.msg);
                },
                success: function(form, action) {
                     if(action.result.success){
                         Ext.MessageBox.show({
                             title: 'Mensaje',
                             msg: action.result.msg,
                             closable: false,
                             icon: Ext.MessageBox.INFO,
                             resizable: false,
                             animEl: document.body,
                             buttons: Ext.MessageBox.OK
                         });
                     }
                     CierrePresupuestoEgreso.main.store_lista.load();
                    
                     DetalleCierrePresupuestoEgreso.main.winformPanel_.close();
                 }
            });
        }});

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        DetalleCierrePresupuestoEgreso.main.winformPanel_.close();
    }
});

this.formFiltroPrincipal = new Ext.form.FormPanel({
    title:'Detalle',
    iconCls: 'icon-solpendiente',
    collapsible: true,
    titleCollapse: true,
    autoWidth:true,
    border:false,
    labelWidth: 110,
    padding:'10px',
    items:[
//            this.fe_desde,
//            this.fe_hasta,
            //this.co_mes,
            this.ejercicio,
            this.hiddenJsonMovimiento]
//    buttonAlign:'center',
//    buttons:[
//        {
//            text:'Consultar',
//            iconCls:'icon-buscar',
//            handler:function(){
//                DetalleCierrePresupuestoEgreso.main.aplicarFiltroByFormulario();
//            }
//        }
//    ]
});

this.winformPanel_ = new Ext.Window({
    title:'Nuevo Cierre Ejercicio Fiscal Contable',
    modal:true,
    constrain:true,
    width:800,
    frame:true,
    closabled:true,
    height:130,
    items:[
        this.formFiltroPrincipal,
//        this.gridPanel_
    ],
    buttons:[
        this.guardar,
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
CierrePresupuestoEgreso.main.mascara.hide();
},
getDataMes: function(){
var store =  new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/CierrePresupuestoEgreso/storelistaMes',
                root:'data',
                fields: ['co_mes','tx_mes']
 });
return store;
},
aplicarFiltroByFormulario: function(){
	//Capturamos los campos con su value para posteriormente verificar cual
	//esta lleno y trabajar en base a ese.
	var campo = DetalleCierrePresupuestoEgreso.main.formFiltroPrincipal.getForm().getValues();

        DetalleCierrePresupuestoEgreso.main.store_lista.baseParams={}

	var swfiltrar = false;
	for(campName in campo){
	    if(campo[campName]!=''){
		swfiltrar = true;
		eval(" DetalleCierrePresupuestoEgreso.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
	    }
	}
	if(swfiltrar==true){
	    DetalleCierrePresupuestoEgreso.main.store_lista.baseParams.BuscarBy = true;
           // DetalleCierrePresupuestoEgreso.main.store_lista.baseParams.in_ventanilla = 'true';
	    DetalleCierrePresupuestoEgreso.main.store_lista.load();
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
	DetalleCierrePresupuestoEgreso.main.formFiltroPrincipal.getForm().reset();
	DetalleCierrePresupuestoEgreso.main.store_lista.baseParams={};
	DetalleCierrePresupuestoEgreso.main.store_lista.load();
}, 
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CierreContable/storelistaMovimiento',
    root:'data',
    fields:[
            {name: 'co_comprobante_contable'},
            {name: 'nu_comprobante'},
            {name: 'mo_debito'},
            {name: 'mo_credito'},
            {name: 'tx_tipo_asiento'},
            {name: 'fe_comprobante'},
            {name: 'in_contabilizado'}
           ]
    });
    return this.store;
}
};
Ext.onReady(DetalleCierrePresupuestoEgreso.main.init, DetalleCierrePresupuestoEgreso.main);
</script>
<div id="formularioPresupuestoEgreso"></div>
