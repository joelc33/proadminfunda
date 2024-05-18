<script type="text/javascript">
Ext.ns("CuentaBancariaLista");
CuentaBancariaLista.main = {
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
        CuentaBancariaLista.main.mascara.show();
        this.msg = Ext.get('formularioCuentaBancaria');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/editar',
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
	this.codigo  = CuentaBancariaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_cuenta_bancaria');
	CuentaBancariaLista.main.mascara.show();
        this.msg = Ext.get('formularioCuentaBancaria');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/editar/codigo/'+this.codigo,
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
	this.codigo  = CuentaBancariaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_cuenta_bancaria');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/eliminar',
            params:{
                co_cuenta_bancaria:CuentaBancariaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_cuenta_bancaria')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    CuentaBancariaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                CuentaBancariaLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroCuentaBancaria');
        CuentaBancariaLista.main.mascara.show();
        CuentaBancariaLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Cuentas Bancarias',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.eliminar //,'-',this.filtro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_cuenta_bancaria',hidden:true, menuDisabled:true,dataIndex: 'co_cuenta_bancaria'},
    {header: 'Banco', width:250,  menuDisabled:true, sortable: true,  dataIndex: 'co_banco'},
    {header: 'N° de Cuenta', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'tx_cuenta_bancaria'},
    {header: 'Tipo de Cuenta', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_tipo_cuenta'},
    {header: 'Descripción', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tx_descripcion_cuenta'},
    {header: 'Cuenta Contable', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tx_cuenta'},
    {header: 'Nº Contrato', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'nu_contrato'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
        CuentaBancariaLista.main.editar.enable();
        CuentaBancariaLista.main.eliminar.enable();
    
        var msg = Ext.get('detalle');
        msg.load({
                url: '<?php echo $_SERVER['SCRIPT_NAME']?>/CuentaBancaria/chequera',
                scripts: true,
                params:
                {
                    co_cuenta_bancaria: CuentaBancariaLista.main.store_lista.getAt(rowIndex).get('co_cuenta_bancaria')

                },
                text: 'Cargando...'
        });
        
    
        if(panel_detalle.collapsed == true)
        {
            panel_detalle.toggleCollapse();
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

this.gridPanel_.render("contenedorCuentaBancariaLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/storelista',
    root:'data',
    fields:[
            {name: 'co_cuenta_bancaria'},
            {name: 'tx_cuenta_bancaria'},
            {name: 'co_banco'},
            {name: 'co_tipo_cuenta'},
            {name: 'tx_descripcion_cuenta'},
            {name: 'tx_cuenta'},
            {name: 'nu_contrato'}
    
           ]
    });
    return this.store;
}
};
Ext.onReady(CuentaBancariaLista.main.init, CuentaBancariaLista.main);
</script>
<div id="contenedorCuentaBancariaLista"></div>
<div id="formularioCuentaBancaria"></div>
<div id="filtroCuentaBancaria"></div>
