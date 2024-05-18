<script type="text/javascript">
Ext.ns("CargoLista");
CargoLista.main = {
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
        CargoLista.main.mascara.show();
        this.msg = Ext.get('formularioCargo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cargo/editar',
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
	this.codigo  = CargoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_cargo');
	CargoLista.main.mascara.show();
        this.msg = Ext.get('formularioCargo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cargo/editar/codigo/'+this.codigo,
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
	this.codigo  = CargoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_cargo');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cargo/eliminar',
            params:{
                co_cargo:CargoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_cargo')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    CargoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                CargoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroCargo');
        CargoLista.main.mascara.show();
        CargoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cargo/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Cargos',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_cargo',hidden:true, menuDisabled:true,dataIndex: 'co_cargo'},
    {header: 'Cargo', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'tx_cargo'},
    //{header: 'In activo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_activo'},
    //{header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    //{header: 'Updated at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'updated_at'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){CargoLista.main.editar.enable();CargoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorCargoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cargo/storelista',
    root:'data',
    fields:[
    {name: 'co_cargo'},
    {name: 'tx_cargo'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
           ]
    });
    return this.store;
}
};
Ext.onReady(CargoLista.main.init, CargoLista.main);
</script>
<div id="contenedorCargoLista"></div>
<div id="formularioCargo"></div>
<div id="filtroCargo"></div>
