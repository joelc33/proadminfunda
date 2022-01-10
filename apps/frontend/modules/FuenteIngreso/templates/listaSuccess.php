<script type="text/javascript">
Ext.ns("FuenteIngresoLista");
FuenteIngresoLista.main = {
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
        FuenteIngresoLista.main.mascara.show();
        this.msg = Ext.get('formularioFuenteIngreso');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FuenteIngreso/editar',
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
	this.codigo  = FuenteIngresoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_fuente_ingreso');
	FuenteIngresoLista.main.mascara.show();
        this.msg = Ext.get('formularioFuenteIngreso');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FuenteIngreso/editar/codigo/'+this.codigo,
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
	this.codigo  = FuenteIngresoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_fuente_ingreso');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FuenteIngreso/eliminar',
            params:{
                co_fuente_ingreso:FuenteIngresoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_fuente_ingreso')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    FuenteIngresoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                FuenteIngresoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroFuenteIngreso');
        FuenteIngresoLista.main.mascara.show();
        FuenteIngresoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/FuenteIngreso/filtro',
             scripts: true
        });
    }
});

this.asignar_cuenta= new Ext.Button({
    text:'Asignar Cuenta Contable',
    iconCls: 'icon-add',
    handler:function(){
	this.msg = Ext.get('formularioFuenteIngreso');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaContable/fuenteIngreso',
         params:{
             id:FuenteIngresoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_fuente_ingreso'),
             tx_fuente_ingreso:FuenteIngresoLista.main.gridPanel_.getSelectionModel().getSelected().get('tx_fuente_ingreso')
         },
         scripts: true,
         text: "Cargando.."
        });
    }
});

this.editar.disable();
this.eliminar.disable();
this.asignar_cuenta.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Fuente Ingreso',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.asignar_cuenta
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_fuente_ingreso',hidden:true, menuDisabled:true,dataIndex: 'co_fuente_ingreso'},
    {header: 'Descripción', width:500,  menuDisabled:true, sortable: true,  dataIndex: 'tx_fuente_ingreso'},
    {header: 'Cuenta Contable', width:250,  menuDisabled:true, sortable: true,  dataIndex: 'tx_cuenta'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
        FuenteIngresoLista.main.editar.enable();
        FuenteIngresoLista.main.eliminar.enable();
        FuenteIngresoLista.main.asignar_cuenta.enable();        
    }},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorFuenteIngresoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FuenteIngreso/storelista',
    root:'data',
    fields:[
                {name: 'co_fuente_ingreso'},
                {name: 'tx_fuente_ingreso'},
                {name: 'tx_cuenta'}
           ]
    });
    return this.store;
}
};
Ext.onReady(FuenteIngresoLista.main.init, FuenteIngresoLista.main);
</script>
<div id="contenedorFuenteIngresoLista"></div>
<div id="formularioFuenteIngreso"></div>
<div id="filtroFuenteIngreso"></div>
