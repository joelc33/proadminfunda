<script type="text/javascript">
Ext.ns("FondoAvanceLista");
FondoAvanceLista.main = {
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
        FondoAvanceLista.main.mascara.show();
        this.msg = Ext.get('formularioFondoAvance');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoAvance/editar',
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
	this.codigo  = FondoAvanceLista.main.gridPanel_.getSelectionModel().getSelected().get('co_compromiso_asignacion');
	FondoAvanceLista.main.mascara.show();
        this.msg = Ext.get('formularioFondoAvance');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoAvance/editar/codigo/'+this.codigo,
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
	this.codigo  = FondoAvanceLista.main.gridPanel_.getSelectionModel().getSelected().get('co_compromiso_asignacion');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoAvance/eliminar',
            params:{
                co_compromiso_asignacion:FondoAvanceLista.main.gridPanel_.getSelectionModel().getSelected().get('co_compromiso_asignacion')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    FondoAvanceLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                FondoAvanceLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroFondoAvance');
        FondoAvanceLista.main.mascara.show();
        FondoAvanceLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoAvance/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de FondoAvance',
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
    {header: 'co_compromiso_asignacion',hidden:true, menuDisabled:true,dataIndex: 'co_compromiso_asignacion'},
    {header: 'Co proveedor', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_proveedor'},
    {header: 'Tx descripcion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_descripcion'},
    {header: 'Nu cancelacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cancelacion'},
    {header: 'Fe compromiso', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_compromiso'},
    {header: 'Nu monto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_monto'},
    {header: 'Co solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud'},
    {header: 'Co usuario', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_usuario'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){FondoAvanceLista.main.editar.enable();FondoAvanceLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorFondoAvanceLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoAvance/storelista',
    root:'data',
    fields:[
    {name: 'co_compromiso_asignacion'},
    {name: 'co_proveedor'},
    {name: 'tx_descripcion'},
    {name: 'nu_cancelacion'},
    {name: 'fe_compromiso'},
    {name: 'nu_monto'},
    {name: 'co_solicitud'},
    {name: 'co_usuario'},
           ]
    });
    return this.store;
}
};
Ext.onReady(FondoAvanceLista.main.init, FondoAvanceLista.main);
</script>
<div id="contenedorFondoAvanceLista"></div>
<div id="formularioFondoAvance"></div>
<div id="filtroFondoAvance"></div>
