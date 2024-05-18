<script type="text/javascript">
Ext.ns("RetencionesFiltro");
RetencionesFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_RAMO = this.getStoreCO_RAMO();
//<Stores de fk>



this.co_documento = new Ext.form.ComboBox({
	fieldLabel:'Co documento',
	store: this.storeCO_DOCUMENTO,
	typeAhead: true,
	valueField: 'co_documento',
	displayField:'co_documento',
	hiddenName:'co_documento',
	//readOnly:(this.OBJ.co_documento!='')?true:false,
	//style:(this.main.OBJ.co_documento!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_documento',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_DOCUMENTO.load();

this.co_tipo_retencion = new Ext.form.NumberField({
	fieldLabel:'Co tipo retencion',
	name:'co_tipo_retencion',
	value:''
});

this.nu_valor = new Ext.form.NumberField({
	fieldLabel:'Nu valor',
name:'nu_valor',
	value:''
});

this.nu_sustraendo = new Ext.form.NumberField({
	fieldLabel:'Nu sustraendo',
name:'nu_sustraendo',
	value:''
});

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

this.mo_minimo = new Ext.form.NumberField({
	fieldLabel:'Mo minimo',
name:'mo_minimo',
	value:''
});

this.de_concepto = new Ext.form.TextField({
	fieldLabel:'De concepto',
	name:'de_concepto',
	value:''
});

this.nu_concepto = new Ext.form.TextField({
	fieldLabel:'Nu concepto',
	name:'nu_concepto',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_documento,
                                                                                this.co_tipo_retencion,
                                                                                this.nu_valor,
                                                                                this.nu_sustraendo,
                                                                                this.co_ramo,
                                                                                this.mo_minimo,
                                                                                this.de_concepto,
                                                                                this.nu_concepto,
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
                     RetencionesFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    RetencionesFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    RetencionesFiltro.main.win.close();
                    RetencionesLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    RetencionesLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    RetencionesFiltro.main.panelfiltro.getForm().reset();
    RetencionesLista.main.store_lista.baseParams={}
    RetencionesLista.main.store_lista.baseParams.paginar = 'si';
    RetencionesLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = RetencionesFiltro.main.panelfiltro.getForm().getValues();
    RetencionesLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("RetencionesLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        RetencionesLista.main.store_lista.baseParams.paginar = 'si';
        RetencionesLista.main.store_lista.baseParams.BuscarBy = true;
        RetencionesLista.main.store_lista.load();


}
,getStoreCO_DOCUMENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Retenciones/storefkcodocumento',
        root:'data',
        fields:[
            {name: 'co_documento'}
            ]
    });
    return this.store;
}
,getStoreCO_RAMO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Retenciones/storefkcoramo',
        root:'data',
        fields:[
            {name: 'co_ramo'}
            ]
    });
    return this.store;
}

};

Ext.onReady(RetencionesFiltro.main.init,RetencionesFiltro.main);
</script>