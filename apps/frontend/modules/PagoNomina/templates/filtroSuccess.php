<script type="text/javascript">
Ext.ns("PagoNominaFiltro");
PagoNominaFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_TIPO_TRABAJADOR = this.getStoreCO_TIPO_TRABAJADOR();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TIPO_NOMINA = this.getStoreCO_TIPO_NOMINA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_SOLICITUD = this.getStoreCO_SOLICITUD();
//<Stores de fk>
//<Stores de fk>
this.storeCO_USUARIO = this.getStoreCO_USUARIO();
//<Stores de fk>



this.co_tipo_trabajador = new Ext.form.ComboBox({
	fieldLabel:'Co tipo trabajador',
	store: this.storeCO_TIPO_TRABAJADOR,
	typeAhead: true,
	valueField: 'co_tipo_trabajador',
	displayField:'co_tipo_trabajador',
	hiddenName:'co_tipo_trabajador',
	//readOnly:(this.OBJ.co_tipo_trabajador!='')?true:false,
	//style:(this.main.OBJ.co_tipo_trabajador!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tipo_trabajador',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_TRABAJADOR.load();

this.co_tipo_nomina = new Ext.form.ComboBox({
	fieldLabel:'Co tipo nomina',
	store: this.storeCO_TIPO_NOMINA,
	typeAhead: true,
	valueField: 'co_tipo_nomina',
	displayField:'co_tipo_nomina',
	hiddenName:'co_tipo_nomina',
	//readOnly:(this.OBJ.co_tipo_nomina!='')?true:false,
	//style:(this.main.OBJ.co_tipo_nomina!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tipo_nomina',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_NOMINA.load();

this.tx_concepto = new Ext.form.TextField({
	fieldLabel:'Tx concepto',
	name:'tx_concepto',
	value:''
});

this.fe_pago = new Ext.form.DateField({
	fieldLabel:'Fe pago',
	name:'fe_pago'
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

this.co_usuario = new Ext.form.ComboBox({
	fieldLabel:'Co usuario',
	store: this.storeCO_USUARIO,
	typeAhead: true,
	valueField: 'co_usuario',
	displayField:'co_usuario',
	hiddenName:'co_usuario',
	//readOnly:(this.OBJ.co_usuario!='')?true:false,
	//style:(this.main.OBJ.co_usuario!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_usuario',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_USUARIO.load();

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'created_at'
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_tipo_trabajador,
                                                                                this.co_tipo_nomina,
                                                                                this.tx_concepto,
                                                                                this.fe_pago,
                                                                                this.co_solicitud,
                                                                                this.co_usuario,
                                                                                this.created_at,
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
                     PagoNominaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    PagoNominaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    PagoNominaFiltro.main.win.close();
                    PagoNominaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    PagoNominaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    PagoNominaFiltro.main.panelfiltro.getForm().reset();
    PagoNominaLista.main.store_lista.baseParams={}
    PagoNominaLista.main.store_lista.baseParams.paginar = 'si';
    PagoNominaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = PagoNominaFiltro.main.panelfiltro.getForm().getValues();
    PagoNominaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("PagoNominaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        PagoNominaLista.main.store_lista.baseParams.paginar = 'si';
        PagoNominaLista.main.store_lista.baseParams.BuscarBy = true;
        PagoNominaLista.main.store_lista.load();


}
,getStoreCO_TIPO_TRABAJADOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/storefkcotipotrabajador',
        root:'data',
        fields:[
            {name: 'co_tipo_trabajador'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_NOMINA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/storefkcotiponomina',
        root:'data',
        fields:[
            {name: 'co_tipo_nomina'}
            ]
    });
    return this.store;
}
,getStoreCO_SOLICITUD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/storefkcosolicitud',
        root:'data',
        fields:[
            {name: 'co_solicitud'}
            ]
    });
    return this.store;
}
,getStoreCO_USUARIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/storefkcousuario',
        root:'data',
        fields:[
            {name: 'co_usuario'}
            ]
    });
    return this.store;
}

};

Ext.onReady(PagoNominaFiltro.main.init,PagoNominaFiltro.main);
</script>