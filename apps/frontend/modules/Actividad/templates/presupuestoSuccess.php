<script type="text/javascript">
Ext.ns("ActividadLista");
ActividadLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
//Mascara general del modulo
this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();


//Editar un registro
this.editar= new Ext.Button({
    text:'Presupuesto',
    iconCls: 'icon-editar',
    handler:function(){
	ActividadLista.main.mascara.show();
        this.msg = Ext.get('formularioActividad');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto',
         scripts: true,
         text: "Cargando..",
         params:{
             co_actividad:ActividadLista.main.gridPanel_.getSelectionModel().getSelected().get('co_actividad')
         }
        });
    }
});



this.editar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Actividad',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:350,
    tbar:[
       this.editar
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_actividad',hidden:true, menuDisabled:true,dataIndex: 'co_actividad'},
   // {header: 'Co programa', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_programa'},
    {header: 'Código', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_actividad'},
    {header: 'Descripión', width:600,  menuDisabled:true, sortable: true,  dataIndex: 'tx_denominacion_act'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
        ActividadLista.main.editar.enable();
    }},
    bbar: new Ext.PagingToolbar({
        pageSize: 12,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.salir = new Ext.Button({
    text:'Cerrar',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ActividadLista.main.winformPanel_.close();
    }
});


this.winformPanel_ = new Ext.Window({
    title:'Actividad',
    modal:true,
    constrain:true,
    width:800,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.gridPanel_
    ],
    buttons:[
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
ActividadLista.main.store_lista.baseParams.co_programa=ActividadLista.main.OBJ.co_programa;
this.store_lista.load();
ActividadLista.main.mascara.hide();


},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Actividad/storelista',
    root:'data',
    fields:[
    {name: 'co_actividad'},
    {name: 'co_programa'},
    {name: 'tx_actividad'},
    {name: 'tx_denominacion_act'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ActividadLista.main.init, ActividadLista.main);
</script>
<div id="contenedorActividadLista"></div>
<div id="formularioActividad"></div>
<div id="filtroActividad"></div>
