<script type="text/javascript">
Ext.ns("BancoLista");
BancoLista.main = {
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
        BancoLista.main.mascara.show();
        this.msg = Ext.get('formularioBanco');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Banco/editar',
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
	this.codigo  = BancoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_banco');
	BancoLista.main.mascara.show();
        this.msg = Ext.get('formularioBanco');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Banco/editar/codigo/'+this.codigo,
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
	this.codigo  = BancoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_banco');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Banco/eliminar',
            params:{
                co_banco:BancoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_banco')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    BancoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                BancoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroBanco');
        BancoLista.main.mascara.show();
        BancoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Banco/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Banco',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.eliminar
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_banco',hidden:true, menuDisabled:true,dataIndex: 'co_banco'},
    {header: 'Banco', width:400,  menuDisabled:true, sortable: true,  dataIndex: 'tx_banco'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){BancoLista.main.editar.enable();BancoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorBancoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Banco/storelista',
    root:'data',
    fields:[
    {name: 'co_banco'},
    {name: 'tx_banco'},
           ]
    });
    return this.store;
}
};
Ext.onReady(BancoLista.main.init, BancoLista.main);
</script>
<div id="contenedorBancoLista"></div>
<div id="formularioBanco"></div>
<div id="filtroBanco"></div>
