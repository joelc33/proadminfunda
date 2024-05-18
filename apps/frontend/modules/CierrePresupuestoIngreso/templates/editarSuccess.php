<script type="text/javascript">
Ext.ns("DetalleCierrePresupuestoIngreso");
DetalleCierrePresupuestoIngreso.main = {
init:function(){

//objeto store
this.store_lista = this.getLista();

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.store_mes = this.getDataMes();


//<ClavePrimaria>
this.co_cierre_ingreso = new Ext.form.Hidden({
    name:'co_cierre_ingreso',
    value:this.OBJ.co_cierre_ingreso
});
//</ClavePrimaria>

this.hiddenJsonMovimiento  = new Ext.form.Hidden({
        name:'json_movimiento',
        value:''
});

this.fe_desde = new Ext.form.DateField({
	fieldLabel:'Fecha Desde',
	name:'fe_desde',
	value:this.OBJ.fe_desde,
	maxValue:this.OBJ.fe_hasta,
	width:100
});

this.fe_hasta = new Ext.form.DateField({
	fieldLabel:'Fecha Hasta',
	name:'fe_hasta',
	value:this.OBJ.fe_hasta,
        minValue:this.OBJ.fe_desde,
	width:100
});

this.tx_organismo = new Ext.form.TextField({
	fieldLabel:'Organismo',
	name:'tx_organismo',
	value:this.OBJ.tx_organismo,
	allowBlank:false,
	width:600
});


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

this.store_mes.load();

function formatoNro(val){
	return '<p align="right">'+paqueteComunJS.funcion.getNumeroFormateado(val)+'</p>';
}

this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Detalle del Movimiento',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:80,
    border:false,
//    tbar:[
//        this.editar,'-',this.excel,'-',this.excelDecreto,'-',this.excelSaldoInicial
//    ],
    columns: [
    new Ext.grid.RowNumberer(),
        {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},    
        {header: 'Devengado', width:250,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'mo_comprometido'},
        {header: 'Liquidado', width:250,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'mo_causado'},
        {header: 'Recaudado', width:250,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'mo_pagado'},
   ]
});


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
            if(!DetalleCierrePresupuestoIngreso.main.formFiltroPrincipal.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
                return false;
            }
            
            var list_movimiento = paqueteComunJS.funcion.getJsonByObjStore({
                store:DetalleCierrePresupuestoIngreso.main.gridPanel_.getStore()
            });
        
            DetalleCierrePresupuestoIngreso.main.hiddenJsonMovimiento.setValue(list_movimiento);

            DetalleCierrePresupuestoIngreso.main.formFiltroPrincipal.getForm().submit({
                method:'POST',
                url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CierrePresupuestoIngreso/guardar',
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
                     CierrePresupuestoIngreso.main.store_lista.load();
                     DetalleCierrePresupuestoIngreso.main.winformPanel_.close();
                 }
            });
        }});

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        DetalleCierrePresupuestoIngreso.main.winformPanel_.close();
    }
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
    items:[this.co_cierre_ingreso,
//            this.fe_desde,
//            this.fe_hasta,
            this.co_mes,
            this.ejercicio,
            this.hiddenJsonMovimiento],
    buttonAlign:'center',
    buttons:[
        {
            text:'Consultar',
            iconCls:'icon-buscar',
            handler:function(){
                DetalleCierrePresupuestoIngreso.main.aplicarFiltroByFormulario();
            }
        }
    ]
});

this.winformPanel_ = new Ext.Window({
    title:'Cierre Presupuesto Ingreso',
    modal:true,
    constrain:true,
    width:800,
    frame:true,
    closabled:true,
    height:320,
    items:[
        this.formFiltroPrincipal,
        this.gridPanel_
    ],
    buttons:[
        this.guardar,
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
CierrePresupuestoIngreso.main.mascara.hide();
},
aplicarFiltroByFormulario: function(){
	//Capturamos los campos con su value para posteriormente verificar cual
	//esta lleno y trabajar en base a ese.
	var campo = DetalleCierrePresupuestoIngreso.main.formFiltroPrincipal.getForm().getValues();

        DetalleCierrePresupuestoIngreso.main.store_lista.baseParams={}

	var swfiltrar = false;
	for(campName in campo){
	    if(campo[campName]!=''){
		swfiltrar = true;
		eval(" DetalleCierrePresupuestoIngreso.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
	    }
	}
	if(swfiltrar==true){
	    DetalleCierrePresupuestoIngreso.main.store_lista.baseParams.BuscarBy = true;
           // DetalleCierrePresupuestoIngreso.main.store_lista.baseParams.in_ventanilla = 'true';
	    DetalleCierrePresupuestoIngreso.main.store_lista.load();
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
	DetalleCierrePresupuestoIngreso.main.formFiltroPrincipal.getForm().reset();
	DetalleCierrePresupuestoIngreso.main.store_lista.baseParams={};
	DetalleCierrePresupuestoIngreso.main.store_lista.load();
},
getDataMes: function(){
var store =  new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/CierrePresupuestoEgreso/storelistaMes',
                root:'data',
                fields: ['co_mes','tx_mes']
 });
return store;
}, 
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CierrePresupuestoIngreso/storelista',
    root:'data',
    fields:[
            {name: 'mo_comprometido'},
            {name: 'mo_causado'},
            {name: 'mo_pagado'}
           ]
    });
    return this.store;
}
};
Ext.onReady(DetalleCierrePresupuestoIngreso.main.init, DetalleCierrePresupuestoIngreso.main);
</script>
