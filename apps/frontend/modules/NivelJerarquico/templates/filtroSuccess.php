<script type="text/javascript">
Ext.ns("NivelJerarquicoFiltro");
NivelJerarquicoFiltro.main = {
init:function(){




this.tx_nivel_jerarquico = new Ext.form.TextField({
	fieldLabel:'Tx nivel jerarquico',
	name:'tx_nivel_jerarquico',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.tx_nivel_jerarquico,
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
                     NivelJerarquicoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    NivelJerarquicoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    NivelJerarquicoFiltro.main.win.close();
                    NivelJerarquicoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    NivelJerarquicoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    NivelJerarquicoFiltro.main.panelfiltro.getForm().reset();
    NivelJerarquicoLista.main.store_lista.baseParams={}
    NivelJerarquicoLista.main.store_lista.baseParams.paginar = 'si';
    NivelJerarquicoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = NivelJerarquicoFiltro.main.panelfiltro.getForm().getValues();
    NivelJerarquicoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("NivelJerarquicoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        NivelJerarquicoLista.main.store_lista.baseParams.paginar = 'si';
        NivelJerarquicoLista.main.store_lista.baseParams.BuscarBy = true;
        NivelJerarquicoLista.main.store_lista.load();


}

};

Ext.onReady(NivelJerarquicoFiltro.main.init,NivelJerarquicoFiltro.main);
</script>