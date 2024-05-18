<script type="text/javascript">
Ext.ns("ConfiguracionRutaFiltro");
ConfiguracionRutaFiltro.main = {
init:function(){




this.co_tipo_solicitud = new Ext.form.NumberField({
	fieldLabel:'Co tipo solicitud',
	name:'co_tipo_solicitud',
	value:''
});

this.co_proceso = new Ext.form.NumberField({
	fieldLabel:'Co proceso',
	name:'co_proceso',
	value:''
});

this.nu_orden = new Ext.form.NumberField({
	fieldLabel:'Nu orden',
	name:'nu_orden',
	value:''
});

this.in_cargar_dato = new Ext.form.Checkbox({
	fieldLabel:'In cargar dato',
	name:'in_cargar_dato',
	checked:true
});

this.nb_reporte_orden = new Ext.form.TextField({
	fieldLabel:'Nb reporte orden',
	name:'nb_reporte_orden',
	value:''
});

this.tx_url = new Ext.form.TextField({
	fieldLabel:'Tx url',
	name:'tx_url',
	value:''
});

this.tx_modulo = new Ext.form.TextField({
	fieldLabel:'Tx modulo',
	name:'tx_modulo',
	value:''
});

this.in_incompleto = new Ext.form.Checkbox({
	fieldLabel:'In incompleto',
	name:'in_incompleto',
	checked:true
});

this.op_reporte = new Ext.form.TextField({
	fieldLabel:'Op reporte',
	name:'op_reporte',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_tipo_solicitud,
                                                                                this.co_proceso,
                                                                                this.nu_orden,
                                                                                this.in_cargar_dato,
                                                                                this.nb_reporte_orden,
                                                                                this.tx_url,
                                                                                this.tx_modulo,
                                                                                this.in_incompleto,
                                                                                this.op_reporte,
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
                     ConfiguracionRutaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ConfiguracionRutaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ConfiguracionRutaFiltro.main.win.close();
                    ConfiguracionRutaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ConfiguracionRutaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ConfiguracionRutaFiltro.main.panelfiltro.getForm().reset();
    ConfiguracionRutaLista.main.store_lista.baseParams={}
    ConfiguracionRutaLista.main.store_lista.baseParams.paginar = 'si';
    ConfiguracionRutaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ConfiguracionRutaFiltro.main.panelfiltro.getForm().getValues();
    ConfiguracionRutaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ConfiguracionRutaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ConfiguracionRutaLista.main.store_lista.baseParams.paginar = 'si';
        ConfiguracionRutaLista.main.store_lista.baseParams.BuscarBy = true;
        ConfiguracionRutaLista.main.store_lista.load();


}

};

Ext.onReady(ConfiguracionRutaFiltro.main.init,ConfiguracionRutaFiltro.main);
</script>