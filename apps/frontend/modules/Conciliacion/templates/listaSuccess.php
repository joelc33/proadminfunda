<script type="text/javascript">
Ext.ns("ConciliacionLista");
ConciliacionLista.main = {
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
        ConciliacionLista.main.mascara.show();
        this.msg = Ext.get('formularioConciliacion');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Conciliacion/editar',
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
	this.codigo  = ConciliacionLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	ConciliacionLista.main.mascara.show();
        this.msg = Ext.get('formularioConciliacion');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Conciliacion/editar/codigo/'+this.codigo,
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
	this.codigo  = ConciliacionLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Conciliacion/eliminar',
            params:{
                id:ConciliacionLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ConciliacionLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ConciliacionLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroConciliacion');
        ConciliacionLista.main.mascara.show();
        ConciliacionLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Conciliacion/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Conciliacion',
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
    {header: 'Id tb010 banco', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb010_banco'},
    {header: 'Id tb011 cuenta bancaria', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb011_cuenta_bancaria'},
    {header: 'Fe desde', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_desde'},
    {header: 'Fe hasta', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_hasta'},
    {header: 'Co usuario', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_usuario'},
    {header: 'Co solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud'},
    {header: 'Co tipo solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_tipo_solicitud'},
    {header: 'In activo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_activo'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    {header: 'Updated at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'updated_at'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ConciliacionLista.main.editar.enable();ConciliacionLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorConciliacionLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Conciliacion/storelista',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'id_tb010_banco'},
    {name: 'id_tb011_cuenta_bancaria'},
    {name: 'fe_desde'},
    {name: 'fe_hasta'},
    {name: 'co_usuario'},
    {name: 'co_solicitud'},
    {name: 'co_tipo_solicitud'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ConciliacionLista.main.init, ConciliacionLista.main);
</script>
<div id="contenedorConciliacionLista"></div>
<div id="formularioConciliacion"></div>
<div id="filtroConciliacion"></div>
