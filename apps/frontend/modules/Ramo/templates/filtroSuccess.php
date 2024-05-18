<script type="text/javascript">
Ext.ns("RamoFiltro");
RamoFiltro.main = {
init:function(){




this.tx_ramo = new Ext.form.TextField({
	fieldLabel:'Ramo',
	name:'tx_ramo',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.tx_ramo,
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
                     RamoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    RamoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    RamoFiltro.main.win.close();
                    RamoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    RamoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    RamoFiltro.main.panelfiltro.getForm().reset();
    RamoLista.main.store_lista.baseParams={}
    RamoLista.main.store_lista.baseParams.paginar = 'si';
    RamoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = RamoFiltro.main.panelfiltro.getForm().getValues();
    RamoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("RamoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        RamoLista.main.store_lista.baseParams.paginar = 'si';
        RamoLista.main.store_lista.baseParams.BuscarBy = true;
        RamoLista.main.store_lista.load();


}

};

Ext.onReady(RamoFiltro.main.init,RamoFiltro.main);
</script>