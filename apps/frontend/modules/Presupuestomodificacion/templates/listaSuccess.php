<script type="text/javascript">
Ext.ns("PresupuestomodificacionLista");
PresupuestomodificacionLista.main = {
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
        PresupuestomodificacionLista.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestomodificacion');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/editar',
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
	this.codigo  = PresupuestomodificacionLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	PresupuestomodificacionLista.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestomodificacion');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/editar/codigo/'+this.codigo,
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
	this.codigo  = PresupuestomodificacionLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/eliminar',
            params:{
                id:PresupuestomodificacionLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    PresupuestomodificacionLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                PresupuestomodificacionLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroPresupuestomodificacion');
        PresupuestomodificacionLista.main.mascara.show();
        PresupuestomodificacionLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Presupuestomodificacion',
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
    {header: 'Id tb095 tipo modificacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb095_tipo_modificacion'},
    {header: 'Nu modificacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_modificacion'},
    {header: 'Fe modificacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_modificacion'},
    {header: 'De modificacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'de_modificacion'},
    {header: 'De justificacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'de_justificacion'},
    {header: 'Nu oficio', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_oficio'},
    {header: 'Fe oficio', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_oficio'},
    {header: 'De articulo ley', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'de_articulo_ley'},
    {header: 'Mo modificacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_modificacion'},
    {header: 'In activo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_activo'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    {header: 'Updated at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'updated_at'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){PresupuestomodificacionLista.main.editar.enable();PresupuestomodificacionLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorPresupuestomodificacionLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/storelista',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'id_tb095_tipo_modificacion'},
    {name: 'nu_modificacion'},
    {name: 'fe_modificacion'},
    {name: 'de_modificacion'},
    {name: 'de_justificacion'},
    {name: 'nu_oficio'},
    {name: 'fe_oficio'},
    {name: 'de_articulo_ley'},
    {name: 'mo_modificacion'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
           ]
    });
    return this.store;
}
};
Ext.onReady(PresupuestomodificacionLista.main.init, PresupuestomodificacionLista.main);
</script>
<div id="contenedorPresupuestomodificacionLista"></div>
<div id="formularioPresupuestomodificacion"></div>
<div id="filtroPresupuestomodificacion"></div>
