<script type="text/javascript">
Ext.ns("ConfigNomFuncionFiltro");
ConfigNomFuncionFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_TP_FUNCION = this.getStoreCO_TP_FUNCION();
//<Stores de fk>

//objeto store
this.store_lista = this.getLista();

//this.gridPanel_ = new Ext.grid.GridPanel({
this.gridPanel_ = new Ext.grid.EditorGridPanel({
    //title:'Lista de Config Nom Funcion',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:490,
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_nom_funcion',hidden:true, menuDisabled:true,dataIndex: 'co_nom_funcion'},
    {header: 'Variable/Funcion', width:600,  menuDisabled:true, sortable: true, renderer: textoLargo, editor: new Ext.form.TextField({ allowBlank: false }), dataIndex: 'tx_nom_funcion'},
    {header: 'Descripcion', width:300,  menuDisabled:true, sortable: true, renderer: textoLargo, dataIndex: 'tx_nom_descripcion'},
    //{header: 'Parametro', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tx_nom_parametro'},
    {header: 'Tipo', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'co_tp_funcion'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    bbar: new Ext.PagingToolbar({
        pageSize: 100,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.store_lista.load();

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       border:false,
       defaults:{layout:'form',bodyStyle:'padding:0px;',autoHeight:true,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                    this.gridPanel_
                                           ]
               }
            ]
    });


    this.win = new Ext.Window({
        title:'Parametros de busqueda',
        iconCls: 'icon-buscar',
        width:1050,
        autoHeight:true,
        constrain:true,
        closable:true,
        buttonAlign:'center',
        items:[
            this.tabpanelfiltro
        ],
        /*buttons:[
            {
                text:'Cerrar',
                handler:function(){
                    ConfigNomFuncionFiltro.main.win.close();
                    //ConfigNomFuncionLista.main.filtro.setDisabled(false);
                }
            }
        ]*/
    });
    this.win.show();
    //ConfigNomFuncionLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ConfigNomFuncionFiltro.main.panelfiltro.getForm().reset();
    ConfigNomFuncionLista.main.store_lista.baseParams={}
    ConfigNomFuncionLista.main.store_lista.baseParams.paginar = 'si';
    ConfigNomFuncionLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ConfigNomFuncionFiltro.main.panelfiltro.getForm().getValues();
    ConfigNomFuncionLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ConfigNomFuncionLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ConfigNomFuncionLista.main.store_lista.baseParams.paginar = 'si';
        ConfigNomFuncionLista.main.store_lista.baseParams.BuscarBy = true;
        ConfigNomFuncionLista.main.store_lista.load();


}
,getStoreCO_TP_FUNCION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigNomFuncion/storefkcotpfuncion',
        root:'data',
        fields:[
            {name: 'co_tp_funcion'}
            ]
    });
    return this.store;
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigNomFuncion/storelista',
    root:'data',
    fields:[
    {name: 'co_nom_funcion'},
    {name: 'tx_nom_funcion'},
    {name: 'tx_nom_descripcion'},
    {name: 'tx_nom_parametro'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'co_tp_funcion'},
           ]
    });
    return this.store;
}

};

Ext.onReady(ConfigNomFuncionFiltro.main.init,ConfigNomFuncionFiltro.main);
</script>