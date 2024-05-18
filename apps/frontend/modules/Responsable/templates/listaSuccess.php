<script type="text/javascript">
Ext.ns("ResponsableLista");
ResponsableLista.main = {
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
        ResponsableLista.main.mascara.show();
        this.msg = Ext.get('formularioResponsable');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Responsable/editar',
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
	this.codigo  = ResponsableLista.main.gridPanel_.getSelectionModel().getSelected().get('co_responsables');
   
	ResponsableLista.main.mascara.show();
        this.msg = Ext.get('formularioResponsable');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Responsable/editar/codigo/'+this.codigo,
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
	this.codigo  = ResponsableLista.main.gridPanel_.getSelectionModel().getSelected().get('co_responsables');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Responsable/eliminar',
            params:{
                co_responsables:ResponsableLista.main.gridPanel_.getSelectionModel().getSelected().get('co_responsables')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ResponsableLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ResponsableLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroResponsable');
        ResponsableLista.main.mascara.show();
        ResponsableLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Responsable/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Responsables',
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
    {header: 'co_responsables',hidden:true, menuDisabled:true,dataIndex: 'co_responsables'},
    {header: 'nu_cedula', width:400,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cedula'},
    {header: 'tx_nombres', width:400,  menuDisabled:true, sortable: true,  dataIndex: 'tx_nombres'},
    {header: 'tx_apellidos', width:400,  menuDisabled:true, sortable: true,  dataIndex: 'tx_apellidos'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ResponsableLista.main.editar.enable();ResponsableLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorResponsableLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Responsable/storelista',
    root:'data',
    fields:[
    {name: 'co_responsables'},
    {name: 'nu_cedula'},
    {name: 'tx_nombres'},
    {name: 'tx_apellidos'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'}
           ]
    });
    return this.store;
}
};
Ext.onReady(ResponsableLista.main.init, ResponsableLista.main);
</script>
<div id="contenedorResponsableLista"></div>
<div id="formularioResponsable"></div>
<div id="filtroResponsable"></div>
