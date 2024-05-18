<script type="text/javascript">
Ext.ns("ProveedorFiltro");
ProveedorFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_CLASIFICACION = this.getStoreCO_CLASIFICACION();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CUENTA_CONTABLE = this.getStoreCO_CUENTA_CONTABLE();
//<Stores de fk>
//<Stores de fk>
this.storeCO_BANCO = this.getStoreCO_BANCO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TIPO_RESIDENCIA = this.getStoreCO_TIPO_RESIDENCIA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TIPO_PROVEEDOR = this.getStoreCO_TIPO_PROVEEDOR();
//<Stores de fk>
//<Stores de fk>
this.storeCO_IVA_RETENCION = this.getStoreCO_IVA_RETENCION();
//<Stores de fk>



this.tx_razon_social = new Ext.form.TextField({
	fieldLabel:'Tx razon social',
	name:'tx_razon_social',
	value:''
});

this.co_documento = new Ext.form.NumberField({
	fieldLabel:'Co documento',
	name:'co_documento',
	value:''
});

this.tx_siglas = new Ext.form.TextField({
	fieldLabel:'Tx siglas',
	name:'tx_siglas',
	value:''
});

this.tx_rif = new Ext.form.TextField({
	fieldLabel:'Tx rif',
	name:'tx_rif',
	value:''
});

this.tx_nit = new Ext.form.TextField({
	fieldLabel:'Tx nit',
	name:'tx_nit',
	value:''
});

this.tx_direccion = new Ext.form.TextField({
	fieldLabel:'Tx direccion',
	name:'tx_direccion',
	value:''
});

this.co_estado = new Ext.form.NumberField({
	fieldLabel:'Co estado',
	name:'co_estado',
	value:''
});

this.co_municipio = new Ext.form.NumberField({
	fieldLabel:'Co municipio',
	name:'co_municipio',
	value:''
});

