<script type="text/javascript">
Ext.ns("TipoAyudaFiltro");
TipoAyudaFiltro.main = {
init:function(){




this.tx_tipo_ayuda = new Ext.form.TextField({
	fieldLabel:'Tx tipo ayuda',
	name:'tx_tipo_ayuda',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.tx_tipo_ayuda,
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
                     TipoAyudaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    TipoAyudaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    TipoAyudaFiltro.main.win.close();
                    TipoAyudaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    TipoAyudaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    TipoAyudaFiltro.main.panelfiltro.getForm().reset();
    TipoAyudaLista.main.store_lista.baseParams={}
    TipoAyudaLista.main.store_lista.baseParams.paginar = 'si';
    TipoAyudaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = TipoAyudaFiltro.main.panelfiltro.getForm().getValues();
    TipoAyudaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("TipoAyudaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        TipoAyudaLista.main.store_lista.baseParams.paginar = 'si';
        TipoAyudaLista.main.store_lista.baseParams.BuscarBy = true;
        TipoAyudaLista.main.store_lista.load();


}

};

Ext.onReady(TipoAyudaFiltro.main.init,TipoAyudaFiltro.main);
</script>