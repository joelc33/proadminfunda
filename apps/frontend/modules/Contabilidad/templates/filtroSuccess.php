<script type="text/javascript">
Ext.ns("ContabilidadFiltro");
ContabilidadFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_COMPRAS = this.getStoreCO_COMPRAS();
//<Stores de fk>
//<Stores de fk>
this.storeCO_SOLICITUD = this.getStoreCO_SOLICITUD();
//<Stores de fk>
//<Stores de fk>
this.storeCO_RAMO = this.getStoreCO_RAMO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_ANIO_FISCAL = this.getStoreCO_ANIO_FISCAL();
//<Stores de fk>



this.co_compra = new Ext.form.ComboBox({
	fieldLabel:'Co compra',
	store: this.storeCO_COMPRAS,
	typeAhead: true,
	valueField: 'co_compras',
	displayField:'co_compras',
	hiddenName:'co_compra',
	//readOnly:(this.OBJ.co_compra!='')?true:false,
	//style:(this.main.OBJ.co_compra!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_compra',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_COMPRAS.load();

this.co_solicitud = new Ext.form.ComboBox({
	fieldLabel:'Co solicitud',
	store: this.storeCO_SOLICITUD,
	typeAhead: true,
	valueField: 'co_solicitud',
	displayField:'co_solicitud',
	hiddenName:'co_solicitud',
	//readOnly:(this.OBJ.co_solicitud!='')?true:false,
	//style:(this.main.OBJ.co_solicitud!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_solicitud',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_SOLICITUD.load();

this.co_ramo = new Ext.form.ComboBox({
	fieldLabel:'Co ramo',
	store: this.storeCO_RAMO,
	typeAhead: true,
	valueField: 'co_ramo',
	displayField:'co_ramo',
	hiddenName:'co_ramo',
	//readOnly:(this.OBJ.co_ramo!='')?true:false,
	//style:(this.main.OBJ.co_ramo!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_ramo',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_RAMO.load();

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'created_at'
});

this.co_anio_fiscal = new Ext.form.ComboBox({
	fieldLabel:'Co anio fiscal',
	store: this.storeCO_ANIO_FISCAL,
	typeAhead: true,
	valueField: 'co_anio_fiscal',
	displayField:'co_anio_fiscal',
	hiddenName:'co_anio_fiscal',
	//readOnly:(this.OBJ.co_anio_fiscal!='')?true:false,
	//style:(this.main.OBJ.co_anio_fiscal!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_anio_fiscal',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_ANIO_FISCAL.load();

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_compra,
                                                                                this.co_solicitud,
                                                                                this.co_ramo,
                                                                                this.created_at,
                                                                                this.co_anio_fiscal,
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
                     ContabilidadFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ContabilidadFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ContabilidadFiltro.main.win.close();
                    ContabilidadLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ContabilidadLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ContabilidadFiltro.main.panelfiltro.getForm().reset();
    ContabilidadLista.main.store_lista.baseParams={}
    ContabilidadLista.main.store_lista.baseParams.paginar = 'si';
    ContabilidadLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ContabilidadFiltro.main.panelfiltro.getForm().getValues();
    ContabilidadLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ContabilidadLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ContabilidadLista.main.store_lista.baseParams.paginar = 'si';
        ContabilidadLista.main.store_lista.baseParams.BuscarBy = true;
        ContabilidadLista.main.store_lista.load();


}
,getStoreCO_COMPRAS:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/storefkcocompra',
        root:'data',
        fields:[
            {name: 'co_compras'}
            ]
    });
    return this.store;
}
,getStoreCO_SOLICITUD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/storefkcosolicitud',
        root:'data',
        fields:[
            {name: 'co_solicitud'}
            ]
    });
    return this.store;
}
,getStoreCO_RAMO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/storefkcoramo',
        root:'data',
        fields:[
            {name: 'co_ramo'}
            ]
    });
    return this.store;
}
,getStoreCO_ANIO_FISCAL:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/storefkcoaniofiscal',
        root:'data',
        fields:[
            {name: 'co_anio_fiscal'}
            ]
    });
    return this.store;
}

};

Ext.onReady(ContabilidadFiltro.main.init,ContabilidadFiltro.main);
</script>