<script type="text/javascript">
Ext.ns("SolicitudAyudaFiltro");
SolicitudAyudaFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_PERSONA = this.getStoreCO_PERSONA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TIPO_AYUDA = this.getStoreCO_TIPO_AYUDA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_SOLICITUD = this.getStoreCO_SOLICITUD();
//<Stores de fk>
//<Stores de fk>
this.storeCO_USUARIO = this.getStoreCO_USUARIO();
//<Stores de fk>



this.co_persona = new Ext.form.ComboBox({
	fieldLabel:'Co persona',
	store: this.storeCO_PERSONA,
	typeAhead: true,
	valueField: 'co_persona',
	displayField:'co_persona',
	hiddenName:'co_persona',
	//readOnly:(this.OBJ.co_persona!='')?true:false,
	//style:(this.main.OBJ.co_persona!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_persona',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_PERSONA.load();

this.co_tipo_ayuda = new Ext.form.ComboBox({
	fieldLabel:'Co tipo ayuda',
	store: this.storeCO_TIPO_AYUDA,
	typeAhead: true,
	valueField: 'co_tipo_ayuda',
	displayField:'co_tipo_ayuda',
	hiddenName:'co_tipo_ayuda',
	//readOnly:(this.OBJ.co_tipo_ayuda!='')?true:false,
	//style:(this.main.OBJ.co_tipo_ayuda!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tipo_ayuda',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_AYUDA.load();

this.tx_observacion = new Ext.form.TextField({
	fieldLabel:'Tx observacion',
	name:'tx_observacion',
	value:''
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

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'created_at'
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_persona,
                                                                                this.co_tipo_ayuda,
                                                                                this.tx_observacion,
                                                                                this.co_solicitud,
                                                                                this.co_usuario,
                                                                                this.created_at,
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
                     SolicitudAyudaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    SolicitudAyudaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    SolicitudAyudaFiltro.main.win.close();
                    SolicitudAyudaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    SolicitudAyudaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    SolicitudAyudaFiltro.main.panelfiltro.getForm().reset();
    SolicitudAyudaLista.main.store_lista.baseParams={}
    SolicitudAyudaLista.main.store_lista.baseParams.paginar = 'si';
    SolicitudAyudaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = SolicitudAyudaFiltro.main.panelfiltro.getForm().getValues();
    SolicitudAyudaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("SolicitudAyudaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        SolicitudAyudaLista.main.store_lista.baseParams.paginar = 'si';
        SolicitudAyudaLista.main.store_lista.baseParams.BuscarBy = true;
        SolicitudAyudaLista.main.store_lista.load();


}
,getStoreCO_PERSONA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/SolicitudAyuda/storefkcopersona',
        root:'data',
        fields:[
            {name: 'co_persona'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_AYUDA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/SolicitudAyuda/storefkcotipoayuda',
        root:'data',
        fields:[
            {name: 'co_tipo_ayuda'}
            ]
    });
    return this.store;
}
,getStoreCO_SOLICITUD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/SolicitudAyuda/storefkcosolicitud',
        root:'data',
        fields:[
            {name: 'co_solicitud'}
            ]
    });
    return this.store;
}
,getStoreCO_USUARIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/SolicitudAyuda/storefkcousuario',
        root:'data',
        fields:[
            {name: 'co_usuario'}
            ]
    });
    return this.store;
}

};

Ext.onReady(SolicitudAyudaFiltro.main.init,SolicitudAyudaFiltro.main);
</script>