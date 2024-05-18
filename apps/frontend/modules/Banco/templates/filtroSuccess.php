<script type="text/javascript">
Ext.ns("BancoFiltro");
BancoFiltro.main = {
init:function(){




this.tx_banco = new Ext.form.TextField({
	fieldLabel:'Tx banco',
	name:'tx_banco',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.tx_banco,
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
                     BancoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    BancoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    BancoFiltro.main.win.close();
                    BancoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    BancoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    BancoFiltro.main.panelfiltro.getForm().reset();
    BancoLista.main.store_lista.baseParams={}
    BancoLista.main.store_lista.baseParams.paginar = 'si';
    BancoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = BancoFiltro.main.panelfiltro.getForm().getValues();
    BancoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("BancoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        BancoLista.main.store_lista.baseParams.paginar = 'si';
        BancoLista.main.store_lista.baseParams.BuscarBy = true;
        BancoLista.main.store_lista.load();


}

};

Ext.onReady(BancoFiltro.main.init,BancoFiltro.main);
</script>