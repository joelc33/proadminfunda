<script type="text/javascript">
Ext.ns("ConfigPrimaAntiguedadFiltro");
ConfigPrimaAntiguedadFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_TP_NOMINA = this.getStoreCO_TP_NOMINA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_GRUPO_NOMINA = this.getStoreCO_GRUPO_NOMINA();
//<Stores de fk>



this.co_tp_nomina = new Ext.form.ComboBox({
	fieldLabel:'Tipo Nomina',
	store: this.storeCO_TP_NOMINA,
	typeAhead: true,
	valueField: 'co_tp_nomina',
	displayField:'nomina',
	hiddenName:'co_tp_nomina',
	//readOnly:(this.OBJ.co_tp_nomina!='')?true:false,
	//style:(this.main.OBJ.co_tp_nomina!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Tipo Nomina',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false,
    listeners:{
		select: function(){
			ConfigPrimaAntiguedadFiltro.main.co_grupo_nomina.clearValue();
			ConfigPrimaAntiguedadFiltro.main.storeCO_GRUPO_NOMINA.load({
				params: {
					tipo:this.getValue()
				}
			})
		}
  	}
});
this.storeCO_TP_NOMINA.load();

this.co_grupo_nomina = new Ext.form.ComboBox({
	fieldLabel:'Grupo Nomina',
	store: this.storeCO_GRUPO_NOMINA,
	typeAhead: true,
	valueField: 'co_grupo_nomina',
	displayField:'cod_grupo_nomina',
	hiddenName:'co_grupo_nomina',
	//readOnly:(this.OBJ.co_grupo_nomina!='')?true:false,
	//style:(this.main.OBJ.co_grupo_nomina!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Grupo Nomina',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false
});
//this.storeCO_GRUPO_NOMINA.load();

this.nu_anio = new Ext.form.NumberField({
	fieldLabel:'Años',
name:'nu_anio',
	value:'',
	width:100
});

this.nu_porcentaje = new Ext.form.NumberField({
	fieldLabel:'Porcentaje',
name:'nu_porcentaje',
	value:'',
	width:100
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_tp_nomina,
                                                                                this.co_grupo_nomina,
                                                                                this.nu_anio,
                                                                                this.nu_porcentaje,
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
                     ConfigPrimaAntiguedadFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ConfigPrimaAntiguedadFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ConfigPrimaAntiguedadFiltro.main.win.close();
                    ConfigPrimaAntiguedadLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ConfigPrimaAntiguedadLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ConfigPrimaAntiguedadFiltro.main.panelfiltro.getForm().reset();
    ConfigPrimaAntiguedadLista.main.store_lista.baseParams={}
    ConfigPrimaAntiguedadLista.main.store_lista.baseParams.paginar = 'si';
    ConfigPrimaAntiguedadLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ConfigPrimaAntiguedadFiltro.main.panelfiltro.getForm().getValues();
    ConfigPrimaAntiguedadLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ConfigPrimaAntiguedadLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ConfigPrimaAntiguedadLista.main.store_lista.baseParams.paginar = 'si';
        ConfigPrimaAntiguedadLista.main.store_lista.baseParams.BuscarBy = true;
        ConfigPrimaAntiguedadLista.main.store_lista.load();


}
,getStoreCO_TP_NOMINA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPrimaAntiguedad/storefkcotpnomina',
        root:'data',
        fields:[
            {name: 'co_tp_nomina'},
            {
				name: 'nomina',
				convert: function(v, r) {
						return r.nu_nomina + ' - ' + r.tx_tp_nomina;
				}
		    }
            ]
    });
    return this.store;
}
,getStoreCO_GRUPO_NOMINA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPrimaAntiguedad/storefkcogruponomina',
        root:'data',
        fields:[
            {name: 'co_grupo_nomina'},
            {name: 'cod_grupo_nomina'},
            {
				name: 'grupo',
				convert: function(v, r) {
						return r.cod_grupo_nomina + ' - ' + r.tx_grupo_nomina;
				}
		    }
            ]
    });
    return this.store;
}

};

Ext.onReady(ConfigPrimaAntiguedadFiltro.main.init,ConfigPrimaAntiguedadFiltro.main);
</script>