this.co_clasificacion = new Ext.form.ComboBox({
	fieldLabel:'Co clasificacion',
	store: this.storeCO_CLASIFICACION,
	typeAhead: true,
	valueField: 'co_clasificacion',
	displayField:'co_clasificacion',
	hiddenName:'co_clasificacion',
	//readOnly:(this.OBJ.co_clasificacion!='')?true:false,
	//style:(this.main.OBJ.co_clasificacion!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_clasificacion',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_CLASIFICACION.load();

this.tx_email = new Ext.form.TextField({
	fieldLabel:'Tx email',
	name:'tx_email',
	value:''
});

this.tx_sitio_web = new Ext.form.TextField({
	fieldLabel:'Tx sitio web',
	name:'tx_sitio_web',
	value:''
});

this.nb_representante_legal = new Ext.form.TextField({
	fieldLabel:'Nb representante legal',
	name:'nb_representante_legal',
	value:''
});

this.nu_cedula_representante = new Ext.form.NumberField({
	fieldLabel:'Nu cedula representante',
name:'nu_cedula_representante',
	value:''
});

this.tx_num_celular = new Ext.form.TextField({
	fieldLabel:'Tx num celular',
	name:'tx_num_celular',
	value:''
});

this.nu_dia_credito = new Ext.form.NumberField({
	fieldLabel:'Nu dia credito',
name:'nu_dia_credito',
	value:''
});

this.fe_registro = new Ext.form.DateField({
	fieldLabel:'Fe registro',
	name:'fe_registro'
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

this.fe_vencimiento = new Ext.form.DateField({
	fieldLabel:'Fe vencimiento',
	name:'fe_vencimiento'
});

this.nu_cuenta_bancaria = new Ext.form.TextField({
	fieldLabel:'Nu cuenta bancaria',
	name:'nu_cuenta_bancaria',
	value:''
});

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

this.co_tipo_residencia = new Ext.form.ComboBox({
	fieldLabel:'Co tipo residencia',
	store: this.storeCO_TIPO_RESIDENCIA,
	typeAhead: true,
	valueField: 'co_tipo_residencia',
	displayField:'co_tipo_residencia',
	hiddenName:'co_tipo_residencia',
	//readOnly:(this.OBJ.co_tipo_residencia!='')?true:false,
	//style:(this.main.OBJ.co_tipo_residencia!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tipo_residencia',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_RESIDENCIA.load();

this.co_tipo_proveedor = new Ext.form.ComboBox({
	fieldLabel:'Co tipo proveedor',
	store: this.storeCO_TIPO_PROVEEDOR,
	typeAhead: true,
	valueField: 'co_tipo_proveedor',
	displayField:'co_tipo_proveedor',
	hiddenName:'co_tipo_proveedor',
	//readOnly:(this.OBJ.co_tipo_proveedor!='')?true:false,
	//style:(this.main.OBJ.co_tipo_proveedor!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tipo_proveedor',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_PROVEEDOR.load();

this.co_tipo_retencion = new Ext.form.NumberField({
	fieldLabel:'Co tipo retencion',
	name:'co_tipo_retencion',
	value:''
});

this.tx_registro = new Ext.form.TextField({
	fieldLabel:'Tx registro',
	name:'tx_registro',
	value:''
});

this.fe_registro_seniat = new Ext.form.DateField({
	fieldLabel:'Fe registro seniat',
	name:'fe_registro_seniat'
});

this.nu_registro = new Ext.form.NumberField({
	fieldLabel:'Nu registro',
name:'nu_registro',
	value:''
});

this.nu_tomo = new Ext.form.NumberField({
	fieldLabel:'Nu tomo',
name:'nu_tomo',
	value:''
});

this.nu_capital_suscrito = new Ext.form.NumberField({
	fieldLabel:'Nu capital suscrito',
name:'nu_capital_suscrito',
	value:''
});

this.nu_capital_pagado = new Ext.form.NumberField({
	fieldLabel:'Nu capital pagado',
name:'nu_capital_pagado',
	value:''
});

this.tx_observacion = new Ext.form.TextField({
	fieldLabel:'Tx observacion',
	name:'tx_observacion',
	value:''
});

this.co_iva_retencion = new Ext.form.ComboBox({
	fieldLabel:'Co iva retencion',
	store: this.storeCO_IVA_RETENCION,
	typeAhead: true,
	valueField: 'co_iva_retencion',
	displayField:'co_iva_retencion',
	hiddenName:'co_iva_retencion',
	//readOnly:(this.OBJ.co_iva_retencion!='')?true:false,
	//style:(this.main.OBJ.co_iva_retencion!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_iva_retencion',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_IVA_RETENCION.load();

this.tx_cuenta_contable = new Ext.form.TextField({
	fieldLabel:'Tx cuenta contable',
	name:'tx_cuenta_contable',
	value:''
});

this.nu_codigo = new Ext.form.TextField({
	fieldLabel:'Nu codigo',
	name:'nu_codigo',
	value:''
});

this.in_rrhh = new Ext.form.Checkbox({
	fieldLabel:'In rrhh',
	name:'in_rrhh',
	checked:true
});

this.co_cuenta_orden_pasivo = new Ext.form.NumberField({
	fieldLabel:'Co cuenta orden pasivo',
	name:'co_cuenta_orden_pasivo',
	value:''
});

this.co_cuenta_orden_activo = new Ext.form.NumberField({
	fieldLabel:'Co cuenta orden activo',
	name:'co_cuenta_orden_activo',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.tx_razon_social,
                                                                                this.co_documento,
                                                                                this.tx_siglas,
                                                                                this.tx_rif,
                                                                                this.tx_nit,
                                                                                this.tx_direccion,
                                                                                this.co_estado,
                                                                                this.co_municipio,
                                                                                this.co_clasificacion,
                                                                                this.tx_email,
                                                                                this.tx_sitio_web,
                                                                                this.nb_representante_legal,
                                                                                this.nu_cedula_representante,
                                                                                this.tx_num_celular,
                                                                                this.nu_dia_credito,
                                                                                this.fe_registro,
                                                                                this.co_cuenta_contable,
                                                                                this.fe_vencimiento,
                                                                                this.nu_cuenta_bancaria,
                                                                                this.co_banco,
                                                                                this.co_tipo_residencia,
                                                                                this.co_tipo_proveedor,
                                                                                this.co_tipo_retencion,
                                                                                this.tx_registro,
                                                                                this.fe_registro_seniat,
                                                                                this.nu_registro,
                                                                                this.nu_tomo,
                                                                                this.nu_capital_suscrito,
                                                                                this.nu_capital_pagado,
                                                                                this.tx_observacion,
                                                                                this.co_iva_retencion,
                                                                                this.tx_cuenta_contable,
                                                                                this.nu_codigo,
                                                                                this.in_rrhh,
                                                                                this.co_cuenta_orden_pasivo,
                                                                                this.co_cuenta_orden_activo,
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
                     ProveedorFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ProveedorFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ProveedorFiltro.main.win.close();
                    ProveedorLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ProveedorLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ProveedorFiltro.main.panelfiltro.getForm().reset();
    ProveedorLista.main.store_lista.baseParams={}
    ProveedorLista.main.store_lista.baseParams.paginar = 'si';
    ProveedorLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ProveedorFiltro.main.panelfiltro.getForm().getValues();
    ProveedorLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ProveedorLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ProveedorLista.main.store_lista.baseParams.paginar = 'si';
        ProveedorLista.main.store_lista.baseParams.BuscarBy = true;
        ProveedorLista.main.store_lista.load();


}
,getStoreCO_CLASIFICACION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcoclasificacion',
        root:'data',
        fields:[
            {name: 'co_clasificacion'}
            ]
    });
    return this.store;
}
,getStoreCO_CUENTA_CONTABLE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcocuentacontable',
        root:'data',
        fields:[
            {name: 'co_cuenta_contable'}
            ]
    });
    return this.store;
}
,getStoreCO_BANCO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcobanco',
        root:'data',
        fields:[
            {name: 'co_banco'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_RESIDENCIA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcotiporesidencia',
        root:'data',
        fields:[
            {name: 'co_tipo_residencia'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_PROVEEDOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcotipoproveedor',
        root:'data',
        fields:[
            {name: 'co_tipo_proveedor'}
            ]
    });
    return this.store;
}
,getStoreCO_IVA_RETENCION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcoivaretencion',
        root:'data',
        fields:[
            {name: 'co_iva_retencion'}
            ]
    });
    return this.store;
}

};

Ext.onReady(ProveedorFiltro.main.init,ProveedorFiltro.main);
</script>