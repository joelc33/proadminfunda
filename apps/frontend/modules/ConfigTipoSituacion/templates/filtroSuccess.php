<script type="text/javascript">
Ext.ns("ConfigTipoSituacionFiltro");
ConfigTipoSituacionFiltro.main = {
init:function(){




this.tx_nom_situacion = new Ext.form.TextField({
	fieldLabel:'Tx nom situacion',
	name:'tx_nom_situacion',
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
                                                                                                            this.tx_nom_situacion,
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
                     ConfigTipoSituacionFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ConfigTipoSituacionFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ConfigTipoSituacionFiltro.main.win.close();
                    ConfigTipoSituacionLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ConfigTipoSituacionLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ConfigTipoSituacionFiltro.main.panelfiltro.getForm().reset();
    ConfigTipoSituacionLista.main.store_lista.baseParams={}
    ConfigTipoSituacionLista.main.store_lista.baseParams.paginar = 'si';
    ConfigTipoSituacionLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ConfigTipoSituacionFiltro.main.panelfiltro.getForm().getValues();
    ConfigTipoSituacionLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ConfigTipoSituacionLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ConfigTipoSituacionLista.main.store_lista.baseParams.paginar = 'si';
        ConfigTipoSituacionLista.main.store_lista.baseParams.BuscarBy = true;
        ConfigTipoSituacionLista.main.store_lista.load();


}

};

Ext.onReady(ConfigTipoSituacionFiltro.main.init,ConfigTipoSituacionFiltro.main);
</script>