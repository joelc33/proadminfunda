<script type="text/javascript">
Ext.ns("ConfiguracionRutaFiltro");
ConfiguracionRutaFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_TIPO_SOLICITUD = this.getStoreCO_TIPO_SOLICITUD();
//<Stores de fk>
//<Stores de fk>
this.storeCO_PROCESO = this.getStoreCO_PROCESO();
//<Stores de fk>



this.co_tipo_solicitud = new Ext.form.ComboBox({
	fieldLabel:'Co tipo solicitud',
	store: this.storeCO_TIPO_SOLICITUD,
	typeAhead: true,
	valueField: 'co_tipo_solicitud',
	displayField:'co_tipo_solicitud',
	hiddenName:'co_tipo_solicitud',
	//readOnly:(this.OBJ.co_tipo_solicitud!='')?true:false,
	//style:(this.main.OBJ.co_tipo_solicitud!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tipo_solicitud',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_SOLICITUD.load();

this.co_proceso = new Ext.form.ComboBox({
	fieldLabel:'Co proceso',
	store: this.storeCO_PROCESO,
	typeAhead: true,
	valueField: 'co_proceso',
	displayField:'co_proceso',
	hiddenName:'co_proceso',
	//readOnly:(this.OBJ.co_proceso!='')?true:false,
	//style:(this.main.OBJ.co_proceso!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_proceso',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_PROCESO.load();

this.nu_orden = new Ext.form.NumberField({
	fieldLabel:'Nu orden',
	name:'nu_orden',
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
,getStoreCO_TIPO_SOLICITUD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfiguracionRuta/storefkcotiposolicitud',
        root:'data',
        fields:[
            {name: 'co_tipo_solicitud'}
            ]
    });
    return this.store;
}
,getStoreCO_PROCESO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfiguracionRuta/storefkcoproceso',
        root:'data',
        fields:[
            {name: 'co_proceso'}
            ]
    });
    return this.store;
}

};

Ext.onReady(ConfiguracionRutaFiltro.main.init,ConfiguracionRutaFiltro.main);
</script>