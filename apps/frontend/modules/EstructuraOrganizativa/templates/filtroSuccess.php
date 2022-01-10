<script type="text/javascript">
Ext.ns("EstructuraOrganizativaFiltro");
EstructuraOrganizativaFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_NIVEL_JERARQUICO = this.getStoreCO_NIVEL_JERARQUICO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_DEPENDENCIA = this.getStoreCO_DEPENDENCIA();
//<Stores de fk>



this.co_padre = new Ext.form.NumberField({
	fieldLabel:'Co padre',
	name:'co_padre',
	value:''
});

this.tx_nom_estructura_administrativa = new Ext.form.TextField({
	fieldLabel:'Tx nom estructura administrativa',
	name:'tx_nom_estructura_administrativa',
	value:''
});

this.nu_centro_costo = new Ext.form.TextField({
	fieldLabel:'Nu centro costo',
	name:'nu_centro_costo',
	value:''
});

this.co_ente = new Ext.form.NumberField({
	fieldLabel:'Co ente',
	name:'co_ente',
	value:''
});

this.co_nivel_jerarquico = new Ext.form.ComboBox({
	fieldLabel:'Co nivel jerarquico',
	store: this.storeCO_NIVEL_JERARQUICO,
	typeAhead: true,
	valueField: 'co_nivel_jerarquico',
	displayField:'co_nivel_jerarquico',
	hiddenName:'co_nivel_jerarquico',
	//readOnly:(this.OBJ.co_nivel_jerarquico!='')?true:false,
	//style:(this.main.OBJ.co_nivel_jerarquico!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_nivel_jerarquico',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_NIVEL_JERARQUICO.load();

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

this.co_dependencia = new Ext.form.ComboBox({
	fieldLabel:'Co dependencia',
	store: this.storeCO_DEPENDENCIA,
	typeAhead: true,
	valueField: 'co_dependencia',
	displayField:'co_dependencia',
	hiddenName:'co_dependencia',
	//readOnly:(this.OBJ.co_dependencia!='')?true:false,
	//style:(this.main.OBJ.co_dependencia!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_dependencia',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_DEPENDENCIA.load();

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_padre,
                                                                                this.tx_nom_estructura_administrativa,
                                                                                this.nu_centro_costo,
                                                                                this.co_ente,
                                                                                this.co_nivel_jerarquico,
                                                                                this.in_activo,
                                                                                this.created_at,
                                                                                this.updated_at,
                                                                                this.co_dependencia,
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
                     EstructuraOrganizativaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    EstructuraOrganizativaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    EstructuraOrganizativaFiltro.main.win.close();
                    EstructuraOrganizativaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    EstructuraOrganizativaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    EstructuraOrganizativaFiltro.main.panelfiltro.getForm().reset();
    EstructuraOrganizativaLista.main.store_lista.baseParams={}
    EstructuraOrganizativaLista.main.store_lista.baseParams.paginar = 'si';
    EstructuraOrganizativaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = EstructuraOrganizativaFiltro.main.panelfiltro.getForm().getValues();
    EstructuraOrganizativaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("EstructuraOrganizativaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        EstructuraOrganizativaLista.main.store_lista.baseParams.paginar = 'si';
        EstructuraOrganizativaLista.main.store_lista.baseParams.BuscarBy = true;
        EstructuraOrganizativaLista.main.store_lista.load();


}
,getStoreCO_NIVEL_JERARQUICO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/storefkconiveljerarquico',
        root:'data',
        fields:[
            {name: 'co_nivel_jerarquico'}
            ]
    });
    return this.store;
}
,getStoreCO_DEPENDENCIA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/storefkcodependencia',
        root:'data',
        fields:[
            {name: 'co_dependencia'}
            ]
    });
    return this.store;
}

};

Ext.onReady(EstructuraOrganizativaFiltro.main.init,EstructuraOrganizativaFiltro.main);
</script>