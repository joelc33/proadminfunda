<script type="text/javascript">
Ext.ns("FondoAvanceFiltro");
FondoAvanceFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_PROVEEDOR = this.getStoreCO_PROVEEDOR();
//<Stores de fk>
//<Stores de fk>
this.storeCO_SOLICITUD = this.getStoreCO_SOLICITUD();
//<Stores de fk>



this.co_proveedor = new Ext.form.ComboBox({
	fieldLabel:'Co proveedor',
	store: this.storeCO_PROVEEDOR,
	typeAhead: true,
	valueField: 'co_proveedor',
	displayField:'co_proveedor',
	hiddenName:'co_proveedor',
	//readOnly:(this.OBJ.co_proveedor!='')?true:false,
	//style:(this.main.OBJ.co_proveedor!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_proveedor',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_PROVEEDOR.load();

this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'Tx descripcion',
	name:'tx_descripcion',
	value:''
});

this.nu_cancelacion = new Ext.form.NumberField({
	fieldLabel:'Nu cancelacion',
name:'nu_cancelacion',
	value:''
});

this.fe_compromiso = new Ext.form.DateField({
	fieldLabel:'Fe compromiso',
	name:'fe_compromiso'
});

this.nu_monto = new Ext.form.NumberField({
	fieldLabel:'Nu monto',
name:'nu_monto',
	value:''
});

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

this.co_usuario = new Ext.form.NumberField({
	fieldLabel:'Co usuario',
	name:'co_usuario',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_proveedor,
                                                                                this.tx_descripcion,
                                                                                this.nu_cancelacion,
                                                                                this.fe_compromiso,
                                                                                this.nu_monto,
                                                                                this.co_solicitud,
                                                                                this.co_usuario,
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
                     FondoAvanceFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    FondoAvanceFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    FondoAvanceFiltro.main.win.close();
                    FondoAvanceLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    FondoAvanceLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    FondoAvanceFiltro.main.panelfiltro.getForm().reset();
    FondoAvanceLista.main.store_lista.baseParams={}
    FondoAvanceLista.main.store_lista.baseParams.paginar = 'si';
    FondoAvanceLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = FondoAvanceFiltro.main.panelfiltro.getForm().getValues();
    FondoAvanceLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("FondoAvanceLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        FondoAvanceLista.main.store_lista.baseParams.paginar = 'si';
        FondoAvanceLista.main.store_lista.baseParams.BuscarBy = true;
        FondoAvanceLista.main.store_lista.load();


}
,getStoreCO_PROVEEDOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoAvance/storefkcoproveedor',
        root:'data',
        fields:[
            {name: 'co_proveedor'}
            ]
    });
    return this.store;
}
,getStoreCO_SOLICITUD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoAvance/storefkcosolicitud',
        root:'data',
        fields:[
            {name: 'co_solicitud'}
            ]
    });
    return this.store;
}

};

Ext.onReady(FondoAvanceFiltro.main.init,FondoAvanceFiltro.main);
</script>