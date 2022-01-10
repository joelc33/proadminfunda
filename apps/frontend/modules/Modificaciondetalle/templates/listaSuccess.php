<script type="text/javascript">
Ext.ns("ModificaciondetalleLista");
ModificaciondetalleLista.main = {
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
        ModificaciondetalleLista.main.mascara.show();
        this.msg = Ext.get('formularioModificaciondetalle');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modificaciondetalle/editar',
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
	this.codigo  = ModificaciondetalleLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	ModificaciondetalleLista.main.mascara.show();
        this.msg = Ext.get('formularioModificaciondetalle');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modificaciondetalle/editar/codigo/'+this.codigo,
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
	this.codigo  = ModificaciondetalleLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modificaciondetalle/eliminar',
            params:{
                id:ModificaciondetalleLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ModificaciondetalleLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ModificaciondetalleLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroModificaciondetalle');
        ModificaciondetalleLista.main.mascara.show();
        ModificaciondetalleLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modificaciondetalle/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Modificaciondetalle',
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
    {header: 'Id tb096 presupuesto modificacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb096_presupuesto_modificacion'},
    {header: 'Id tb013 anio fiscal', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb013_anio_fiscal'},
    {header: 'Id tb084 accion especifica', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb084_accion_especifica'},
    {header: 'Id tb085 presupuesto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb085_presupuesto'},
    {header: 'Nu partida', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_partida'},
    {header: 'Id tb098 tipo distribucion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb098_tipo_distribucion'},
    {header: 'Mo distribucion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_distribucion'},
    {header: 'In activo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_activo'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    {header: 'Updated at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'updated_at'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ModificaciondetalleLista.main.editar.enable();ModificaciondetalleLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorModificaciondetalleLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modificaciondetalle/storelista',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'id_tb096_presupuesto_modificacion'},
    {name: 'id_tb013_anio_fiscal'},
    {name: 'id_tb084_accion_especifica'},
    {name: 'id_tb085_presupuesto'},
    {name: 'nu_partida'},
    {name: 'id_tb098_tipo_distribucion'},
    {name: 'mo_distribucion'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ModificaciondetalleLista.main.init, ModificaciondetalleLista.main);
</script>
<div id="contenedorModificaciondetalleLista"></div>
<div id="formularioModificaciondetalle"></div>
<div id="filtroModificaciondetalle"></div>
