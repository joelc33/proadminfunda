<script type="text/javascript">
Ext.ns("CatalogoPartidaLista");
CatalogoPartidaLista.main = {
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
        CatalogoPartidaLista.main.mascara.show();
        this.msg = Ext.get('formularioCatalogoPartida');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CatalogoPartida/editar',
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
	this.codigo  = CatalogoPartidaLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	CatalogoPartidaLista.main.mascara.show();
        this.msg = Ext.get('formularioCatalogoPartida');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CatalogoPartida/editar/codigo/'+this.codigo,
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
	this.codigo  = CatalogoPartidaLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CatalogoPartida/eliminar',
            params:{
                id:CatalogoPartidaLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    CatalogoPartidaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                CatalogoPartidaLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroCatalogoPartida');
        CatalogoPartidaLista.main.mascara.show();
        CatalogoPartidaLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/CatalogoPartida/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de CatalogoPartida',
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
    {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},
    {header: 'Co partida', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_partida'},
    {header: 'Nu partida', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_partida'},
    {header: 'De partida', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'de_partida'},
    {header: 'Id tb013 anio fiscal', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb013_anio_fiscal'},
    {header: 'In movimiento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_movimiento'},
    {header: 'Nu nivel', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_nivel'},
    {header: 'Nu pa', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_pa'},
    {header: 'Nu ge', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_ge'},
    {header: 'Nu es', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_es'},
    {header: 'Nu se', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_se'},
    {header: 'Nu sse', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_sse'},
    {header: 'In activo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_activo'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    {header: 'Updated at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'updated_at'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){CatalogoPartidaLista.main.editar.enable();CatalogoPartidaLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorCatalogoPartidaLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CatalogoPartida/storelista',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'co_partida'},
    {name: 'nu_partida'},
    {name: 'de_partida'},
    {name: 'id_tb013_anio_fiscal'},
    {name: 'in_movimiento'},
    {name: 'nu_nivel'},
    {name: 'nu_pa'},
    {name: 'nu_ge'},
    {name: 'nu_es'},
    {name: 'nu_se'},
    {name: 'nu_sse'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
           ]
    });
    return this.store;
}
};
Ext.onReady(CatalogoPartidaLista.main.init, CatalogoPartidaLista.main);
</script>
<div id="contenedorCatalogoPartidaLista"></div>
<div id="formularioCatalogoPartida"></div>
<div id="filtroCatalogoPartida"></div>
