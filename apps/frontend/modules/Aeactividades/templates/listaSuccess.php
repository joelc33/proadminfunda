<script type="text/javascript">
Ext.ns("AeactividadesLista");
AeactividadesLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        AeactividadesLista.main.mascara.show();
        this.msg = Ext.get('formularioAeactividades');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Aeactividades/editar',
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
	this.codigo  = AeactividadesLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	AeactividadesLista.main.mascara.show();
        this.msg = Ext.get('formularioAeactividades');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Aeactividades/editar/codigo/'+this.codigo,
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
	this.codigo  = AeactividadesLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Aeactividades/eliminar',
            params:{
                id:AeactividadesLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    AeactividadesLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                AeactividadesLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroAeactividades');
        AeactividadesLista.main.mascara.show();
        AeactividadesLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Aeactividades/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    //title:'Lista de Aeactividades',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:520,
    border:false,
    tbar:[
        this.filtro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},
    {header: 'Codigo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_actividad'},
    {header: 'Descripcion', width:500,  menuDisabled:true, sortable: true,  dataIndex: 'de_actividad'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){AeactividadesLista.main.editar.enable();AeactividadesLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

//this.gridPanel_.render("contenedorAeactividadesLista");

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Actividades',
    modal:true,
    constrain:true,
width:680,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.gridPanel_
    ]
});
this.winformPanel_.show();
AccionespecificaLista.main.mascara.hide();

AeactividadesLista.main.store_lista.baseParams.codigo=AeactividadesLista.main.OBJ.codigo;

this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Aeactividades/storelista',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'id_tb084_accion_especifica'},
    {name: 'nu_actividad'},
    {name: 'de_actividad'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
           ]
    });
    return this.store;
}
};
Ext.onReady(AeactividadesLista.main.init, AeactividadesLista.main);
</script>
<div id="contenedorAeactividadesLista"></div>
<div id="formularioAeactividades"></div>
<div id="filtroAeactividades"></div>
