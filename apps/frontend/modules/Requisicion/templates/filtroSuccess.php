<script type="text/javascript">
Ext.ns("RequisicionFiltro");
RequisicionFiltro.main = {
init:function(){
 
//<Stores de fk>
this.storeCO_TIPO_SOLICITUD = this.getStoreCO_TIPO_SOLICITUD();
//<Stores de fk>
//<Stores de fk>
this.storeCO_USUARIO = this.getStoreCO_USUARIO();
//<Stores de fk>



this.co_tipo_solicitud = new Ext.form.ComboBox({
	fieldLabel:'Co tipo solicitud',
	store: this.storeCO_TIPO_SOLICITUD,
	typeAhead: true,
	valueField: 'co_tipo_solicitud',
	displayField:'co_tipo_solicitud',
	hiddenName:'co_tipo_solicitud',
	//readOnly:(this.OBJ.co_tipo_solicitud!='')?true:false,
	//style:(this.main.OBJ.co_tipo_solicitud!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tipo_solicitud',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_SOLICITUD.load();

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

this.co_ente = new Ext.form.NumberField({
	fieldLabel:'Co ente',
	name:'co_ente',
	value:''
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'created_at'
});

this.tx_concepto = new Ext.form.TextField({
	fieldLabel:'Tx concepto',
	name:'tx_concepto',
	value:''
});

this.tx_observacion = new Ext.form.TextField({
	fieldLabel:'Tx observacion',
	name:'tx_observacion',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_tipo_solicitud,
                                                                                this.co_usuario,
                                                                                this.co_ente,
                                                                                this.created_at,
                                                                                this.tx_concepto,
                                                                                this.tx_observacion,
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
                     RequisicionFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    RequisicionFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    RequisicionFiltro.main.win.close();
                    RequisicionLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    RequisicionLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    RequisicionFiltro.main.panelfiltro.getForm().reset();
    RequisicionLista.main.store_lista.baseParams={}
    RequisicionLista.main.store_lista.baseParams.paginar = 'si';
    RequisicionLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = RequisicionFiltro.main.panelfiltro.getForm().getValues();
    RequisicionLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("RequisicionLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        RequisicionLista.main.store_lista.baseParams.paginar = 'si';
        RequisicionLista.main.store_lista.baseParams.BuscarBy = true;
        RequisicionLista.main.store_lista.load();


}
,getStoreCO_TIPO_SOLICITUD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Requisicion/storefkcotiposolicitud',
        root:'data',
        fields:[
            {name: 'co_tipo_solicitud'}
            ]
    });
    return this.store;
}
,getStoreCO_USUARIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Requisicion/storefkcousuario',
        root:'data',
        fields:[
            {name: 'co_usuario'}
            ]
    });
    return this.store;
}

};

Ext.onReady(RequisicionFiltro.main.init,RequisicionFiltro.main);
</script>