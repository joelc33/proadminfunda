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

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        ActividadLista.main.mascara.show();
        this.msg = Ext.get('formularioActividad');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Actividad/editar',
         scripts: true,
         text: "Cargando..",
         params:{
             co_programa:ActividadLista.main.OBJ.co_programa
         }
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = ActividadLista.main.gridPanel_.getSelectionModel().getSelected().get('co_actividad');
	ActividadLista.main.mascara.show();
        this.msg = Ext.get('formularioActividad');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Actividad/editar/codigo/'+this.codigo,
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
	this.codigo  = ActividadLista.main.gridPanel_.getSelectionModel().getSelected().get('co_actividad');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Actividad/eliminar',
            params:{
                co_actividad:ActividadLista.main.gridPanel_.getSelectionModel().getSelected().get('co_actividad')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ActividadLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ActividadLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroActividad');
        ActividadLista.main.mascara.show();
        ActividadLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Actividad/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Actividad',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:350,
    tbar:[
        this.nuevo,'-',this.editar
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
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ActividadLista.main.editar.enable();ActividadLista.main.eliminar.enable();}},
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
