<script type="text/javascript">
Ext.ns("CierrePresupuestoEgreso");
CierrePresupuestoEgreso.main = {
    co_comprobante_contable: [],
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Cerrar Comprobante',
    iconCls: 'icon-nuevo',
    handler:function(){
	//this.co_comprobante_contable = CierrePresupuestoEgreso.main.co_comprobante_contable;
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea cerrar este comprobante?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CierreContable/guardarCierreDiario',
            params:{
                co_comprobante_contable:CierrePresupuestoEgreso.main.co_comprobante_contable
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    CierrePresupuestoEgreso.main.store_lista.load();
                    CierrePresupuestoEgreso.main.nuevo.disable();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                CierrePresupuestoEgreso.main.mascara.hide();
            }});
	}});
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Detalle',
    iconCls: 'icon-reporteest',
    handler:function(){
	//CierrePresupuestoEgreso.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoEgreso');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CierreContable/detalle',
         params:{
                co_comprobante_contable:CierrePresupuestoEgreso.main.gridPanel_.getSelectionModel().getSelected().get('co_comprobante_contable')
            },
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Eliminar un registro
this.eliminar= new Ext.Button({
    text:'Eliminar',
    iconCls: 'icon-eliminar',
    handler:function(){
	this.codigo  = CierrePresupuestoEgreso.main.gridPanel_.getSelectionModel().getSelected().get('co_presupuesto_ingreso');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoIngreso/eliminar',
            params:{
                co_presupuesto_ingreso:CierrePresupuestoEgreso.main.gridPanel_.getSelectionModel().getSelected().get('co_presupuesto_ingreso')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    CierrePresupuestoEgreso.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                CierrePresupuestoEgreso.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroPresupuestoIngreso');
        CierrePresupuestoEgreso.main.mascara.show();
        CierrePresupuestoEgreso.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoIngreso/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();
this.nuevo.disable();

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
            CierrePresupuestoEgreso.main.editar.setDisabled(true);
var contabilizado = 0;
var length = sm.selections.length
, record = [];
        if(length>0){
            if(length==1){
           CierrePresupuestoEgreso.main.editar.setDisabled(false);
       }else{
           CierrePresupuestoEgreso.main.editar.setDisabled(true);
            }
        for(var i = 0; i<length;i++){
           record.push(sm.selections.items[i].data.co_comprobante_contable);                        
            if(sm.selections.items[i].data.in_contabilizado=='NO'){
          
        }else{
            var contabilizado = 1; 
        }        
            }
            
            if(contabilizado==0){
          CierrePresupuestoEgreso.main.nuevo.setDisabled(false);
        }else{
        CierrePresupuestoEgreso.main.nuevo.setDisabled(true);    
        }             
            
}
CierrePresupuestoEgreso.main.co_comprobante_contable.push(record);
       console.log(record);
       //alert(record);
            
    }
            

 }
});

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Cierres Diarios Contables',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo ,'-',this.editar//,'-',this.eliminar,'-',this.filtro      
    ],
    sm: myCboxSelModel,
    columns: [
    new Ext.grid.RowNumberer(),
    myCboxSelModel,
    {header: 'co_comprobante_contable',hidden:true, menuDisabled:true,dataIndex: 'co_comprobante_contable'},
    {header: 'Fecha', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'fe_comprobante'},
    {header: 'Tipo Documento', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tipo_asiento'},
    {header: 'Nro Comprobante', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_comprobante'},
    {header: 'Monto Debito', width:180,  menuDisabled:true, sortable: true,  dataIndex: 'mo_debito',renderer:renderMonto},
    {header: 'Monto Credito', width:180,  menuDisabled:true, sortable: true,  dataIndex: 'mo_credito',renderer:renderMonto},
    {header: 'Contabilizado', width:180,  menuDisabled:true, sortable: true,  dataIndex: 'in_contabilizado',renderer:renderContabilizado}
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

this.gridPanel_.render("contenedorCierrePresupuestoEgreso");


this.store_lista.load();
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
Ext.onReady(CierrePresupuestoEgreso.main.init, CierrePresupuestoEgreso.main);
</script>
<div id="contenedorCierrePresupuestoEgreso"></div>
<div id="formularioPresupuestoEgreso"></div>
<div id="filtroPresupuestoIngreso"></div>
