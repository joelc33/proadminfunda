<script type="text/javascript">
Ext.ns("consignacionChequeFiltro");
consignacionChequeFiltro.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_BANCO = this.getStoreCO_BANCO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CUENTA_BANCARIA = this.getStoreCO_CUENTA_BANCARIA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CHEQUERA = this.getStoreCO_CHEQUERA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CHEQUE = this.getStoreCO_CHEQUE();
//<Stores de fk>



this.co_solicitud = new Ext.form.NumberField({
	fieldLabel:'Co solicitud',
	name:'co_solicitud',
	value:''
});

this.co_banco = new Ext.form.ComboBox({
	fieldLabel:'Banco',
	store: this.storeCO_BANCO,
	typeAhead: true,
	valueField: 'co_banco',
	displayField:'tx_banco',
	hiddenName:'co_banco',
	//readOnly:(this.OBJ.co_banco!='')?true:false,
	//style:(this.main.OBJ.co_banco!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Banco',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false,
    onSelect: function(record){
		consignacionChequeFiltro.main.co_cuenta_bancaria.clearValue();
		consignacionChequeFiltro.main.co_chequera.clearValue();
		consignacionChequeFiltro.main.co_cheque.clearValue();
        consignacionChequeFiltro.main.co_banco.setValue(record.data.co_banco);
		consignacionChequeFiltro.main.storeCO_CUENTA_BANCARIA.load({
			params: {
				co_banco:record.data.co_banco
			}
		});
        this.collapse();
    }
});
this.storeCO_BANCO.load();

this.co_cuenta_bancaria = new Ext.form.ComboBox({
	fieldLabel:'Cuenta Bancaria',
	store: this.storeCO_CUENTA_BANCARIA,
	typeAhead: true,
	valueField: 'co_cuenta_bancaria',
	displayField:'tx_cuenta_bancaria',
	hiddenName:'co_cuenta_bancaria',
	//readOnly:(this.OBJ.co_cuenta_bancaria!='')?true:false,
	//style:(this.main.OBJ.co_cuenta_bancaria!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Cuenta Bancaria',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false,
    onSelect: function(record){
		consignacionChequeFiltro.main.co_chequera.clearValue();
		consignacionChequeFiltro.main.co_cheque.clearValue();
        consignacionChequeFiltro.main.co_cuenta_bancaria.setValue(record.data.co_cuenta_bancaria);
		consignacionChequeFiltro.main.storeCO_CHEQUERA.load({
			params: {
				co_cuenta_bancaria:record.data.co_cuenta_bancaria
			}
		});
        this.collapse();
    }
});
//this.storeCO_CUENTA_BANCARIA.load();

this.co_chequera = new Ext.form.ComboBox({
	fieldLabel:'Chequera',
	store: this.storeCO_CHEQUERA,
	typeAhead: true,
	valueField: 'co_chequera',
	displayField:'chequera',
	hiddenName:'co_chequera',
	//readOnly:(this.OBJ.co_chequera!='')?true:false,
	//style:(this.main.OBJ.co_chequera!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Chequera',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
//this.storeCO_CHEQUERA.load();

this.co_cheque = new Ext.form.ComboBox({
	fieldLabel:'Co cheque',
	store: this.storeCO_CHEQUE,
	typeAhead: true,
	valueField: 'co_cheque',
	displayField:'co_cheque',
	hiddenName:'co_cheque',
	//readOnly:(this.OBJ.co_cheque!='')?true:false,
	//style:(this.main.OBJ.co_cheque!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_cheque',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
//this.storeCO_CHEQUE.load();

this.nb_titular = new Ext.form.TextField({
	fieldLabel:'Nb titular',
	name:'nb_titular',
	value:''
});

this.mo_cheque = new Ext.form.NumberField({
	fieldLabel:'Mo cheque',
name:'mo_cheque',
	value:''
});

this.fe_pago = new Ext.form.DateField({
	fieldLabel:'Fecha',
	name:'fe_pago'
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'created_at'
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'updated_at'
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                //this.co_solicitud,
                                                                                this.co_banco,
                                                                                this.co_cuenta_bancaria,
                                                                                this.co_chequera,
                                                                                //this.co_cheque,
                                                                                this.fe_pago,
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
                     consignacionChequeFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    consignacionChequeFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    consignacionChequeFiltro.main.win.close();
                    consignacionChequeLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    consignacionChequeLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    consignacionChequeFiltro.main.panelfiltro.getForm().reset();
    consignacionChequeLista.main.store_lista.baseParams={}
    consignacionChequeLista.main.store_lista.baseParams.paginar = 'si';
    consignacionChequeLista.main.store_lista.baseParams.co_solicitud=consignacionChequeLista.main.OBJ.co_solicitud;
    consignacionChequeLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = consignacionChequeFiltro.main.panelfiltro.getForm().getValues();
    consignacionChequeLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("consignacionChequeLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        consignacionChequeLista.main.store_lista.baseParams.paginar = 'si';
        consignacionChequeLista.main.store_lista.baseParams.BuscarBy = true;
        consignacionChequeLista.main.store_lista.baseParams.co_solicitud=consignacionChequeLista.main.OBJ.co_solicitud;
        consignacionChequeLista.main.store_lista.load();


}
,getStoreCO_BANCO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/consignacionCheque/storefkcobanco',
        root:'data',
        fields:[
            {name: 'co_banco'},
            {name: 'tx_banco'}
            ]
    });
    return this.store;
}
,getStoreCO_CUENTA_BANCARIA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/consignacionCheque/storefkcocuentabancaria',
        root:'data',
        fields:[
            {name: 'co_cuenta_bancaria'},
            {name: 'tx_cuenta_bancaria'}
            ]
    });
    return this.store;
}
,getStoreCO_CHEQUERA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/consignacionCheque/storefkcochequera',
        root:'data',
        fields:[
            {name: 'co_chequera'},
            {name: 'tx_descripcion'},
			{
				name: 'chequera',
				convert: function(v, r) {
						return r.tx_descripcion + ' ( ' + r.nro_inicial + ' - ' + r.nro_final + ' ) ';
				}
			},
            ]
    });
    return this.store;
}
,getStoreCO_CHEQUE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/consignacionCheque/storefkcocheque',
        root:'data',
        fields:[
            {name: 'co_cheque'}
            ]
    });
    return this.store;
}

};

Ext.onReady(consignacionChequeFiltro.main.init,consignacionChequeFiltro.main);
</script>