<script type="text/javascript">
Ext.ns("RequisicionLista");
RequisicionLista.main = {
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
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        RequisicionLista.main.mascara.show();
        this.msg = Ext.get('formularioRequisicion');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Requisicion/editar',
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = RequisicionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_requisicion');
	RequisicionLista.main.mascara.show();
        this.msg = Ext.get('formularioRequisicion');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Requisicion/editar/codigo/'+this.codigo,
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
	this.codigo  = RequisicionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_requisicion');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Requisicion/eliminar',
            params:{
                co_requisicion:RequisicionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_requisicion')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    RequisicionLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                RequisicionLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroRequisicion');
        RequisicionLista.main.mascara.show();
        RequisicionLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Requisicion/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Requisicion',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.eliminar,'-',this.filtro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_requisicion',hidden:true, menuDisabled:true,dataIndex: 'co_requisicion'},
    {header: 'Co tipo solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_tipo_solicitud'},
    {header: 'Co usuario', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_usuario'},
    {header: 'Co ente', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_ente'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    {header: 'Tx concepto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_concepto'},
    {header: 'Tx observacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_observacion'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){RequisicionLista.main.editar.enable();RequisicionLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorRequisicionLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Requisicion/storelista',
    root:'data',
    fields:[
    {name: 'co_requisicion'},
    {name: 'co_tipo_solicitud'},
    {name: 'co_usuario'},
    {name: 'co_ente'},
    {name: 'created_at'},
    {name: 'tx_concepto'},
    {name: 'tx_observacion'},
           ]
    });
    return this.store;
}
};
Ext.onReady(RequisicionLista.main.init, RequisicionLista.main);
</script>
<div id="contenedorRequisicionLista"></div>
<div id="formularioRequisicion"></div>
<div id="filtroRequisicion"></div>
