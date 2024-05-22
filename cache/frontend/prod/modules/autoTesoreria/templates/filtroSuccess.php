<script type="text/javascript">
Ext.ns("TesoreriaFiltro");
TesoreriaFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_SOLICITUD = this.getStoreCO_SOLICITUD();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TIPO_SOLICITUD = this.getStoreCO_TIPO_SOLICITUD();
//<Stores de fk>
//<Stores de fk>
this.storeCO_PROCESO = this.getStoreCO_PROCESO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_ESTATUS_RUTA = this.getStoreCO_ESTATUS_RUTA();
//<Stores de fk>



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

this.co_proceso = new Ext.form.ComboBox({
	fieldLabel:'Co proceso',
	store: this.storeCO_PROCESO,
	typeAhead: true,
	valueField: 'co_proceso',
	displayField:'co_proceso',
	hiddenName:'co_proceso',
	//readOnly:(this.OBJ.co_proceso!='')?true:false,
	//style:(this.main.OBJ.co_proceso!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_proceso',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_PROCESO.load();

this.observacion = new Ext.form.TextField({
	fieldLabel:'Observacion',
	name:'observacion',
	value:''
});

this.co_estatus_ruta = new Ext.form.ComboBox({
	fieldLabel:'Co estatus ruta',
	store: this.storeCO_ESTATUS_RUTA,
	typeAhead: true,
	valueField: 'co_estatus_ruta',
	displayField:'co_estatus_ruta',
	hiddenName:'co_estatus_ruta',
	//readOnly:(this.OBJ.co_estatus_ruta!='')?true:false,
	//style:(this.main.OBJ.co_estatus_ruta!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_estatus_ruta',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_ESTATUS_RUTA.load();

this.co_usuario = new Ext.form.NumberField({
	fieldLabel:'Co usuario',
	name:'co_usuario',
	value:''
});

this.nu_orden = new Ext.form.NumberField({
	fieldLabel:'Nu orden',
	name:'nu_orden',
	value:''
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'created_at'
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'updated_at'
});

this.in_actual = new Ext.form.Checkbox({
	fieldLabel:'In actual',
	name:'in_actual',
	checked:true
});

this.in_cargar_dato = new Ext.form.Checkbox({
	fieldLabel:'In cargar dato',
	name:'in_cargar_dato',
	checked:true
});

this.tx_ruta_reporte = new Ext.form.TextField({
	fieldLabel:'Tx ruta reporte',
	name:'tx_ruta_reporte',
	value:''
});

this.tx_imagen = new Ext.form.TextField({
	fieldLabel:'Tx imagen',
	name:'tx_imagen',
	value:''
});

this.tx_documento = new Ext.form.TextField({
	fieldLabel:'Tx documento',
	name:'tx_documento',
	value:''
});

this.co_usuario_actualizo = new Ext.form.NumberField({
	fieldLabel:'Co usuario actualizo',
	name:'co_usuario_actualizo',
	value:''
});

this.co_solicitud_anular = new Ext.form.NumberField({
	fieldLabel:'Co solicitud anular',
	name:'co_solicitud_anular',
	value:''
});

this.in_anular = new Ext.form.Checkbox({
	fieldLabel:'In anular',
	name:'in_anular',
	checked:true
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_solicitud,
                                                                                this.co_tipo_solicitud,
                                                                                this.co_proceso,
                                                                                this.observacion,
                                                                                this.co_estatus_ruta,
                                                                                this.co_usuario,
                                                                                this.nu_orden,
                                                                                this.created_at,
                                                                                this.updated_at,
                                                                                this.in_actual,
                                                                                this.in_cargar_dato,
                                                                                this.tx_ruta_reporte,
                                                                                this.tx_imagen,
                                                                                this.tx_documento,
                                                                                this.co_usuario_actualizo,
                                                                                this.co_solicitud_anular,
                                                                                this.in_anular,
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
                     TesoreriaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    TesoreriaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    TesoreriaFiltro.main.win.close();
                    TesoreriaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    TesoreriaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    TesoreriaFiltro.main.panelfiltro.getForm().reset();
    TesoreriaLista.main.store_lista.baseParams={}
    TesoreriaLista.main.store_lista.baseParams.paginar = 'si';
    TesoreriaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = TesoreriaFiltro.main.panelfiltro.getForm().getValues();
    TesoreriaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("TesoreriaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        TesoreriaLista.main.store_lista.baseParams.paginar = 'si';
        TesoreriaLista.main.store_lista.baseParams.BuscarBy = true;
        TesoreriaLista.main.store_lista.load();


}
,getStoreCO_SOLICITUD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Tesoreria/storefkcosolicitud',
        root:'data',
        fields:[
            {name: 'co_solicitud'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_SOLICITUD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Tesoreria/storefkcotiposolicitud',
        root:'data',
        fields:[
            {name: 'co_tipo_solicitud'}
            ]
    });
    return this.store;
}
,getStoreCO_PROCESO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Tesoreria/storefkcoproceso',
        root:'data',
        fields:[
            {name: 'co_proceso'}
            ]
    });
    return this.store;
}
,getStoreCO_ESTATUS_RUTA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Tesoreria/storefkcoestatusruta',
        root:'data',
        fields:[
            {name: 'co_estatus_ruta'}
            ]
    });
    return this.store;
}

};

Ext.onReady(TesoreriaFiltro.main.init,TesoreriaFiltro.main);
</script>