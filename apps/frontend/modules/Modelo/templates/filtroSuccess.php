<script type="text/javascript">
Ext.ns("ModeloFiltro");
ModeloFiltro.main = {
init:function(){


this.storeID = this.getStoreID();
this.tx_modelo = new Ext.form.TextField({
	fieldLabel:'Modelo',
	name:'tx_modelo',
	value:'',
	width:400
});

this.list_marca = new Ext.form.ComboBox({
    fieldLabel:'Marcas',
    store: this.storeID,
    typeAhead: true,
    valueField: 'co_marca',
    displayField:'tx_marca',
    hiddenName:'list_marca',
    //readOnly:(this.OBJ.id_tb093_familia_producto!='')?true:false,
    //style:(this.main.OBJ.id_tb093_familia_producto!='')?'background:#c9c9c9;':'',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Marca',
    selectOnFocus: true,
    mode: 'local',
    width:400,
    resizable:true,
    allowBlank:false
});
this.storeID.load();


    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[this.tx_modelo,this.list_marca]
               }
            ]
    });

    this.panelfiltro = new Ext.form.FormPanel({
        frame:true,
        autoWidth:true,
        border:false,
        items:[
            this.tabpanelfiltro
        ]
    });

    this.win = new Ext.Window({
        title:'Parametros de busqueda',
        iconCls: 'icon-buscar',
        width:600,
        autoHeight:true,
        constrain:true,
        closable:false,
        buttonAlign:'center',
        items:[
            this.panelfiltro
        ],
        buttons:[
            {
                text:'Filtrar',
                handler:function(){
                     ModeloFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ModeloFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ModeloFiltro.main.win.close();
                    ModeloLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ModeloLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ModeloFiltro.main.panelfiltro.getForm().reset();
    ModeloLista.main.store_lista.baseParams={}
    ModeloLista.main.store_lista.baseParams.paginar = 'si';
    ModeloLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ModeloFiltro.main.panelfiltro.getForm().getValues();
    ModeloLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ModeloLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ModeloLista.main.store_lista.baseParams.paginar = 'si';
        ModeloLista.main.store_lista.baseParams.BuscarBy = true;
        ModeloLista.main.store_lista.load();


},getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modelo/storefkcomarca',
        root:'data',
        fields:[
            {name: 'co_marca'},{name: 'tx_marca'}
            ]
    });
    return this.store;
}

};

Ext.onReady(ModeloFiltro.main.init,ModeloFiltro.main);
</script>
