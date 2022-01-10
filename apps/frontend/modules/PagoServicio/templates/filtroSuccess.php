<script type="text/javascript">
Ext.ns("PagoServicioFiltro");
PagoServicioFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_SOLICITUD = this.getStoreCO_SOLICITUD();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TIPO_SERVICIO = this.getStoreCO_TIPO_SERVICIO();
//<Stores de fk>



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

this.co_tipo_servicio = new Ext.form.ComboBox({
	fieldLabel:'Co tipo servicio',
	store: this.storeCO_TIPO_SERVICIO,
	typeAhead: true,
	valueField: 'co_tipo_servicio',
	displayField:'co_tipo_servicio',
	hiddenName:'co_tipo_servicio',
	//readOnly:(this.OBJ.co_tipo_servicio!='')?true:false,
	//style:(this.main.OBJ.co_tipo_servicio!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tipo_servicio',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_SERVICIO.load();

this.nu_factura = new Ext.form.TextField({
	fieldLabel:'Nu factura',
	name:'nu_factura',
	value:''
});

this.nu_control = new Ext.form.TextField({
	fieldLabel:'Nu control',
	name:'nu_control',
	value:''
});

this.mo_factura = new Ext.form.NumberField({
	fieldLabel:'Mo factura',
name:'mo_factura',
	value:''
});

this.fe_desde = new Ext.form.DateField({
	fieldLabel:'Fe desde',
	name:'fe_desde'
});

this.fe_hasta = new Ext.form.DateField({
	fieldLabel:'Fe hasta',
	name:'fe_hasta'
});

this.tx_observacion = new Ext.form.TextField({
	fieldLabel:'Tx observacion',
	name:'tx_observacion',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_solicitud,
                                                                                this.co_tipo_servicio,
                                                                                this.nu_factura,
                                                                                this.nu_control,
                                                                                this.mo_factura,
                                                                                this.fe_desde,
                                                                                this.fe_hasta,
                                                                                this.tx_observacion,
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
                     PagoServicioFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    PagoServicioFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    PagoServicioFiltro.main.win.close();
                    PagoServicioLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    PagoServicioLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    PagoServicioFiltro.main.panelfiltro.getForm().reset();
    PagoServicioLista.main.store_lista.baseParams={}
    PagoServicioLista.main.store_lista.baseParams.paginar = 'si';
    PagoServicioLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = PagoServicioFiltro.main.panelfiltro.getForm().getValues();
    PagoServicioLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("PagoServicioLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        PagoServicioLista.main.store_lista.baseParams.paginar = 'si';
        PagoServicioLista.main.store_lista.baseParams.BuscarBy = true;
        PagoServicioLista.main.store_lista.load();


}
,getStoreCO_SOLICITUD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoServicio/storefkcosolicitud',
        root:'data',
        fields:[
            {name: 'co_solicitud'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_SERVICIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoServicio/storefkcotiposervicio',
        root:'data',
        fields:[
            {name: 'co_tipo_servicio'}
            ]
    });
    return this.store;
}

};

Ext.onReady(PagoServicioFiltro.main.init,PagoServicioFiltro.main);
</script>