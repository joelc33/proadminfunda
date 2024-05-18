<script type="text/javascript">
Ext.ns("PresupuestomodificacionFiltro");
PresupuestomodificacionFiltro.main = {
init:function(){

//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>



this.id_tb095_tipo_modificacion = new Ext.form.ComboBox({
	fieldLabel:'Id tb095 tipo modificacion',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'id_tb095_tipo_modificacion',
	//readOnly:(this.OBJ.id_tb095_tipo_modificacion!='')?true:false,
	//style:(this.main.OBJ.id_tb095_tipo_modificacion!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb095_tipo_modificacion',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.nu_modificacion = new Ext.form.TextField({
	fieldLabel:'Nu modificacion',
	name:'nu_modificacion',
	value:''
});

this.fe_modificacion = new Ext.form.DateField({
	fieldLabel:'Fe modificacion',
	name:'fe_modificacion'
});

this.de_modificacion = new Ext.form.TextField({
	fieldLabel:'De modificacion',
	name:'de_modificacion',
	value:''
});

this.de_justificacion = new Ext.form.TextField({
	fieldLabel:'De justificacion',
	name:'de_justificacion',
	value:''
});

this.nu_oficio = new Ext.form.TextField({
	fieldLabel:'Nu oficio',
	name:'nu_oficio',
	value:''
});

this.fe_oficio = new Ext.form.DateField({
	fieldLabel:'Fe oficio',
	name:'fe_oficio'
});

this.de_articulo_ley = new Ext.form.TextField({
	fieldLabel:'De articulo ley',
	name:'de_articulo_ley',
	value:''
});

this.mo_modificacion = new Ext.form.NumberField({
	fieldLabel:'Mo modificacion',
name:'mo_modificacion',
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

this.id_tb082_ejecutor = new Ext.form.ComboBox({
	fieldLabel:'Id tb082 ejecutor',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'id_tb082_ejecutor',
	//readOnly:(this.OBJ.id_tb082_ejecutor!='')?true:false,
	//style:(this.main.OBJ.id_tb082_ejecutor!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb082_ejecutor',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.id_tb013_anio_fiscal = new Ext.form.NumberField({
	fieldLabel:'Id tb013 anio fiscal',
	name:'id_tb013_anio_fiscal',
	value:''
});

this.co_usuario = new Ext.form.NumberField({
	fieldLabel:'Co usuario',
	name:'co_usuario',
	value:''
});

this.co_solicitud = new Ext.form.NumberField({
	fieldLabel:'Co solicitud',
	name:'co_solicitud',
	value:''
});

this.co_tipo_solicitud = new Ext.form.NumberField({
	fieldLabel:'Co tipo solicitud',
	name:'co_tipo_solicitud',
	value:''
});

this.id_tb068_numero_fuente_financiamiento = new Ext.form.NumberField({
	fieldLabel:'Id tb068 numero fuente financiamiento',
	name:'id_tb068_numero_fuente_financiamiento',
	value:''
});

this.id_tb082_ejecutor_origen = new Ext.form.NumberField({
	fieldLabel:'Id tb082 ejecutor origen',
	name:'id_tb082_ejecutor_origen',
	value:''
});

this.id_tb082_ejecutor_destino = new Ext.form.NumberField({
	fieldLabel:'Id tb082 ejecutor destino',
	name:'id_tb082_ejecutor_destino',
	value:''
});

this.id_tb152_tipo_credito = new Ext.form.NumberField({
	fieldLabel:'Id tb152 tipo credito',
	name:'id_tb152_tipo_credito',
	value:''
});

this.in_procesado = new Ext.form.Checkbox({
	fieldLabel:'In procesado',
	name:'in_procesado',
	checked:true
});

this.id_tb073_fuente_financiamiento = new Ext.form.NumberField({
	fieldLabel:'Id tb073 fuente financiamiento',
	name:'id_tb073_fuente_financiamiento',
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
                                                                                                            this.id_tb095_tipo_modificacion,
                                                                                this.nu_modificacion,
                                                                                this.fe_modificacion,
                                                                                this.de_modificacion,
                                                                                this.de_justificacion,
                                                                                this.nu_oficio,
                                                                                this.fe_oficio,
                                                                                this.de_articulo_ley,
                                                                                this.mo_modificacion,
                                                                                this.in_activo,
                                                                                this.created_at,
                                                                                this.updated_at,
                                                                                this.id_tb082_ejecutor,
                                                                                this.id_tb013_anio_fiscal,
                                                                                this.co_usuario,
                                                                                this.co_solicitud,
                                                                                this.co_tipo_solicitud,
                                                                                this.id_tb068_numero_fuente_financiamiento,
                                                                                this.id_tb082_ejecutor_origen,
                                                                                this.id_tb082_ejecutor_destino,
                                                                                this.id_tb152_tipo_credito,
                                                                                this.in_procesado,
                                                                                this.id_tb073_fuente_financiamiento,
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
                     PresupuestomodificacionFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    PresupuestomodificacionFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    PresupuestomodificacionFiltro.main.win.close();
                    PresupuestomodificacionLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    PresupuestomodificacionLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    PresupuestomodificacionFiltro.main.panelfiltro.getForm().reset();
    PresupuestomodificacionLista.main.store_lista.baseParams={}
    PresupuestomodificacionLista.main.store_lista.baseParams.paginar = 'si';
    PresupuestomodificacionLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = PresupuestomodificacionFiltro.main.panelfiltro.getForm().getValues();
    PresupuestomodificacionLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("PresupuestomodificacionLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        PresupuestomodificacionLista.main.store_lista.baseParams.paginar = 'si';
        PresupuestomodificacionLista.main.store_lista.baseParams.BuscarBy = true;
        PresupuestomodificacionLista.main.store_lista.load();


}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/storefkidtb095tipomodificacion',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/storefkidtb082ejecutor',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}

};

Ext.onReady(PresupuestomodificacionFiltro.main.init,PresupuestomodificacionFiltro.main);
</script>