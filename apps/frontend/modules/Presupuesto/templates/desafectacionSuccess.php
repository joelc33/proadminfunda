<script type="text/javascript">
Ext.ns("DetalleCierrePresupuestoEgreso");
DetalleCierrePresupuestoEgreso.main = {
    co_orden_pago: [],
init:function(){

//objeto store
this.store_lista = this.getLista();

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.store_mes = this.getDataMes();


//<ClavePrimaria>
this.co_solicitud = new Ext.form.Hidden({
    name:'co_solicitud',
    value:this.OBJ.co_solicitud
});
//</ClavePrimaria>

this.hiddenJsonMovimiento  = new Ext.form.Hidden({
        name:'json_movimiento',
        value:''
});

this.fe_desde = new Ext.form.DateField({
	fieldLabel:'Desde',
	name:'fe_desde',
	width:100
});

this.fe_hasta = new Ext.form.DateField({
	fieldLabel:'Hasta',
	name:'fe_hasta',
	width:100
});


function formatoNro(val){
    
        if(val==null){
            val = 0;
        }
	return '<p align="right">'+paqueteComunJS.funcion.getNumeroFormateado(val)+'</p>';
}


function renderMonto(val, attr, record) { 
     return paqueteComunJS.funcion.getNumeroFormateado(val);     
} 

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


var length = sm.selections.length
, record = [];
        if(length>0){

        for(var i = 0; i<length;i++){
           record.push(sm.selections.items[i].data.co_orden_pago);                        
        
            }            
            
}
DetalleCierrePresupuestoEgreso.main.co_orden_pago.push(record);
       console.log(record);
       //alert(record);
            
    }
            

 }
});

this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Ordenes de Pago',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:430,
    sm: myCboxSelModel,
    columns: [
    new Ext.grid.RowNumberer(),
    myCboxSelModel,
    {header: 'co_orden_pago',hidden:true, menuDisabled:true,dataIndex: 'co_orden_pago'},
    {header: 'Orden de Pago', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_serial'},
    {header: 'Rif', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_rif'},
    {header: 'Razon Social', width:370,  menuDisabled:true, sortable: true,  dataIndex: 'tx_razon_social'},
    {header: 'Monto Disponible', width:180,  menuDisabled:true, sortable: true,  dataIndex: 'mo_pendiente',renderer:renderMonto}
    ],
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


this.guardar = new Ext.Button({
    text:'Pocesar',
    iconCls: 'icon-guardar',
    handler:function(){           
        

      Ext.MessageBox.confirm('Confirmación', '¿Realmente desea procesar el cierre?', function(boton){
      if(boton=="yes"){
            if(!DetalleCierrePresupuestoEgreso.main.formFiltroPrincipal.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
                return false;
            }
            
            var list_movimiento = paqueteComunJS.funcion.getJsonByObjStore({
                store:DetalleCierrePresupuestoEgreso.main.gridPanel_.getStore()
            });
        
            DetalleCierrePresupuestoEgreso.main.hiddenJsonMovimiento.setValue(DetalleCierrePresupuestoEgreso.main.co_orden_pago);

            DetalleCierrePresupuestoEgreso.main.formFiltroPrincipal.getForm().submit({
                method:'POST',
                url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/guardarDesafectacion',
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
    title:'Busqueda',
    iconCls: 'icon-solpendiente',
    collapsible: true,
    titleCollapse: true,
    autoWidth:true,
    border:false,
    labelWidth: 110,
    padding:'10px',
    items:[this.co_solicitud,
            this.fe_desde,
            this.fe_hasta,
            this.hiddenJsonMovimiento],
    buttonAlign:'center',
    buttons:[
        {
            text:'Consultar',
            iconCls:'icon-buscar',
            handler:function(){                
                
                DetalleCierrePresupuestoEgreso.main.aplicarFiltroByFormulario();
            }
        }
    ]
});

this.winformPanel_ = new Ext.Window({
    title:'Desafectacion de ordenes de Pago',
    modal:true,
    constrain:true,
    width:800,
    frame:true,
    closabled:true,
    height:630,
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
        if(DetalleCierrePresupuestoEgreso.main.fe_desde.getValue()==''){
            Ext.Msg.alert("Alerta","Debe ingresar correctamente los paramentros de busqueda requeridos");
            return false;
        }      
        if(DetalleCierrePresupuestoEgreso.main.fe_hasta.getValue()==''){
            Ext.Msg.alert("Alerta","Debe ingresar correctamente los paramentros de busqueda requeridos");
            return false;
        }         
        
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
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storelistaDesafectacion',
    root:'data',
    fields:[
            {name: 'tx_serial'},
            {name: 'mo_pendiente'},
            {name: 'co_orden_pago'},
            {name: 'tx_rif'},
            {name: 'tx_razon_social'}
           ]
    });
    return this.store;
}
};
Ext.onReady(DetalleCierrePresupuestoEgreso.main.init, DetalleCierrePresupuestoEgreso.main);
</script>
<div id="formularioPresupuestoEgreso"></div>
