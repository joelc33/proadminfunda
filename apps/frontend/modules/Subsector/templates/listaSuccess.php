<script type="text/javascript">
Ext.ns("SubsectorLista");
SubsectorLista.main = {
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
        SubsectorLista.main.mascara.show();
        this.msg = Ext.get('formularioSubsector');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Subsector/editar',
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
	this.codigo  = SubsectorLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	SubsectorLista.main.mascara.show();
        this.msg = Ext.get('formularioSubsector');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Subsector/editar/codigo/'+this.codigo,
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
	this.codigo  = SubsectorLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Subsector/eliminar',
            params:{
                id:SubsectorLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    SubsectorLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                SubsectorLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroSubsector');
        SubsectorLista.main.mascara.show();
        SubsectorLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Subsector/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Subsector',
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
    {header: 'Sector', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_sector'},
    {header: 'Codigo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_sub_sector'},
    {header: 'Sub Sector', width:400,  menuDisabled:true, sortable: true,  dataIndex: 'de_sub_sector'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){SubsectorLista.main.editar.enable();SubsectorLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorSubsectorLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Subsector/storelista',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'nu_sector'},
    {name: 'nu_sub_sector'},
    {name: 'de_sub_sector'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
           ]
    });
    return this.store;
}
};
Ext.onReady(SubsectorLista.main.init, SubsectorLista.main);
</script>
<div id="contenedorSubsectorLista"></div>
<div id="formularioSubsector"></div>
<div id="filtroSubsector"></div>
