<script type="text/javascript">
Ext.ns("TesoreriaIngresoPagoFiltro");
TesoreriaIngresoPagoFiltro.main = {
init:function(){

//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>



this.id_tb145_cuenta_cobrar_detalle = new Ext.form.ComboBox({
	fieldLabel:'Id tb145 cuenta cobrar detalle',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'id_tb145_cuenta_cobrar_detalle',
	//readOnly:(this.OBJ.id_tb145_cuenta_cobrar_detalle!='')?true:false,
	//style:(this.main.OBJ.id_tb145_cuenta_cobrar_detalle!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb145_cuenta_cobrar_detalle',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.mo_pago = new Ext.form.NumberField({
	fieldLabel:'Mo pago',
name:'mo_pago',
	value:''
});

this.id_tb074_forma_pago = new Ext.form.NumberField({
	fieldLabel:'Id tb074 forma pago',
	name:'id_tb074_forma_pago',
	value:''
});

this.id_tb010_banco = new Ext.form.NumberField({
	fieldLabel:'Id tb010 banco',
	name:'id_tb010_banco',
	value:''
});

this.id_tb011_cuenta_bancaria = new Ext.form.NumberField({
	fieldLabel:'Id tb011 cuenta bancaria',
	name:'id_tb011_cuenta_bancaria',
	value:''
});

this.fe_ingreso = new Ext.form.DateField({
	fieldLabel:'Fe ingreso',
	name:'fe_ingreso'
});

this.fe_registro = new Ext.form.DateField({
	fieldLabel:'Fe registro',
	name:'fe_registro'
});

this.id_tb147_tipo_documento = new Ext.form.NumberField({
	fieldLabel:'Id tb147 tipo documento',
	name:'id_tb147_tipo_documento',
	value:''
});

this.de_orden_ingreso = new Ext.form.TextField({
	fieldLabel:'De orden ingreso',
	name:'de_orden_ingreso',
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

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.id_tb145_cuenta_cobrar_detalle,
                                                                                this.mo_pago,
                                                                                this.id_tb074_forma_pago,
                                                                                this.id_tb010_banco,
                                                                                this.id_tb011_cuenta_bancaria,
                                                                                this.fe_ingreso,
                                                                                this.fe_registro,
                                                                                this.id_tb147_tipo_documento,
                                                                                this.de_orden_ingreso,
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
                     TesoreriaIngresoPagoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    TesoreriaIngresoPagoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    TesoreriaIngresoPagoFiltro.main.win.close();
                    TesoreriaIngresoPagoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    TesoreriaIngresoPagoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    TesoreriaIngresoPagoFiltro.main.panelfiltro.getForm().reset();
    TesoreriaIngresoPagoLista.main.store_lista.baseParams={}
    TesoreriaIngresoPagoLista.main.store_lista.baseParams.paginar = 'si';
    TesoreriaIngresoPagoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = TesoreriaIngresoPagoFiltro.main.panelfiltro.getForm().getValues();
    TesoreriaIngresoPagoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("TesoreriaIngresoPagoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        TesoreriaIngresoPagoLista.main.store_lista.baseParams.paginar = 'si';
        TesoreriaIngresoPagoLista.main.store_lista.baseParams.BuscarBy = true;
        TesoreriaIngresoPagoLista.main.store_lista.load();


}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngresoPago/storefkidtb145cuentacobrardetalle',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}

};

Ext.onReady(TesoreriaIngresoPagoFiltro.main.init,TesoreriaIngresoPagoFiltro.main);
</script>