<script type="text/javascript">
Ext.ns("ConceptoNominaTipoCargoFiltro");
ConceptoNominaTipoCargoFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_CONCEPTO = this.getStoreCO_CONCEPTO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TP_CARGO = this.getStoreCO_TP_CARGO();
//<Stores de fk>



this.co_concepto = new Ext.form.ComboBox({
	fieldLabel:'Co concepto',
	store: this.storeCO_CONCEPTO,
	typeAhead: true,
	valueField: 'co_concepto',
	displayField:'co_concepto',
	hiddenName:'co_concepto',
	//readOnly:(this.OBJ.co_concepto!='')?true:false,
	//style:(this.main.OBJ.co_concepto!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_concepto',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_CONCEPTO.load();

this.co_tp_cargo = new Ext.form.ComboBox({
	fieldLabel:'Co tp cargo',
	store: this.storeCO_TP_CARGO,
	typeAhead: true,
	valueField: 'co_tp_cargo',
	displayField:'co_tp_cargo',
	hiddenName:'co_tp_cargo',
	//readOnly:(this.OBJ.co_tp_cargo!='')?true:false,
	//style:(this.main.OBJ.co_tp_cargo!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tp_cargo',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TP_CARGO.load();

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
                                                                                                            this.co_concepto,
                                                                                this.co_tp_cargo,
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
                     ConceptoNominaTipoCargoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ConceptoNominaTipoCargoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ConceptoNominaTipoCargoFiltro.main.win.close();
                    ConceptoNominaTipoCargoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ConceptoNominaTipoCargoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ConceptoNominaTipoCargoFiltro.main.panelfiltro.getForm().reset();
    ConceptoNominaTipoCargoLista.main.store_lista.baseParams={}
    ConceptoNominaTipoCargoLista.main.store_lista.baseParams.paginar = 'si';
    ConceptoNominaTipoCargoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ConceptoNominaTipoCargoFiltro.main.panelfiltro.getForm().getValues();
    ConceptoNominaTipoCargoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ConceptoNominaTipoCargoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ConceptoNominaTipoCargoLista.main.store_lista.baseParams.paginar = 'si';
        ConceptoNominaTipoCargoLista.main.store_lista.baseParams.BuscarBy = true;
        ConceptoNominaTipoCargoLista.main.store_lista.load();


}
,getStoreCO_CONCEPTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaTipoCargo/storefkcoconcepto',
        root:'data',
        fields:[
            {name: 'co_concepto'}
            ]
    });
    return this.store;
}
,getStoreCO_TP_CARGO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaTipoCargo/storefkcotpcargo',
        root:'data',
        fields:[
            {name: 'co_tp_cargo'}
            ]
    });
    return this.store;
}

};

Ext.onReady(ConceptoNominaTipoCargoFiltro.main.init,ConceptoNominaTipoCargoFiltro.main);
</script>