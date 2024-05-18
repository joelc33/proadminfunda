<script type="text/javascript">
Ext.ns("ViaticoFiltro");
ViaticoFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_TIPO_VIATICO = this.getStoreCO_TIPO_VIATICO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_ORIGEN_VIATICO = this.getStoreCO_ORIGEN_VIATICO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_ORIGEN_VIATICO = this.getStoreCO_ORIGEN_VIATICO();
//<Stores de fk>



this.co_tipo_viatico = new Ext.form.ComboBox({
	fieldLabel:'Co tipo viatico',
	store: this.storeCO_TIPO_VIATICO,
	typeAhead: true,
	valueField: 'co_tipo_viatico',
	displayField:'co_tipo_viatico',
	hiddenName:'co_tipo_viatico',
	//readOnly:(this.OBJ.co_tipo_viatico!='')?true:false,
	//style:(this.main.OBJ.co_tipo_viatico!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tipo_viatico',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_VIATICO.load();

this.tx_evento = new Ext.form.TextField({
	fieldLabel:'Tx evento',
	name:'tx_evento',
	value:''
});

this.tx_direccion = new Ext.form.TextField({
	fieldLabel:'Tx direccion',
	name:'tx_direccion',
	value:''
});

this.in_empleado = new Ext.form.Checkbox({
	fieldLabel:'In empleado',
	name:'in_empleado',
	checked:true
});

this.co_origen = new Ext.form.ComboBox({
	fieldLabel:'Co origen',
	store: this.storeCO_ORIGEN_VIATICO,
	typeAhead: true,
	valueField: 'co_origen_viatico',
	displayField:'co_origen_viatico',
	hiddenName:'co_origen',
	//readOnly:(this.OBJ.co_origen!='')?true:false,
	//style:(this.main.OBJ.co_origen!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_origen',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_ORIGEN_VIATICO.load();

this.co_destino = new Ext.form.ComboBox({
	fieldLabel:'Co destino',
	store: this.storeCO_ORIGEN_VIATICO,
	typeAhead: true,
	valueField: 'co_origen_viatico',
	displayField:'co_origen_viatico',
	hiddenName:'co_destino',
	//readOnly:(this.OBJ.co_destino!='')?true:false,
	//style:(this.main.OBJ.co_destino!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_destino',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_ORIGEN_VIATICO.load();

this.fe_desde = new Ext.form.DateField({
	fieldLabel:'Fe desde',
	name:'fe_desde'
});

this.fe_hasta = new Ext.form.DateField({
	fieldLabel:'Fe hasta',
	name:'fe_hasta'
});

this.in_hospedaje = new Ext.form.Checkbox({
	fieldLabel:'In hospedaje',
	name:'in_hospedaje',
	checked:true
});

this.tx_observacion_hospedaje = new Ext.form.TextField({
	fieldLabel:'Tx observacion hospedaje',
	name:'tx_observacion_hospedaje',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_tipo_viatico,
                                                                                this.tx_evento,
                                                                                this.tx_direccion,
                                                                                this.in_empleado,
                                                                                this.co_origen,
                                                                                this.co_destino,
                                                                                this.fe_desde,
                                                                                this.fe_hasta,
                                                                                this.in_hospedaje,
                                                                                this.tx_observacion_hospedaje,
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
                     ViaticoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ViaticoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ViaticoFiltro.main.win.close();
                    ViaticoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ViaticoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ViaticoFiltro.main.panelfiltro.getForm().reset();
    ViaticoLista.main.store_lista.baseParams={}
    ViaticoLista.main.store_lista.baseParams.paginar = 'si';
    ViaticoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ViaticoFiltro.main.panelfiltro.getForm().getValues();
    ViaticoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ViaticoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ViaticoLista.main.store_lista.baseParams.paginar = 'si';
        ViaticoLista.main.store_lista.baseParams.BuscarBy = true;
        ViaticoLista.main.store_lista.load();


}
,getStoreCO_TIPO_VIATICO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/storefkcotipoviatico',
        root:'data',
        fields:[
            {name: 'co_tipo_viatico'}
            ]
    });
    return this.store;
}
,getStoreCO_ORIGEN_VIATICO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/storefkcoorigen',
        root:'data',
        fields:[
            {name: 'co_origen_viatico'}
            ]
    });
    return this.store;
}
,getStoreCO_ORIGEN_VIATICO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/storefkcodestino',
        root:'data',
        fields:[
            {name: 'co_origen_viatico'}
            ]
    });
    return this.store;
}

};

Ext.onReady(ViaticoFiltro.main.init,ViaticoFiltro.main);
</script>