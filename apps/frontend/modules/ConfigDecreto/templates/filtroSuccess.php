<script type="text/javascript">
Ext.ns("ConfigDecretoFiltro");
ConfigDecretoFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_FUENTE_FINANCIAMIENTO = this.getStoreCO_FUENTE_FINANCIAMIENTO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_USUARIO = this.getStoreCO_USUARIO();
//<Stores de fk>



this.co_fuente_financiamiento = new Ext.form.ComboBox({
	fieldLabel:'Fuente Financiamiento',
	store: this.storeCO_FUENTE_FINANCIAMIENTO,
	typeAhead: true,
	valueField: 'co_fuente_financiamiento',
	displayField:'tx_fuente_financiamiento',
	hiddenName:'co_fuente_financiamiento',
	//readOnly:(this.OBJ.co_fuente_financiamiento!='')?true:false,
	//style:(this.main.OBJ.co_fuente_financiamiento!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Fuente Financiamiento',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false
});
this.storeCO_FUENTE_FINANCIAMIENTO.load();

this.tx_numero_fuente = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'tx_numero_fuente',
	value:'',
	width:300
});

this.co_usuario = new Ext.form.ComboBox({
	fieldLabel:'Co usuario',
	store: this.storeCO_USUARIO,
	typeAhead: true,
	valueField: 'co_usuario',
	displayField:'co_usuario',
	hiddenName:'co_usuario',
	//readOnly:(this.OBJ.co_usuario!='')?true:false,
	//style:(this.main.OBJ.co_usuario!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_usuario',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_USUARIO.load();

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'created_at'
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_fuente_financiamiento,
                                                                                this.tx_numero_fuente,
                                                                                //this.co_usuario,
                                                                                //this.created_at,
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
                     ConfigDecretoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ConfigDecretoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ConfigDecretoFiltro.main.win.close();
                    ConfigDecretoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ConfigDecretoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ConfigDecretoFiltro.main.panelfiltro.getForm().reset();
    ConfigDecretoLista.main.store_lista.baseParams={}
    ConfigDecretoLista.main.store_lista.baseParams.paginar = 'si';
    ConfigDecretoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ConfigDecretoFiltro.main.panelfiltro.getForm().getValues();
    ConfigDecretoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ConfigDecretoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ConfigDecretoLista.main.store_lista.baseParams.paginar = 'si';
        ConfigDecretoLista.main.store_lista.baseParams.BuscarBy = true;
        ConfigDecretoLista.main.store_lista.load();


}
,getStoreCO_FUENTE_FINANCIAMIENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigDecreto/storefkcofuentefinanciamiento',
        root:'data',
        fields:[
            {name: 'co_fuente_financiamiento'},
            {name: 'tx_fuente_financiamiento'}
            ]
    });
    return this.store;
}
,getStoreCO_USUARIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigDecreto/storefkcousuario',
        root:'data',
        fields:[
            {name: 'co_usuario'}
            ]
    });
    return this.store;
}

};

Ext.onReady(ConfigDecretoFiltro.main.init,ConfigDecretoFiltro.main);
</script>