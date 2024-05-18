<script type="text/javascript">
Ext.ns("ConfigNomFuncionFiltro");
ConfigNomFuncionFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_TP_FUNCION = this.getStoreCO_TP_FUNCION();
//<Stores de fk>



this.tx_nom_funcion = new Ext.form.TextField({
	fieldLabel:'Tx nom funcion',
	name:'tx_nom_funcion',
	value:''
});

this.tx_nom_descripcion = new Ext.form.TextField({
	fieldLabel:'Tx nom descripcion',
	name:'tx_nom_descripcion',
	value:''
});

this.tx_nom_parametro = new Ext.form.TextField({
	fieldLabel:'Tx nom parametro',
	name:'tx_nom_parametro',
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

this.co_tp_funcion = new Ext.form.ComboBox({
	fieldLabel:'Co tp funcion',
	store: this.storeCO_TP_FUNCION,
	typeAhead: true,
	valueField: 'co_tp_funcion',
	displayField:'co_tp_funcion',
	hiddenName:'co_tp_funcion',
	//readOnly:(this.OBJ.co_tp_funcion!='')?true:false,
	//style:(this.main.OBJ.co_tp_funcion!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tp_funcion',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TP_FUNCION.load();

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.tx_nom_funcion,
                                                                                this.tx_nom_descripcion,
                                                                                this.tx_nom_parametro,
                                                                                this.in_activo,
                                                                                this.created_at,
                                                                                this.updated_at,
                                                                                this.co_tp_funcion,
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
                     ConfigNomFuncionFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ConfigNomFuncionFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ConfigNomFuncionFiltro.main.win.close();
                    ConfigNomFuncionLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ConfigNomFuncionLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ConfigNomFuncionFiltro.main.panelfiltro.getForm().reset();
    ConfigNomFuncionLista.main.store_lista.baseParams={}
    ConfigNomFuncionLista.main.store_lista.baseParams.paginar = 'si';
    ConfigNomFuncionLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ConfigNomFuncionFiltro.main.panelfiltro.getForm().getValues();
    ConfigNomFuncionLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ConfigNomFuncionLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ConfigNomFuncionLista.main.store_lista.baseParams.paginar = 'si';
        ConfigNomFuncionLista.main.store_lista.baseParams.BuscarBy = true;
        ConfigNomFuncionLista.main.store_lista.load();


}
,getStoreCO_TP_FUNCION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigNomFuncion/storefkcotpfuncion',
        root:'data',
        fields:[
            {name: 'co_tp_funcion'}
            ]
    });
    return this.store;
}

};

Ext.onReady(ConfigNomFuncionFiltro.main.init,ConfigNomFuncionFiltro.main);
</script>