<script type="text/javascript">
Ext.ns("ConfigTipoAcumuladoFiltro");
ConfigTipoAcumuladoFiltro.main = {
init:function(){




this.tx_nom_acumulado = new Ext.form.TextField({
	fieldLabel:'Tx nom acumulado',
	name:'tx_nom_acumulado',
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
                                                                                                            this.tx_nom_acumulado,
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
                     ConfigTipoAcumuladoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ConfigTipoAcumuladoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ConfigTipoAcumuladoFiltro.main.win.close();
                    ConfigTipoAcumuladoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ConfigTipoAcumuladoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ConfigTipoAcumuladoFiltro.main.panelfiltro.getForm().reset();
    ConfigTipoAcumuladoLista.main.store_lista.baseParams={}
    ConfigTipoAcumuladoLista.main.store_lista.baseParams.paginar = 'si';
    ConfigTipoAcumuladoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ConfigTipoAcumuladoFiltro.main.panelfiltro.getForm().getValues();
    ConfigTipoAcumuladoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ConfigTipoAcumuladoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ConfigTipoAcumuladoLista.main.store_lista.baseParams.paginar = 'si';
        ConfigTipoAcumuladoLista.main.store_lista.baseParams.BuscarBy = true;
        ConfigTipoAcumuladoLista.main.store_lista.load();


}

};

Ext.onReady(ConfigTipoAcumuladoFiltro.main.init,ConfigTipoAcumuladoFiltro.main);
</script>