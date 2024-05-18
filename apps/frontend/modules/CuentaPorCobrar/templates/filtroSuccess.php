<script type="text/javascript">
Ext.ns("CuentaPorCobrarFiltro");
CuentaPorCobrarFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_FUENTE_INGRESO = this.getStoreCO_FUENTE_INGRESO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_SOLICITUD = this.getStoreCO_SOLICITUD();
//<Stores de fk>
//<Stores de fk>
this.storeCO_BANCO = this.getStoreCO_BANCO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CUENTA_BANCARIA = this.getStoreCO_CUENTA_BANCARIA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_USUARIO = this.getStoreCO_USUARIO();
//<Stores de fk>



this.co_fuente_ingreso = new Ext.form.ComboBox({
	fieldLabel:'Co fuente ingreso',
	store: this.storeCO_FUENTE_INGRESO,
	typeAhead: true,
	valueField: 'co_fuente_ingreso',
	displayField:'co_fuente_ingreso',
	hiddenName:'co_fuente_ingreso',
	//readOnly:(this.OBJ.co_fuente_ingreso!='')?true:false,
	//style:(this.main.OBJ.co_fuente_ingreso!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_fuente_ingreso',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_FUENTE_INGRESO.load();

this.tx_referencia = new Ext.form.TextField({
	fieldLabel:'Tx referencia',
	name:'tx_referencia',
	value:''
});

this.mo_ingreso = new Ext.form.NumberField({
	fieldLabel:'Mo ingreso',
name:'mo_ingreso',
	value:''
});

this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'Tx descripcion',
	name:'tx_descripcion',
	value:''
});

this.fe_registro = new Ext.form.DateField({
	fieldLabel:'Fe registro',
	name:'fe_registro'
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

this.co_banco = new Ext.form.ComboBox({
	fieldLabel:'Co banco',
	store: this.storeCO_BANCO,
	typeAhead: true,
	valueField: 'co_banco',
	displayField:'co_banco',
	hiddenName:'co_banco',
	//readOnly:(this.OBJ.co_banco!='')?true:false,
	//style:(this.main.OBJ.co_banco!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_banco',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_BANCO.load();

this.co_cuenta_bancaria = new Ext.form.ComboBox({
	fieldLabel:'Co cuenta bancaria',
	store: this.storeCO_CUENTA_BANCARIA,
	typeAhead: true,
	valueField: 'co_cuenta_bancaria',
	displayField:'co_cuenta_bancaria',
	hiddenName:'co_cuenta_bancaria',
	//readOnly:(this.OBJ.co_cuenta_bancaria!='')?true:false,
	//style:(this.main.OBJ.co_cuenta_bancaria!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_cuenta_bancaria',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_CUENTA_BANCARIA.load();

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'created_at'
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'updated_at'
});

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

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_fuente_ingreso,
                                                                                this.tx_referencia,
                                                                                this.mo_ingreso,
                                                                                this.tx_descripcion,
                                                                                this.fe_registro,
                                                                                this.co_solicitud,
                                                                                this.co_banco,
                                                                                this.co_cuenta_bancaria,
                                                                                this.created_at,
                                                                                this.updated_at,
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
                     CuentaPorCobrarFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    CuentaPorCobrarFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    CuentaPorCobrarFiltro.main.win.close();
                    CuentaPorCobrarLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    CuentaPorCobrarLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    CuentaPorCobrarFiltro.main.panelfiltro.getForm().reset();
    CuentaPorCobrarLista.main.store_lista.baseParams={}
    CuentaPorCobrarLista.main.store_lista.baseParams.paginar = 'si';
    CuentaPorCobrarLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = CuentaPorCobrarFiltro.main.panelfiltro.getForm().getValues();
    CuentaPorCobrarLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("CuentaPorCobrarLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        CuentaPorCobrarLista.main.store_lista.baseParams.paginar = 'si';
        CuentaPorCobrarLista.main.store_lista.baseParams.BuscarBy = true;
        CuentaPorCobrarLista.main.store_lista.load();


}
,getStoreCO_FUENTE_INGRESO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrar/storefkcofuenteingreso',
        root:'data',
        fields:[
            {name: 'co_fuente_ingreso'}
            ]
    });
    return this.store;
}
,getStoreCO_SOLICITUD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrar/storefkcosolicitud',
        root:'data',
        fields:[
            {name: 'co_solicitud'}
            ]
    });
    return this.store;
}
,getStoreCO_BANCO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrar/storefkcobanco',
        root:'data',
        fields:[
            {name: 'co_banco'}
            ]
    });
    return this.store;
}
,getStoreCO_CUENTA_BANCARIA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrar/storefkcocuentabancaria',
        root:'data',
        fields:[
            {name: 'co_cuenta_bancaria'}
            ]
    });
    return this.store;
}
,getStoreCO_USUARIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrar/storefkcousuario',
        root:'data',
        fields:[
            {name: 'co_usuario'}
            ]
    });
    return this.store;
}

};

Ext.onReady(CuentaPorCobrarFiltro.main.init,CuentaPorCobrarFiltro.main);
</script>