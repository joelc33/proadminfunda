<script type="text/javascript">
Ext.ns("CuentaContable");
CuentaContable.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.store_lista = this.getLista();

this.datos  = '<p class="registro_detalle"><b>Partida: </b>'+this.OBJ.co_partida+'</p>';
this.datos += '<p class="registro_detalle"><b>Detalle: </b>'+this.OBJ.de_partida+'</p>';

this.fieldDatos= new Ext.form.FieldSet({
        title: 'Datos de la Partida Presupuestaria',
        html: this.datos
});

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Crear Cuenta',
    iconCls: 'icon-nuevo',
    handler:function(){
        PlandecuentaLista.main.mascara.show();
        this.msg = Ext.get('formularioPlandecuenta');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaContable/editar',
         scripts: true,
         text: "Cargando.."
        });
    }
});

this.secundaria = new Ext.Button({
    text:'Ver Cuentas Asociadas',
    iconCls: 'icon-nuevo',
    handler:function(){
        this.msg = Ext.get('formulario');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaContable/verCuentaPresupuesto',
         scripts: true,
         text: "Cargando..",
         params:{
             nu_cuenta_contable:CuentaContable.main.gridPanel_.getSelectionModel().getSelected().get('nu_cuenta_contable'),
             tx_cuenta:CuentaContable.main.gridPanel_.getSelectionModel().getSelected().get('tx_cuenta'),
             nivel: CuentaContable.main.gridPanel_.getSelectionModel().getSelected().get('nu_nivel'),
             co_cuenta_contable: CuentaContable.main.gridPanel_.getSelectionModel().getSelected().get('co_cuenta_contable')             
         }
        });
    }
});


//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Planes de Cuenta',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:420,
    tbar:[
        this.nuevo,'-',this.secundaria
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_cuenta_contable',hidden:true, menuDisabled:true,dataIndex: 'co_cuenta_contable'},
    {header: 'Cuenta', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cuenta_contable'},
    {header: 'Denominación', width:700,  menuDisabled:true, sortable: true,  dataIndex: 'tx_descripcion'},
    {header: 'Nivel', width:60,  menuDisabled:true, sortable: true,  dataIndex: 'nu_nivel'},
    {header: 'Tipo', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tipo'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
        
//        var co_tipo = PlandecuentaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_tipo');
//        
//        if(co_tipo == 4){
//             PlandecuentaLista.main.secundaria.disable();
//        }else{
//             PlandecuentaLista.main.secundaria.enable();
//        }
//            
//        PlandecuentaLista.main.editar.enable();       
//        PlandecuentaLista.main.eliminar.enable();
    },
    celldblclick:function(Grid, rowIndex, columnIndex,e ){
        this.msg = Ext.get('formulario');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaContable/verCuentaPresupuesto',
         scripts: true,
         text: "Cargando..",
         params:{
             nu_cuenta_contable:CuentaContable.main.gridPanel_.getSelectionModel().getSelected().get('nu_cuenta_contable'),
             tx_cuenta:CuentaContable.main.gridPanel_.getSelectionModel().getSelected().get('tx_cuenta'),
             nivel: CuentaContable.main.gridPanel_.getSelectionModel().getSelected().get('nu_nivel'),
             co_cuenta_contable: CuentaContable.main.gridPanel_.getSelectionModel().getSelected().get('co_cuenta_contable'),
             
         }
        });
    }},
    bbar: new Ext.PagingToolbar({
        pageSize: 15,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.store_lista.load();

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        CuentaContable.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:1100,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.fieldDatos,
           this.gridPanel_]
});

this.winformPanel_ = new Ext.Window({
    title:'Asignación de Cuenta Contable',
    modal:true,
    constrain:true,
    width:1100,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.formPanel_
    ],
    buttons:[
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
//CuentaBancariaLista.main.mascara.hide();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaContable/storelista',
    root:'data',
    fields:[
            {name: 'co_cuenta_contable'},
            {name: 'tx_cuenta'},
            {name: 'tx_descripcion'},
            {name: 'nu_nivel'},
            {name: 'tx_tipo'},
            {name: 'nu_cuenta_contable'}
           ]
    });
    return this.store;
}
};
Ext.onReady(CuentaContable.main.init, CuentaContable.main);
</script>
<div id="formulario"></div>