<script type="text/javascript">
Ext.ns("CuentaPorCobrarCreditoDetalleFiltro");
CuentaPorCobrarCreditoDetalleFiltro.main = {
init:function(){

//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>



this.id_tb142_cuenta_cobrar = new Ext.form.ComboBox({
	fieldLabel:'Id tb142 cuenta cobrar',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'id_tb142_cuenta_cobrar',
	//readOnly:(this.OBJ.id_tb142_cuenta_cobrar!='')?true:false,
	//style:(this.main.OBJ.id_tb142_cuenta_cobrar!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb142_cuenta_cobrar',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.de_cuota = new Ext.form.TextField({
	fieldLabel:'De cuota',
	name:'de_cuota',
	value:''
});

this.mo_cuota = new Ext.form.NumberField({
	fieldLabel:'Mo cuota',
name:'mo_cuota',
	value:''
});

this.fe_creacion = new Ext.form.DateField({
	fieldLabel:'Fe creacion',
	name:'fe_creacion'
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
                                                                                                            this.id_tb142_cuenta_cobrar,
                                                                                this.de_cuota,
                                                                                this.mo_cuota,
                                                                                this.fe_creacion,
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
                     CuentaPorCobrarCreditoDetalleFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    CuentaPorCobrarCreditoDetalleFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    CuentaPorCobrarCreditoDetalleFiltro.main.win.close();
                    CuentaPorCobrarCreditoDetalleLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    CuentaPorCobrarCreditoDetalleLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    CuentaPorCobrarCreditoDetalleFiltro.main.panelfiltro.getForm().reset();
    CuentaPorCobrarCreditoDetalleLista.main.store_lista.baseParams={}
    CuentaPorCobrarCreditoDetalleLista.main.store_lista.baseParams.paginar = 'si';
    CuentaPorCobrarCreditoDetalleLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = CuentaPorCobrarCreditoDetalleFiltro.main.panelfiltro.getForm().getValues();
    CuentaPorCobrarCreditoDetalleLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("CuentaPorCobrarCreditoDetalleLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        CuentaPorCobrarCreditoDetalleLista.main.store_lista.baseParams.paginar = 'si';
        CuentaPorCobrarCreditoDetalleLista.main.store_lista.baseParams.BuscarBy = true;
        CuentaPorCobrarCreditoDetalleLista.main.store_lista.load();


}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrarCreditoDetalle/storefkidtb142cuentacobrar',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}

};

Ext.onReady(CuentaPorCobrarCreditoDetalleFiltro.main.init,CuentaPorCobrarCreditoDetalleFiltro.main);
</script>