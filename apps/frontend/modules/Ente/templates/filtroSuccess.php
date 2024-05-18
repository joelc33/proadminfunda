<script type="text/javascript">
Ext.ns("EnteFiltro");
EnteFiltro.main = {
init:function(){




this.tx_ente = new Ext.form.TextField({
	fieldLabel:'Tx ente',
	name:'tx_ente',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.tx_ente,
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
                     EnteFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    EnteFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    EnteFiltro.main.win.close();
                    EnteLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    EnteLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    EnteFiltro.main.panelfiltro.getForm().reset();
    EnteLista.main.store_lista.baseParams={}
    EnteLista.main.store_lista.baseParams.paginar = 'si';
    EnteLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = EnteFiltro.main.panelfiltro.getForm().getValues();
    EnteLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("EnteLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        EnteLista.main.store_lista.baseParams.paginar = 'si';
        EnteLista.main.store_lista.baseParams.BuscarBy = true;
        EnteLista.main.store_lista.load();


}

};

Ext.onReady(EnteFiltro.main.init,EnteFiltro.main);
</script>