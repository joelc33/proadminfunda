<script type="text/javascript">
Ext.ns("ConfigTipoFrecuenciaFiltro");
ConfigTipoFrecuenciaFiltro.main = {
init:function(){




this.tx_nom_frecuencia_pago = new Ext.form.TextField({
	fieldLabel:'Tx nom frecuencia pago',
	name:'tx_nom_frecuencia_pago',
	value:''
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'in_activo',
	checked:true
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'created_at'
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'updated_at'
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.tx_nom_frecuencia_pago,
                                                                                this.in_activo,
                                                                                this.created_at,
                                                                                this.updated_at,
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
                     ConfigTipoFrecuenciaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ConfigTipoFrecuenciaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ConfigTipoFrecuenciaFiltro.main.win.close();
                    ConfigTipoFrecuenciaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ConfigTipoFrecuenciaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ConfigTipoFrecuenciaFiltro.main.panelfiltro.getForm().reset();
    ConfigTipoFrecuenciaLista.main.store_lista.baseParams={}
    ConfigTipoFrecuenciaLista.main.store_lista.baseParams.paginar = 'si';
    ConfigTipoFrecuenciaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ConfigTipoFrecuenciaFiltro.main.panelfiltro.getForm().getValues();
    ConfigTipoFrecuenciaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ConfigTipoFrecuenciaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ConfigTipoFrecuenciaLista.main.store_lista.baseParams.paginar = 'si';
        ConfigTipoFrecuenciaLista.main.store_lista.baseParams.BuscarBy = true;
        ConfigTipoFrecuenciaLista.main.store_lista.load();


}

};

Ext.onReady(ConfigTipoFrecuenciaFiltro.main.init,ConfigTipoFrecuenciaFiltro.main);
</script>