<script type="text/javascript">
Ext.ns("NominaPeriodoFiltro");
NominaPeriodoFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_TP_NOMINA = this.getStoreCO_TP_NOMINA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_NOM_FRECUENCIA_PAGO = this.getStoreCO_NOM_FRECUENCIA_PAGO();
//<Stores de fk>



this.co_solicitud = new Ext.form.NumberField({
	fieldLabel:'Co solicitud',
	name:'co_solicitud',
	value:''
});

this.co_tp_nomina = new Ext.form.ComboBox({
	fieldLabel:'Nomina',
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
	emptyText:'Seleccione Nomina...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeCO_TP_NOMINA.load();

this.co_nom_frecuencia_pago = new Ext.form.ComboBox({
	fieldLabel:'Frecuencia Pago',
	store: this.storeCO_NOM_FRECUENCIA_PAGO,
	typeAhead: true,
	valueField: 'co_nom_frecuencia_pago',
	displayField:'tx_nom_frecuencia_pago',
	hiddenName:'co_nom_frecuencia_pago',
	//readOnly:(this.OBJ.co_nom_frecuencia_pago!='')?true:false,
	//style:(this.main.OBJ.co_nom_frecuencia_pago!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Frecuencia Pago...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeCO_NOM_FRECUENCIA_PAGO.load();

this.nu_nomina = new Ext.form.TextField({
	fieldLabel:'N° Nomina',
	name:'nu_nomina',
	value:'',
	width:200
});

this.de_nomina = new Ext.form.TextField({
	fieldLabel:'De nomina',
	name:'de_nomina',
	value:''
});

this.de_observacion = new Ext.form.TextField({
	fieldLabel:'De observacion',
	name:'de_observacion',
	value:''
});

this.fe_inicio = new Ext.form.DateField({
	fieldLabel:'Fecha Inicio',
	name:'fe_inicio',
	width:100
});

this.fe_fin = new Ext.form.DateField({
	fieldLabel:'Fecha Cierre',
	name:'fe_fin',
	width:100
});

this.fe_pago = new Ext.form.DateField({
	fieldLabel:'Fecha Pago',
	name:'fe_pago',
	width:100
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

this.in_procesado = new Ext.form.Checkbox({
	fieldLabel:'In procesado',
	name:'in_procesado',
	checked:true
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:175,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                this.co_tp_nomina,
                                                                                this.co_nom_frecuencia_pago,
                                                                                this.nu_nomina,
                                                                                this.fe_inicio,
                                                                                this.fe_fin,
                                                                                this.fe_pago,
                                           ]
               }
            ]
    });

    this.panelfiltro = new Ext.form.FormPanel({
        frame:true,
        autoWidth:true,
        border:false,
        labelWidth: 150,
        width:600,
        items:[
            this.tabpanelfiltro
        ]
    });

    this.win = new Ext.Window({
        title:'Parametros de busqueda',
        iconCls: 'icon-buscar',
        width:614,
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
                     NominaPeriodoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    NominaPeriodoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    NominaPeriodoFiltro.main.win.close();
                    NominaPeriodoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    NominaPeriodoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    NominaPeriodoFiltro.main.panelfiltro.getForm().reset();
    NominaPeriodoLista.main.store_lista.baseParams={}
    NominaPeriodoLista.main.store_lista.baseParams.paginar = 'si';
    NominaPeriodoLista.main.store_lista.baseParams.co_solicitud=NominaPeriodoLista.main.OBJ.co_solicitud;
    NominaPeriodoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = NominaPeriodoFiltro.main.panelfiltro.getForm().getValues();
    NominaPeriodoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("NominaPeriodoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        NominaPeriodoLista.main.store_lista.baseParams.paginar = 'si';
        NominaPeriodoLista.main.store_lista.baseParams.BuscarBy = true;
        NominaPeriodoLista.main.store_lista.baseParams.co_solicitud=NominaPeriodoLista.main.OBJ.co_solicitud;
        NominaPeriodoLista.main.store_lista.load();


}
,getStoreCO_TP_NOMINA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/storefkcotpnomina',
        root:'data',
        fields:[
            {name: 'co_tp_nomina'},{name: 'tx_tp_nomina'},
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
,getStoreCO_NOM_FRECUENCIA_PAGO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/storefkconomfrecuenciapago',
        root:'data',
        fields:[
            {name: 'co_nom_frecuencia_pago'},{name: 'tx_nom_frecuencia_pago'}
            ]
    });
    return this.store;
}

};

Ext.onReady(NominaPeriodoFiltro.main.init,NominaPeriodoFiltro.main);
</script>