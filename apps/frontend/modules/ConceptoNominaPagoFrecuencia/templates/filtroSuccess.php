<script type="text/javascript">
Ext.ns("ConceptoNominaPagoFrecuenciaFiltro");
ConceptoNominaPagoFrecuenciaFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_CONCEPTO = this.getStoreCO_CONCEPTO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_NOM_FRECUENCIA_PAGO = this.getStoreCO_NOM_FRECUENCIA_PAGO();
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

this.co_nom_frecuencia_pago = new Ext.form.ComboBox({
	fieldLabel:'Co nom frecuencia pago',
	store: this.storeCO_NOM_FRECUENCIA_PAGO,
	typeAhead: true,
	valueField: 'co_nom_frecuencia_pago',
	displayField:'co_nom_frecuencia_pago',
	hiddenName:'co_nom_frecuencia_pago',
	//readOnly:(this.OBJ.co_nom_frecuencia_pago!='')?true:false,
	//style:(this.main.OBJ.co_nom_frecuencia_pago!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_nom_frecuencia_pago',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_NOM_FRECUENCIA_PAGO.load();

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
                                                                                this.co_nom_frecuencia_pago,
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
                     ConceptoNominaPagoFrecuenciaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ConceptoNominaPagoFrecuenciaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ConceptoNominaPagoFrecuenciaFiltro.main.win.close();
                    ConceptoNominaPagoFrecuenciaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ConceptoNominaPagoFrecuenciaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ConceptoNominaPagoFrecuenciaFiltro.main.panelfiltro.getForm().reset();
    ConceptoNominaPagoFrecuenciaLista.main.store_lista.baseParams={}
    ConceptoNominaPagoFrecuenciaLista.main.store_lista.baseParams.paginar = 'si';
    ConceptoNominaPagoFrecuenciaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ConceptoNominaPagoFrecuenciaFiltro.main.panelfiltro.getForm().getValues();
    ConceptoNominaPagoFrecuenciaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ConceptoNominaPagoFrecuenciaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ConceptoNominaPagoFrecuenciaLista.main.store_lista.baseParams.paginar = 'si';
        ConceptoNominaPagoFrecuenciaLista.main.store_lista.baseParams.BuscarBy = true;
        ConceptoNominaPagoFrecuenciaLista.main.store_lista.load();


}
,getStoreCO_CONCEPTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoFrecuencia/storefkcoconcepto',
        root:'data',
        fields:[
            {name: 'co_concepto'}
            ]
    });
    return this.store;
}
,getStoreCO_NOM_FRECUENCIA_PAGO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoFrecuencia/storefkconomfrecuenciapago',
        root:'data',
        fields:[
            {name: 'co_nom_frecuencia_pago'}
            ]
    });
    return this.store;
}

};

Ext.onReady(ConceptoNominaPagoFrecuenciaFiltro.main.init,ConceptoNominaPagoFrecuenciaFiltro.main);
</script>