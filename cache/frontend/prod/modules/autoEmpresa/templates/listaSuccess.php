<script type="text/javascript">
Ext.ns("EmpresaLista");
EmpresaLista.main = {
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
        EmpresaLista.main.mascara.show();
        this.msg = Ext.get('formularioEmpresa');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empresa/editar',
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
	this.codigo  = EmpresaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_empresa');
	EmpresaLista.main.mascara.show();
        this.msg = Ext.get('formularioEmpresa');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empresa/editar/codigo/'+this.codigo,
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
	this.codigo  = EmpresaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_empresa');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empresa/eliminar',
            params:{
                co_empresa:EmpresaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_empresa')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    EmpresaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                EmpresaLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroEmpresa');
        EmpresaLista.main.mascara.show();
        EmpresaLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empresa/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Empresa',
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
    {header: 'co_empresa',hidden:true, menuDisabled:true,dataIndex: 'co_empresa'},
    {header: 'Nb empresa', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nb_empresa'},
    {header: 'Co estado', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_estado'},
    {header: 'Co municipio', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_municipio'},
    {header: 'Tx rif', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_rif'},
    {header: 'Tx nit', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_nit'},
    {header: 'Tx direccion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_direccion'},
    {header: 'Tx imagen der', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_imagen_der'},
    {header: 'Tx imagen izq', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_imagen_izq'},
    {header: 'Tx imagen cen', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_imagen_cen'},
    {header: 'Nu telefono', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_telefono'},
    {header: 'Tx sigla', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_sigla'},
    {header: 'Op imagen', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'op_imagen'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){EmpresaLista.main.editar.enable();EmpresaLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorEmpresaLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empresa/storelista',
    root:'data',
    fields:[
    {name: 'co_empresa'},
    {name: 'nb_empresa'},
    {name: 'co_estado'},
    {name: 'co_municipio'},
    {name: 'tx_rif'},
    {name: 'tx_nit'},
    {name: 'tx_direccion'},
    {name: 'tx_imagen_der'},
    {name: 'tx_imagen_izq'},
    {name: 'tx_imagen_cen'},
    {name: 'nu_telefono'},
    {name: 'tx_sigla'},
    {name: 'op_imagen'},
           ]
    });
    return this.store;
}
};
Ext.onReady(EmpresaLista.main.init, EmpresaLista.main);
</script>
<div id="contenedorEmpresaLista"></div>
<div id="formularioEmpresa"></div>
<div id="filtroEmpresa"></div>
