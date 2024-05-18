<script type="text/javascript">
Ext.ns("ConceptoNominaPagoFiltro");
ConceptoNominaPagoFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_TP_CONCEPTO = this.getStoreCO_TP_CONCEPTO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TP_UNIDAD = this.getStoreCO_TP_UNIDAD();
//<Stores de fk>

this.nu_concepto = new Ext.form.TextField({
	fieldLabel:'Codigo',
	name:'nu_concepto',
	value:'',
    width:300
});

this.tx_concepto = new Ext.form.TextField({
	fieldLabel:'Concepto',
	name:'tx_concepto',
	value:'',
    width:300
});

this.co_tipo_concepto = new Ext.form.ComboBox({
	fieldLabel:'Tipo de Concepto',
	store: this.storeCO_TP_CONCEPTO,
	typeAhead: true,
	valueField: 'co_tp_concepto',
	displayField:'tx_tp_concepto',
	hiddenName:'co_tipo_concepto',
	//readOnly:(this.OBJ.co_tipo_concepto!='')?true:false,
	//style:(this.main.OBJ.co_tipo_concepto!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Tipo de Concepto',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:true
});
this.storeCO_TP_CONCEPTO.load();

this.co_tipo_unidad = new Ext.form.ComboBox({
	fieldLabel:'Tipo de Unidad',
	store: this.storeCO_TP_UNIDAD,
	typeAhead: true,
	valueField: 'co_tp_unidad',
	displayField:'tx_tp_unidad',
	hiddenName:'co_tipo_unidad',
	//readOnly:(this.OBJ.co_tipo_unidad!='')?true:false,
	//style:(this.main.OBJ.co_tipo_unidad!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Unidad',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:true
});
this.storeCO_TP_UNIDAD.load();

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                        this.nu_concepto,
                        this.tx_concepto,
                        this.co_tipo_concepto,
                        this.co_tipo_unidad,
                    ]
               }
            ]
    });

    this.panelfiltro = new Ext.form.FormPanel({
        frame:true,
        autoWidth:true,
        border:false,
        labelWidth: 150,
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
                     ConceptoNominaPagoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ConceptoNominaPagoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ConceptoNominaPagoFiltro.main.win.close();
                    ConceptoNominaPagoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ConceptoNominaPagoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ConceptoNominaPagoFiltro.main.panelfiltro.getForm().reset();
    ConceptoNominaPagoLista.main.store_lista.baseParams={}
    ConceptoNominaPagoLista.main.store_lista.baseParams.paginar = 'si';
    ConceptoNominaPagoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ConceptoNominaPagoFiltro.main.panelfiltro.getForm().getValues();
    ConceptoNominaPagoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ConceptoNominaPagoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ConceptoNominaPagoLista.main.store_lista.baseParams.paginar = 'si';
        ConceptoNominaPagoLista.main.store_lista.baseParams.BuscarBy = true;
        ConceptoNominaPagoLista.main.store_lista.load();


}
,getStoreCO_TP_CONCEPTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPago/storefkcotipoconcepto',
        root:'data',
        fields:[
            {name: 'co_tp_concepto'},
			{name: 'tx_tp_concepto'}
            ]
    });
    return this.store;
}
,getStoreCO_TP_UNIDAD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPago/storefkcotipounidad',
        root:'data',
        fields:[
            {name: 'co_tp_unidad'},
			{name: 'tx_tp_unidad'}
            ]
    });
    return this.store;
}
};

Ext.onReady(ConceptoNominaPagoFiltro.main.init,ConceptoNominaPagoFiltro.main);
</script>