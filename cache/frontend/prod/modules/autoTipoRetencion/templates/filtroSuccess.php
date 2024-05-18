<script type="text/javascript">
Ext.ns("TipoRetencionFiltro");
TipoRetencionFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_CUENTA_CONTABLE = this.getStoreCO_CUENTA_CONTABLE();
//<Stores de fk>



this.tx_tipo_retencion = new Ext.form.TextField({
	fieldLabel:'Tx tipo retencion',
	name:'tx_tipo_retencion',
	value:''
});

this.co_cuenta_contable = new Ext.form.ComboBox({
	fieldLabel:'Co cuenta contable',
	store: this.storeCO_CUENTA_CONTABLE,
	typeAhead: true,
	valueField: 'co_cuenta_contable',
	displayField:'co_cuenta_contable',
	hiddenName:'co_cuenta_contable',
	//readOnly:(this.OBJ.co_cuenta_contable!='')?true:false,
	//style:(this.main.OBJ.co_cuenta_contable!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_cuenta_contable',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_CUENTA_CONTABLE.load();

this.co_clase_retencion = new Ext.form.NumberField({
	fieldLabel:'Co clase retencion',
	name:'co_clase_retencion',
	value:''
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'in_activo',
	checked:true
});

this.nu_cuenta_pagar = new Ext.form.TextField({
	fieldLabel:'Nu cuenta pagar',
	name:'nu_cuenta_pagar',
	value:''
});

this.nu_cuenta_tercero = new Ext.form.TextField({
	fieldLabel:'Nu cuenta tercero',
	name:'nu_cuenta_tercero',
	value:''
});

this.co_cuenta_tercero = new Ext.form.NumberField({
	fieldLabel:'Co cuenta tercero',
	name:'co_cuenta_tercero',
	value:''
});

this.tx_movimiento = new Ext.form.TextField({
	fieldLabel:'Tx movimiento',
	name:'tx_movimiento',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.tx_tipo_retencion,
                                                                                this.co_cuenta_contable,
                                                                                this.co_clase_retencion,
                                                                                this.in_activo,
                                                                                this.nu_cuenta_pagar,
                                                                                this.nu_cuenta_tercero,
                                                                                this.co_cuenta_tercero,
                                                                                this.tx_movimiento,
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
                     TipoRetencionFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    TipoRetencionFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    TipoRetencionFiltro.main.win.close();
                    TipoRetencionLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    TipoRetencionLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    TipoRetencionFiltro.main.panelfiltro.getForm().reset();
    TipoRetencionLista.main.store_lista.baseParams={}
    TipoRetencionLista.main.store_lista.baseParams.paginar = 'si';
    TipoRetencionLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = TipoRetencionFiltro.main.panelfiltro.getForm().getValues();
    TipoRetencionLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("TipoRetencionLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        TipoRetencionLista.main.store_lista.baseParams.paginar = 'si';
        TipoRetencionLista.main.store_lista.baseParams.BuscarBy = true;
        TipoRetencionLista.main.store_lista.load();


}
,getStoreCO_CUENTA_CONTABLE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TipoRetencion/storefkcocuentacontable',
        root:'data',
        fields:[
            {name: 'co_cuenta_contable'}
            ]
    });
    return this.store;
}

};

Ext.onReady(TipoRetencionFiltro.main.init,TipoRetencionFiltro.main);
</script>