<script type="text/javascript">
Ext.ns("ChequeEditar");
ChequeEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.store_lista = this.getLista();

this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});
//<ClavePrimaria>
this.co_chequera = new Ext.form.Hidden({
    name:'co_chequera',
    value:this.OBJ.co_chequera});

this.estado = new Ext.Button({
    text:'Cambiar Estado',
    iconCls: 'icon-cambio',
    handler:function(){
        this.codigo  = ChequeEditar.main.gridPanel_.getSelectionModel().getSelected().get('co_cheque');
        ChequeEditar.main.mascara.show();
        this.msg = Ext.get('formularioCheque');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/estadocheque',
         scripts: true,
         text: "Cargando..",
         params:{
             co_cheque: this.codigo
         }
        });
    }
});
this.estado.disable();

this.editar = new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
        this.codigo  = ChequeEditar.main.gridPanel_.getSelectionModel().getSelected().get('co_cheque');
        ChequeEditar.main.mascara.show();
        this.msg = Ext.get('formularioCheque');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/editarCheque',
         scripts: true,
         text: "Cargando..",
         params:{
             co_cheque: this.codigo
         }
        });
    }
});
this.editar.disable();

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        ChequeEditar.main.mascara.show();
        this.msg = Ext.get('formularioCheque');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/editarCheque',
         scripts: true,
         text: "Cargando..",
         params:{
            co_chequera: ChequeEditar.main.OBJ.co_chequera
         }
        });
    }
});

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Cheques',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.estado
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_cheque',hidden:true, menuDisabled:true,dataIndex: 'co_cheque'},
    {header: 'Descripción', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_descripcion'},
    {header: 'Estado', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_estado_cheque'},  
    {header: 'Observación', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tx_observacion'},  
    {header: 'Titular', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'nb_titular'},
    {header: 'Monto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_cheque'},
    {header: 'Fecha', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_pago'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
      if(ChequeEditar.main.store_lista.getAt(rowIndex).get('co_estado_cheque')==1){  
        ChequeEditar.main.estado.enable();
        ChequeEditar.main.editar.enable();
        }
      if(ChequeEditar.main.store_lista.getAt(rowIndex).get('co_estado_cheque')==2){  
        ChequeEditar.main.estado.enable();
        ChequeEditar.main.editar.enable();
        }
      if(ChequeEditar.main.store_lista.getAt(rowIndex).get('co_estado_cheque')==3){  
        ChequeEditar.main.estado.enable();
        ChequeEditar.main.editar.enable();
        }
      if(ChequeEditar.main.store_lista.getAt(rowIndex).get('co_estado_cheque')==4){  
        ChequeEditar.main.estado.enable();
        ChequeEditar.main.editar.enable();
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
this.store_lista.baseParams.co_chequera = this.OBJ.co_chequera;
this.store_lista.load();
this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ChequeEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:900,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:0px;',
    items:[

            this.co_chequera,
            this.gridPanel_        
                    
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Chequera: '+this.OBJ.tx_descripcion,
    modal:true,
    constrain:true,
    width:914,
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
ChequeraLista.main.mascara.hide();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/storelistacheque',
    root:'data',
    fields:[
            {name: 'co_chequera'},
            {name: 'co_cheque'},
            {name: 'tx_descripcion'},
            {name: 'co_estado_cheque'},
            {name: 'tx_estado_cheque'},
            {name: 'tx_observacion'},
            {name: 'nb_titular'},
            {name: 'mo_cheque'},
            {name: 'fe_pago'}
           ]
    });
    return this.store;
}
};
Ext.onReady(ChequeEditar.main.init, ChequeEditar.main);
</script>
<div id="formularioCheque"></div>
