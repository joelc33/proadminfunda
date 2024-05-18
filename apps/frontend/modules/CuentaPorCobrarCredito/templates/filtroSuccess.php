<script type="text/javascript">
Ext.ns("CuentaPorCobrarCreditoFiltro");
CuentaPorCobrarCreditoFiltro.main = {
init:function(){

//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>



this.co_solicitud = new Ext.form.NumberField({
	fieldLabel:'Co solicitud',
	name:'co_solicitud',
	value:''
});

this.co_usuario = new Ext.form.NumberField({
	fieldLabel:'Co usuario',
	name:'co_usuario',
	value:''
});

this.co_proveedor = new Ext.form.NumberField({
	fieldLabel:'Co proveedor',
	name:'co_proveedor',
	value:''
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

this.de_soporte = new Ext.form.TextField({
	fieldLabel:'De soporte',
	name:'de_soporte',
	value:''
});

this.id_tb143_cuenta_concepto = new Ext.form.ComboBox({
	fieldLabel:'Id tb143 cuenta concepto',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'id_tb143_cuenta_concepto',
	//readOnly:(this.OBJ.id_tb143_cuenta_concepto!='')?true:false,
	//style:(this.main.OBJ.id_tb143_cuenta_concepto!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb143_cuenta_concepto',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.id_tb144_clase_ingreso = new Ext.form.ComboBox({
	fieldLabel:'Id tb144 clase ingreso',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'id_tb144_clase_ingreso',
	//readOnly:(this.OBJ.id_tb144_clase_ingreso!='')?true:false,
	//style:(this.main.OBJ.id_tb144_clase_ingreso!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb144_clase_ingreso',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.de_descripcion = new Ext.form.TextField({
	fieldLabel:'De descripcion',
	name:'de_descripcion',
	value:''
});

this.mo_cuenta = new Ext.form.NumberField({
	fieldLabel:'Mo cuenta',
name:'mo_cuenta',
	value:''
});

this.fe_documento = new Ext.form.DateField({
	fieldLabel:'Fe documento',
	name:'fe_documento'
});

this.id_tb141_tipo_cuota = new Ext.form.ComboBox({
	fieldLabel:'Id tb141 tipo cuota',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'id_tb141_tipo_cuota',
	//readOnly:(this.OBJ.id_tb141_tipo_cuota!='')?true:false,
	//style:(this.main.OBJ.id_tb141_tipo_cuota!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb141_tipo_cuota',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_solicitud,
                                                                                this.co_usuario,
                                                                                this.co_proveedor,
                                                                                this.in_activo,
                                                                                this.created_at,
                                                                                this.updated_at,
                                                                                this.de_soporte,
                                                                                this.id_tb143_cuenta_concepto,
                                                                                this.id_tb144_clase_ingreso,
                                                                                this.de_descripcion,
                                                                                this.mo_cuenta,
                                                                                this.fe_documento,
                                                                                this.id_tb141_tipo_cuota,
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
                     CuentaPorCobrarCreditoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    CuentaPorCobrarCreditoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    CuentaPorCobrarCreditoFiltro.main.win.close();
                    CuentaPorCobrarCreditoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    CuentaPorCobrarCreditoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    CuentaPorCobrarCreditoFiltro.main.panelfiltro.getForm().reset();
    CuentaPorCobrarCreditoLista.main.store_lista.baseParams={}
    CuentaPorCobrarCreditoLista.main.store_lista.baseParams.paginar = 'si';
    CuentaPorCobrarCreditoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = CuentaPorCobrarCreditoFiltro.main.panelfiltro.getForm().getValues();
    CuentaPorCobrarCreditoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("CuentaPorCobrarCreditoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        CuentaPorCobrarCreditoLista.main.store_lista.baseParams.paginar = 'si';
        CuentaPorCobrarCreditoLista.main.store_lista.baseParams.BuscarBy = true;
        CuentaPorCobrarCreditoLista.main.store_lista.load();


}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrarCredito/storefkidtb143cuentaconcepto',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrarCredito/storefkidtb144claseingreso',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrarCredito/storefkidtb141tipocuota',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}

};

Ext.onReady(CuentaPorCobrarCreditoFiltro.main.init,CuentaPorCobrarCreditoFiltro.main);
</script>