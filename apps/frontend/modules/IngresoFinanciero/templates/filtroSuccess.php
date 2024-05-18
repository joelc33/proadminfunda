<script type="text/javascript">
Ext.ns("IngresoFinancieroFiltro");
IngresoFinancieroFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_CUENTA_BANCARIA = this.getStoreCO_CUENTA_BANCARIA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_BANCO = this.getStoreCO_BANCO();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>



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

this.id_tb011_cuenta_bancaria = new Ext.form.ComboBox({
	fieldLabel:'Id tb011 cuenta bancaria',
	store: this.storeCO_CUENTA_BANCARIA,
	typeAhead: true,
	valueField: 'co_cuenta_bancaria',
	displayField:'co_cuenta_bancaria',
	hiddenName:'id_tb011_cuenta_bancaria',
	//readOnly:(this.OBJ.id_tb011_cuenta_bancaria!='')?true:false,
	//style:(this.main.OBJ.id_tb011_cuenta_bancaria!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb011_cuenta_bancaria',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_CUENTA_BANCARIA.load();

this.mo_transaccion = new Ext.form.NumberField({
	fieldLabel:'Mo transaccion',
name:'mo_transaccion',
	value:''
});

this.fe_transaccion = new Ext.form.DateField({
	fieldLabel:'Fe transaccion',
	name:'fe_transaccion'
});

this.mo_saldo_nuevo = new Ext.form.NumberField({
	fieldLabel:'Mo saldo nuevo',
name:'mo_saldo_nuevo',
	value:''
});

this.de_observacion = new Ext.form.TextField({
	fieldLabel:'De observacion',
	name:'de_observacion',
	value:''
});

this.id_tb010_banco = new Ext.form.ComboBox({
	fieldLabel:'Id tb010 banco',
	store: this.storeCO_BANCO,
	typeAhead: true,
	valueField: 'co_banco',
	displayField:'co_banco',
	hiddenName:'id_tb010_banco',
	//readOnly:(this.OBJ.id_tb010_banco!='')?true:false,
	//style:(this.main.OBJ.id_tb010_banco!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb010_banco',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_BANCO.load();

this.id_tb154_tipo_cuenta_movimiento = new Ext.form.ComboBox({
	fieldLabel:'Id tb154 tipo cuenta movimiento',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'id_tb154_tipo_cuenta_movimiento',
	//readOnly:(this.OBJ.id_tb154_tipo_cuenta_movimiento!='')?true:false,
	//style:(this.main.OBJ.id_tb154_tipo_cuenta_movimiento!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb154_tipo_cuenta_movimiento',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.id_tb153_tipo_documento_cuenta = new Ext.form.NumberField({
	fieldLabel:'Id tb153 tipo documento cuenta',
	name:'id_tb153_tipo_documento_cuenta',
	value:''
});

this.id_tb156_subtipo_documento = new Ext.form.NumberField({
	fieldLabel:'Id tb156 subtipo documento',
	name:'id_tb156_subtipo_documento',
	value:''
});

this.nu_documento = new Ext.form.TextField({
	fieldLabel:'Nu documento',
	name:'nu_documento',
	value:''
});

this.mo_saldo_anterior = new Ext.form.NumberField({
	fieldLabel:'Mo saldo anterior',
name:'mo_saldo_anterior',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.in_activo,
                                                                                this.created_at,
                                                                                this.updated_at,
                                                                                this.id_tb011_cuenta_bancaria,
                                                                                this.mo_transaccion,
                                                                                this.fe_transaccion,
                                                                                this.mo_saldo_nuevo,
                                                                                this.de_observacion,
                                                                                this.id_tb010_banco,
                                                                                this.id_tb154_tipo_cuenta_movimiento,
                                                                                this.id_tb153_tipo_documento_cuenta,
                                                                                this.id_tb156_subtipo_documento,
                                                                                this.nu_documento,
                                                                                this.mo_saldo_anterior,
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
                     IngresoFinancieroFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    IngresoFinancieroFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    IngresoFinancieroFiltro.main.win.close();
                    IngresoFinancieroLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    IngresoFinancieroLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    IngresoFinancieroFiltro.main.panelfiltro.getForm().reset();
    IngresoFinancieroLista.main.store_lista.baseParams={}
    IngresoFinancieroLista.main.store_lista.baseParams.paginar = 'si';
    IngresoFinancieroLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = IngresoFinancieroFiltro.main.panelfiltro.getForm().getValues();
    IngresoFinancieroLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("IngresoFinancieroLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        IngresoFinancieroLista.main.store_lista.baseParams.paginar = 'si';
        IngresoFinancieroLista.main.store_lista.baseParams.BuscarBy = true;
        IngresoFinancieroLista.main.store_lista.load();


}
,getStoreCO_CUENTA_BANCARIA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/IngresoFinanciero/storefkidtb011cuentabancaria',
        root:'data',
        fields:[
            {name: 'co_cuenta_bancaria'}
            ]
    });
    return this.store;
}
,getStoreCO_BANCO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/IngresoFinanciero/storefkidtb010banco',
        root:'data',
        fields:[
            {name: 'co_banco'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/IngresoFinanciero/storefkidtb154tipocuentamovimiento',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}

};

Ext.onReady(IngresoFinancieroFiltro.main.init,IngresoFinancieroFiltro.main);
</script>