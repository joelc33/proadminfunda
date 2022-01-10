<script type="text/javascript">
Ext.ns("CuentaBancariaFiltro");
CuentaBancariaFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_BANCO = this.getStoreCO_BANCO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TIPO_CUENTA = this.getStoreCO_TIPO_CUENTA();
//<Stores de fk>



this.tx_cuenta_bancaria = new Ext.form.TextField({
	fieldLabel:'Tx cuenta bancaria',
	name:'tx_cuenta_bancaria',
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

this.co_tipo_cuenta = new Ext.form.ComboBox({
	fieldLabel:'Co tipo cuenta',
	store: this.storeCO_TIPO_CUENTA,
	typeAhead: true,
	valueField: 'co_tipo_cuenta',
	displayField:'co_tipo_cuenta',
	hiddenName:'co_tipo_cuenta',
	//readOnly:(this.OBJ.co_tipo_cuenta!='')?true:false,
	//style:(this.main.OBJ.co_tipo_cuenta!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tipo_cuenta',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_CUENTA.load();

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.tx_cuenta_bancaria,
                                                                                this.co_banco,
                                                                                this.co_tipo_cuenta,
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
                     CuentaBancariaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    CuentaBancariaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    CuentaBancariaFiltro.main.win.close();
                    CuentaBancariaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    CuentaBancariaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    CuentaBancariaFiltro.main.panelfiltro.getForm().reset();
    CuentaBancariaLista.main.store_lista.baseParams={}
    CuentaBancariaLista.main.store_lista.baseParams.paginar = 'si';
    CuentaBancariaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = CuentaBancariaFiltro.main.panelfiltro.getForm().getValues();
    CuentaBancariaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("CuentaBancariaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        CuentaBancariaLista.main.store_lista.baseParams.paginar = 'si';
        CuentaBancariaLista.main.store_lista.baseParams.BuscarBy = true;
        CuentaBancariaLista.main.store_lista.load();


}
,getStoreCO_BANCO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/storefkcobanco',
        root:'data',
        fields:[
            {name: 'co_banco'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_CUENTA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/storefkcotipocuenta',
        root:'data',
        fields:[
            {name: 'co_tipo_cuenta'}
            ]
    });
    return this.store;
}

};

Ext.onReady(CuentaBancariaFiltro.main.init,CuentaBancariaFiltro.main);
</script>