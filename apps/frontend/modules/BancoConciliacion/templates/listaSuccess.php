<script type="text/javascript">
Ext.ns("BancoConciliacionLista");
BancoConciliacionLista.main = {
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
        BancoConciliacionLista.main.mascara.show();
        this.msg = Ext.get('formularioBancoConciliacion');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoConciliacion/editar',
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
	this.codigo  = BancoConciliacionLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	BancoConciliacionLista.main.mascara.show();
        this.msg = Ext.get('formularioBancoConciliacion');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoConciliacion/editar/codigo/'+this.codigo,
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
	this.codigo  = BancoConciliacionLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoConciliacion/eliminar',
            params:{
                id:BancoConciliacionLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    BancoConciliacionLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                BancoConciliacionLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroBancoConciliacion');
        BancoConciliacionLista.main.mascara.show();
        BancoConciliacionLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoConciliacion/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de BancoConciliacion',
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
    {header: 'Fe movimiento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_movimiento'},
    {header: 'De concepto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'de_concepto'},
    {header: 'Mo cargo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_cargo'},
    {header: 'Mo abono', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_abono'},
    {header: 'Mo saldo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_saldo'},
    {header: 'Id tb101 tipo concilacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb101_tipo_concilacion'},
    {header: 'In activo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_activo'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    {header: 'Updated at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'updated_at'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){BancoConciliacionLista.main.editar.enable();BancoConciliacionLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorBancoConciliacionLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoConciliacion/storelista',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'id_tb010_banco'},
    {name: 'id_tb011_cuenta_bancaria'},
    {name: 'fe_movimiento'},
    {name: 'de_concepto'},
    {name: 'mo_cargo'},
    {name: 'mo_abono'},
    {name: 'mo_saldo'},
    {name: 'id_tb101_tipo_concilacion'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
           ]
    });
    return this.store;
}
};
Ext.onReady(BancoConciliacionLista.main.init, BancoConciliacionLista.main);
</script>
<div id="contenedorBancoConciliacionLista"></div>
<div id="formularioBancoConciliacion"></div>
<div id="filtroBancoConciliacion"></div>
