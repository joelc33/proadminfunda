<script type="text/javascript">
Ext.ns("EstructuraOrganizativaLista");
EstructuraOrganizativaLista.main = {
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
        EstructuraOrganizativaLista.main.mascara.show();
        this.msg = Ext.get('formularioEstructuraOrganizativa');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/editar',
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
	this.codigo  = EstructuraOrganizativaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_estructura_administrativa');
	EstructuraOrganizativaLista.main.mascara.show();
        this.msg = Ext.get('formularioEstructuraOrganizativa');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/editar/codigo/'+this.codigo,
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
	this.codigo  = EstructuraOrganizativaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_estructura_administrativa');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/eliminar',
            params:{
                co_estructura_administrativa:EstructuraOrganizativaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_estructura_administrativa')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    EstructuraOrganizativaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                EstructuraOrganizativaLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroEstructuraOrganizativa');
        EstructuraOrganizativaLista.main.mascara.show();
        EstructuraOrganizativaLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de EstructuraOrganizativa',
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
    {header: 'co_estructura_administrativa',hidden:true, menuDisabled:true,dataIndex: 'co_estructura_administrativa'},
    {header: 'Co padre', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_padre'},
    {header: 'Tx nom estructura administrativa', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_nom_estructura_administrativa'},
    {header: 'Nu centro costo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_centro_costo'},
    {header: 'Co ente', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_ente'},
    {header: 'Co nivel jerarquico', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_nivel_jerarquico'},
    {header: 'In activo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_activo'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    {header: 'Updated at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'updated_at'},
    {header: 'Co dependencia', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_dependencia'},
    {header: 'Co enteorgano', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_enteorgano'},
    {header: 'Nu codigo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_codigo'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){EstructuraOrganizativaLista.main.editar.enable();EstructuraOrganizativaLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorEstructuraOrganizativaLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/storelista',
    root:'data',
    fields:[
    {name: 'co_estructura_administrativa'},
    {name: 'co_padre'},
    {name: 'tx_nom_estructura_administrativa'},
    {name: 'nu_centro_costo'},
    {name: 'co_ente'},
    {name: 'co_nivel_jerarquico'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'co_dependencia'},
    {name: 'co_enteorgano'},
    {name: 'nu_codigo'},
           ]
    });
    return this.store;
}
};
Ext.onReady(EstructuraOrganizativaLista.main.init, EstructuraOrganizativaLista.main);
</script>
<div id="contenedorEstructuraOrganizativaLista"></div>
<div id="formularioEstructuraOrganizativa"></div>
<div id="filtroEstructuraOrganizativa"></div>
