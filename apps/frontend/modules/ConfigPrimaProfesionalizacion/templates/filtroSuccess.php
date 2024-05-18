<script type="text/javascript">
Ext.ns("ConfigPrimaProfesionalizacionFiltro");
ConfigPrimaProfesionalizacionFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_TP_NOMINA = this.getStoreCO_TP_NOMINA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_GRUPO_NOMINA = this.getStoreCO_GRUPO_NOMINA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_NIVEL_EDUCATIVO = this.getStoreCO_NIVEL_EDUCATIVO();
//<Stores de fk>



this.co_tp_nomina = new Ext.form.ComboBox({
	fieldLabel:'Tipo de nomina',
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
	emptyText:'Seleccione Tipo',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false,
    listeners:{
		select: function(){
			ConfigPrimaProfesionalizacionFiltro.main.co_grupo_nomina.clearValue();
			ConfigPrimaProfesionalizacionFiltro.main.storeCO_GRUPO_NOMINA.load({
				params: {
					tipo:this.getValue()
				}
			})
		}
  	}
});
this.storeCO_TP_NOMINA.load();

this.co_grupo_nomina = new Ext.form.ComboBox({
	fieldLabel:'Grupo de nomina',
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
	emptyText:'Seleccione Grupo',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
//this.storeCO_GRUPO_NOMINA.load();

this.co_nivel_educativo = new Ext.form.ComboBox({
	fieldLabel:'Nivel Educativo',
	store: this.storeCO_NIVEL_EDUCATIVO,
	typeAhead: true,
	valueField: 'co_nivel_educativo',
	displayField:'de_nivel_educativo',
	hiddenName:'co_nivel_educativo',
	//readOnly:(this.OBJ.co_nivel_educativo!='')?true:false,
	//style:(this.main.OBJ.co_nivel_educativo!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Nivel Educativo',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_NIVEL_EDUCATIVO.load();

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
                                                                                this.co_nivel_educativo,
                                                                                this.nu_porcentaje
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
                     ConfigPrimaProfesionalizacionFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ConfigPrimaProfesionalizacionFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ConfigPrimaProfesionalizacionFiltro.main.win.close();
                    ConfigPrimaProfesionalizacionLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ConfigPrimaProfesionalizacionLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ConfigPrimaProfesionalizacionFiltro.main.panelfiltro.getForm().reset();
    ConfigPrimaProfesionalizacionLista.main.store_lista.baseParams={}
    ConfigPrimaProfesionalizacionLista.main.store_lista.baseParams.paginar = 'si';
    ConfigPrimaProfesionalizacionLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ConfigPrimaProfesionalizacionFiltro.main.panelfiltro.getForm().getValues();
    ConfigPrimaProfesionalizacionLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ConfigPrimaProfesionalizacionLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ConfigPrimaProfesionalizacionLista.main.store_lista.baseParams.paginar = 'si';
        ConfigPrimaProfesionalizacionLista.main.store_lista.baseParams.BuscarBy = true;
        ConfigPrimaProfesionalizacionLista.main.store_lista.load();


}
,getStoreCO_TP_NOMINA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPrimaProfesionalizacion/storefkcotpnomina',
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
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPrimaProfesionalizacion/storefkcogruponomina',
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
,getStoreCO_NIVEL_EDUCATIVO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPrimaProfesionalizacion/storefkconiveleducativo',
        root:'data',
        fields:[
            {name: 'co_nivel_educativo'},
            {name: 'de_nivel_educativo'}
            ]
    });
    return this.store;
}

};

Ext.onReady(ConfigPrimaProfesionalizacionFiltro.main.init,ConfigPrimaProfesionalizacionFiltro.main);
</script>