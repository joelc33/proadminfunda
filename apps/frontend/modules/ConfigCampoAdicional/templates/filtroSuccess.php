<script type="text/javascript">
Ext.ns("ConfigCampoAdicionalFiltro");
ConfigCampoAdicionalFiltro.main = {
init:function(){




this.tx_concep_adicional = new Ext.form.TextField({
	fieldLabel:'Tx concep adicional',
	name:'tx_concep_adicional',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.tx_concep_adicional,
                                           ]
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
                     ConfigCampoAdicionalFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ConfigCampoAdicionalFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ConfigCampoAdicionalFiltro.main.win.close();
                    ConfigCampoAdicionalLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ConfigCampoAdicionalLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ConfigCampoAdicionalFiltro.main.panelfiltro.getForm().reset();
    ConfigCampoAdicionalLista.main.store_lista.baseParams={}
    ConfigCampoAdicionalLista.main.store_lista.baseParams.paginar = 'si';
    ConfigCampoAdicionalLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ConfigCampoAdicionalFiltro.main.panelfiltro.getForm().getValues();
    ConfigCampoAdicionalLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ConfigCampoAdicionalLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ConfigCampoAdicionalLista.main.store_lista.baseParams.paginar = 'si';
        ConfigCampoAdicionalLista.main.store_lista.baseParams.BuscarBy = true;
        ConfigCampoAdicionalLista.main.store_lista.load();


}

};

Ext.onReady(ConfigCampoAdicionalFiltro.main.init,ConfigCampoAdicionalFiltro.main);
</script>