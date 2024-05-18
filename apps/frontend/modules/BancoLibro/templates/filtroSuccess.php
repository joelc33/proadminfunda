<script type="text/javascript">
Ext.ns("BancoLibroFiltro");
BancoLibroFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_BANCO = this.getStoreCO_BANCO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CUENTA_BANCARIA = this.getStoreCO_CUENTA_BANCARIA();
//<Stores de fk>



this.nu_libro = new Ext.form.TextField({
	fieldLabel:'Nu libro',
	name:'nu_libro',
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

this.fe_desde = new Ext.form.DateField({
	fieldLabel:'Fe desde',
	name:'fe_desde'
});

this.fe_hasta = new Ext.form.DateField({
	fieldLabel:'Fe hasta',
	name:'fe_hasta'
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

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.nu_libro,
                                                                                this.id_tb010_banco,
                                                                                this.id_tb011_cuenta_bancaria,
                                                                                this.fe_desde,
                                                                                this.fe_hasta,
                                                                                this.in_activo,
                                                                                this.created_at,
                                                                                this.updated_at,
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
                     BancoLibroFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    BancoLibroFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    BancoLibroFiltro.main.win.close();
                    BancoLibroLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    BancoLibroLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    BancoLibroFiltro.main.panelfiltro.getForm().reset();
    BancoLibroLista.main.store_lista.baseParams={}
    BancoLibroLista.main.store_lista.baseParams.paginar = 'si';
    BancoLibroLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = BancoLibroFiltro.main.panelfiltro.getForm().getValues();
    BancoLibroLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("BancoLibroLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        BancoLibroLista.main.store_lista.baseParams.paginar = 'si';
        BancoLibroLista.main.store_lista.baseParams.BuscarBy = true;
        BancoLibroLista.main.store_lista.load();


}
,getStoreCO_BANCO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoLibro/storefkidtb010banco',
        root:'data',
        fields:[
            {name: 'co_banco'}
            ]
    });
    return this.store;
}
,getStoreCO_CUENTA_BANCARIA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoLibro/storefkidtb011cuentabancaria',
        root:'data',
        fields:[
            {name: 'co_cuenta_bancaria'}
            ]
    });
    return this.store;
}

};

Ext.onReady(BancoLibroFiltro.main.init,BancoLibroFiltro.main);
</script>