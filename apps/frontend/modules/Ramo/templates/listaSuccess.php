<script type="text/javascript">
Ext.ns("RamoLista");
RamoLista.main = {
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
        RamoLista.main.mascara.show();
        this.msg = Ext.get('formularioRamo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Ramo/editar',
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
	this.codigo  = RamoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_ramo');
	RamoLista.main.mascara.show();
        this.msg = Ext.get('formularioRamo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Ramo/editar/codigo/'+this.codigo,
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
	this.codigo  = RamoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_ramo');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Ramo/eliminar',
            params:{
                co_ramo:RamoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_ramo')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    RamoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                RamoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroRamo');
        RamoLista.main.mascara.show();
        RamoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Ramo/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Ramos',
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
    {header: 'co_ramo',hidden:true, menuDisabled:true,dataIndex: 'co_ramo'},
    {header: 'Ramo', width:250,  menuDisabled:true, sortable: true,  dataIndex: 'tx_ramo'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){RamoLista.main.editar.enable();RamoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorRamoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Ramo/storelista',
    root:'data',
    fields:[
    {name: 'co_ramo'},
    {name: 'tx_ramo'},
           ]
    });
    return this.store;
}
};
Ext.onReady(RamoLista.main.init, RamoLista.main);
</script>
<div id="contenedorRamoLista"></div>
<div id="formularioRamo"></div>
<div id="filtroRamo"></div>
