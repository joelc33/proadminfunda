<script type="text/javascript">
Ext.ns("ChequeraLista");
ChequeraLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
//Mascara general del modulo
this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        ChequeraLista.main.mascara.show();
        this.msg = Ext.get('formularioChequera');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/editarchequera',
         scripts: true,
         text: "Cargando..",
         params:{
             co_cuenta_bancaria: ChequeraLista.main.OBJ.co_cuenta_bancaria
         }
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = ChequeraLista.main.gridPanel_.getSelectionModel().getSelected().get('co_chequera');
	ChequeraLista.main.mascara.show();
        this.msg = Ext.get('formularioChequera');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/editarchequera/codigo/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});
this.editar.disable();

//Desabilitar un registro
this.desabilitar= new Ext.Button({
    text:'Deshabilitar',
    iconCls: 'icon-cancelar',
    handler:function(){
	this.codigo  = ChequeraLista.main.gridPanel_.getSelectionModel().getSelected().get('co_chequera');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea desabilitar esta chequera?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/deshabilitar',
            params:{
                co_chequera:ChequeraLista.main.gridPanel_.getSelectionModel().getSelected().get('co_chequera')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ChequeraLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ChequeraLista.main.editar.disable();
                ChequeraLista.main.habilitar.disable();
                ChequeraLista.main.desabilitar.disable();
                ChequeraLista.main.anular.disable();
                ChequeraLista.main.cheque.disable();
                ChequeraLista.main.mascara.hide();
            }});
	}});
    }
});
//Habilitar un registro
this.habilitar= new Ext.Button({
    text:'Habilitar',
    iconCls: 'icon-aprobar',
    handler:function(){
	this.codigo  = ChequeraLista.main.gridPanel_.getSelectionModel().getSelected().get('co_chequera');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea Habilitar esta chequera?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/habilitar',
            params:{
                co_chequera:ChequeraLista.main.gridPanel_.getSelectionModel().getSelected().get('co_chequera')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ChequeraLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ChequeraLista.main.editar.disable();
                ChequeraLista.main.habilitar.disable();
                ChequeraLista.main.desabilitar.disable();
                ChequeraLista.main.anular.disable();
                ChequeraLista.main.cheque.disable();
                ChequeraLista.main.mascara.hide();
            }});
	}});
    }
});

this.anular= new Ext.Button({
    text:'Anular',
    iconCls: 'icon-eliminar',
    handler:function(){
	this.codigo  = ChequeraLista.main.gridPanel_.getSelectionModel().getSelected().get('co_chequera');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea Anular esta chequera?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/anular',
            params:{
                co_chequera:ChequeraLista.main.gridPanel_.getSelectionModel().getSelected().get('co_chequera')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ChequeraLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ChequeraLista.main.editar.disable();
                ChequeraLista.main.habilitar.disable();
                ChequeraLista.main.desabilitar.disable();
                ChequeraLista.main.anular.disable();
                ChequeraLista.main.cheque.disable();
                ChequeraLista.main.mascara.hide();
            }});
	}});
    }
});
this.desabilitar.disable();
this.habilitar.disable();
this.anular.disable();

this.cheque = new Ext.Button({
    text:'Cheques',
    iconCls: 'icon-pagos',
    handler:function(){
        this.codigo  = ChequeraLista.main.gridPanel_.getSelectionModel().getSelected().get('co_chequera');
        ChequeraLista.main.mascara.show();
        this.msg = Ext.get('formularioChequera');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/cheque',
         scripts: true,
         text: "Cargando..",
         params:{
             co_chequera: this.codigo
         }
        });
    }
});
this.cheque.disable();
//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Chequeras',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.habilitar,'-',this.desabilitar,'-',this.anular,'-',this.cheque
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_chequera',hidden:true, menuDisabled:true,dataIndex: 'co_chequera'},
    {header: 'Descripción', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tx_descripcion'},
    {header: 'Chequera', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'chequera'},
    {header: 'Serie', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'serie'},
    {header: 'Estado', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'estado'},
    {header: 'Fecha', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'fe_chequera'},
    {header: 'Nro. Inicial', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'nro_inicial'},
    {header: 'Nro. Final', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'nro_final'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
        ChequeraLista.main.editar.enable();
        
        if(ChequeraLista.main.store_lista.getAt(rowIndex).get('co_estado_chequera')==2){  
        ChequeraLista.main.habilitar.enable();
        ChequeraLista.main.anular.enable();
        ChequeraLista.main.desabilitar.disable();
        ChequeraLista.main.cheque.disable();
        }
        if(ChequeraLista.main.store_lista.getAt(rowIndex).get('co_estado_chequera')==1){
        ChequeraLista.main.desabilitar.enable();
        ChequeraLista.main.anular.enable();
        ChequeraLista.main.cheque.enable();
        ChequeraLista.main.habilitar.disable();
        }
        if(ChequeraLista.main.store_lista.getAt(rowIndex).get('co_estado_chequera')==4){
        ChequeraLista.main.editar.disable();
        ChequeraLista.main.anular.disable();
        ChequeraLista.main.desabilitar.disable();
        ChequeraLista.main.cheque.disable();
        ChequeraLista.main.habilitar.disable();
        }
        if(ChequeraLista.main.store_lista.getAt(rowIndex).get('co_estado_chequera')==3){
        ChequeraLista.main.editar.disable();
        ChequeraLista.main.anular.disable();
        ChequeraLista.main.desabilitar.disable();
        ChequeraLista.main.cheque.disable();
        ChequeraLista.main.habilitar.disable();
        }
               
    }},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorChequeraLista");

this.store_lista.baseParams.co_cuenta_bancaria = this.OBJ.co_cuenta_bancaria;
this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/storelistachequera',
    root:'data',
    fields:[
            {name: 'co_chequera'},
            {name: 'co_cuenta_bancaria'},
            {name: 'tx_descripcion'},
            {name: 'chequera'},
            {name: 'nro_chequera'},
            {name: 'anio_chequera'},
            {name: 'serie'},
            {name: 'nro_inicial'},
            {name: 'nro_final'},
            {name: 'fe_chequera'},
            {name: 'estado'},
            {name: 'co_estado_chequera'}
           ]
    });
    return this.store;
}
};
Ext.onReady(ChequeraLista.main.init, ChequeraLista.main);
</script>
<div id="contenedorChequeraLista"></div>
<div id="formularioChequera"></div>
<div id="filtroChequera"></div>
