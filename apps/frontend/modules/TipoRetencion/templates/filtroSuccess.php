<script type="text/javascript">
Ext.ns("TipoRetencionFiltro");
TipoRetencionFiltro.main = {
init:function(){




this.tx_tipo_retencion = new Ext.form.TextField({
	fieldLabel:'Tx tipo retencion',
	name:'tx_tipo_retencion',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.tx_tipo_retencion,
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
                     TipoRetencionFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    TipoRetencionFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    TipoRetencionFiltro.main.win.close();
                    TipoRetencionLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    TipoRetencionLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    TipoRetencionFiltro.main.panelfiltro.getForm().reset();
    TipoRetencionLista.main.store_lista.baseParams={}
    TipoRetencionLista.main.store_lista.baseParams.paginar = 'si';
    TipoRetencionLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = TipoRetencionFiltro.main.panelfiltro.getForm().getValues();
    TipoRetencionLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("TipoRetencionLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        TipoRetencionLista.main.store_lista.baseParams.paginar = 'si';
        TipoRetencionLista.main.store_lista.baseParams.BuscarBy = true;
        TipoRetencionLista.main.store_lista.load();


}

};

Ext.onReady(TipoRetencionFiltro.main.init,TipoRetencionFiltro.main);
</script>