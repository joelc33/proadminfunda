<script type="text/javascript">
Ext.ns("FuenteFinanciamientoFiltro");
FuenteFinanciamientoFiltro.main = {
init:function(){




this.tx_fuente_financiamiento = new Ext.form.TextField({
	fieldLabel:'Tx fuente financiamiento',
	name:'tx_fuente_financiamiento',
	value:''
});

this.tx_siglas = new Ext.form.TextField({
	fieldLabel:'Tx siglas',
	name:'tx_siglas',
	value:''
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'in_activo',
	checked:true
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.tx_fuente_financiamiento,
                                                                                this.tx_siglas,
                                                                                this.in_activo,
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
                     FuenteFinanciamientoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    FuenteFinanciamientoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    FuenteFinanciamientoFiltro.main.win.close();
                    FuenteFinanciamientoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    FuenteFinanciamientoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    FuenteFinanciamientoFiltro.main.panelfiltro.getForm().reset();
    FuenteFinanciamientoLista.main.store_lista.baseParams={}
    FuenteFinanciamientoLista.main.store_lista.baseParams.paginar = 'si';
    FuenteFinanciamientoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = FuenteFinanciamientoFiltro.main.panelfiltro.getForm().getValues();
    FuenteFinanciamientoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("FuenteFinanciamientoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        FuenteFinanciamientoLista.main.store_lista.baseParams.paginar = 'si';
        FuenteFinanciamientoLista.main.store_lista.baseParams.BuscarBy = true;
        FuenteFinanciamientoLista.main.store_lista.load();


}

};

Ext.onReady(FuenteFinanciamientoFiltro.main.init,FuenteFinanciamientoFiltro.main);
</script>