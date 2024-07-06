<script type="text/javascript">
Ext.ns("CrearPartidaLista");
CrearPartidaLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
}, 
init:function(){
//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});
this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//objeto store
this.store_lista = this.getLista();

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        CrearPartidaLista.main.mascara.show();
        this.msg = Ext.get('formularioCrearPartida');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/editar',
         scripts: true,
         text: "Cargando..",
         params:{
             co_solicitud: CrearPartidaLista.main.OBJ.co_solicitud
         }
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = CrearPartidaLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	CrearPartidaLista.main.mascara.show();
        this.msg = Ext.get('formularioCrearPartida');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/editar/codigo/'+this.codigo,
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
	this.codigo  = CrearPartidaLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/eliminar',
            params:{
                id:CrearPartidaLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    CrearPartidaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                CrearPartidaLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroCrearPartida');
        CrearPartidaLista.main.mascara.show();
        CrearPartidaLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

function renderMonto(val, attr, record) { 
     return paqueteComunJS.funcion.getNumeroFormateado(val);     
} 

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Partidas',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
    width:1070,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.eliminar
    ],
    columns: [
    new Ext.grid.RowNumberer(),
        {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},
        {header: 'Nro. Partida', width:250,  menuDisabled:true, sortable: true,  dataIndex: 'co_categoria'},
        {header: 'Descripción', width:550,  menuDisabled:true, sortable: true,  dataIndex: 'de_partida',renderer:textoLargo},
        {header: 'Monto', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'mo_inicial',renderer:renderMonto},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){CrearPartidaLista.main.editar.enable();CrearPartidaLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});


this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        CrearPartidaLista.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:1100,
    autoHeight:true,  
    autoScroll:true,
    //bodyStyle:'padding:10px;',
    items:[this.gridPanel_]
});

this.winformPanel_ = new Ext.Window({
    title:'Crear Partida',
    modal:true,
    constrain:true,
    width:1100,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.formPanel_
    ],
    buttons:[
      //  this.guardar,
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();

this.store_lista.baseParams.co_solicitud = this.OBJ.co_solicitud;
this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storelista',
    root:'data',
    fields:[
            {name: 'id'},
            {name: 'nu_partida'},
            {name: 'de_partida'},
            {name: 'co_categoria'},
            {name: 'mo_inicial'}
           ]
    });
    return this.store;
}
};
Ext.onReady(CrearPartidaLista.main.init, CrearPartidaLista.main);
</script>
<div id="contenedorCrearPartidaLista"></div>
<div id="formularioCrearPartida"></div>
<div id="filtroCrearPartida"></div>
