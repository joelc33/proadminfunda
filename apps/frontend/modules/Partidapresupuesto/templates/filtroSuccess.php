<script type="text/javascript">
Ext.ns("PartidapresupuestoFiltro");
PartidapresupuestoFiltro.main = {
init:function(){

//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>



this.id_tb084_accion_especifica = new Ext.form.ComboBox({
	fieldLabel:'Id tb084 accion especifica',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'id_tb084_accion_especifica',
	//readOnly:(this.OBJ.id_tb084_accion_especifica!='')?true:false,
	//style:(this.main.OBJ.id_tb084_accion_especifica!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb084_accion_especifica',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.nu_partida = new Ext.form.TextField({
	fieldLabel:'Nu partida',
	name:'nu_partida',
	value:''
});

this.de_partida = new Ext.form.TextField({
	fieldLabel:'De partida',
	name:'de_partida',
	value:''
});

this.mo_inicial = new Ext.form.NumberField({
	fieldLabel:'Mo inicial',
name:'mo_inicial',
	value:''
});

this.mo_actualizado = new Ext.form.NumberField({
	fieldLabel:'Mo actualizado',
name:'mo_actualizado',
	value:''
});

this.mo_precomprometido = new Ext.form.NumberField({
	fieldLabel:'Mo precomprometido',
name:'mo_precomprometido',
	value:''
});

this.mo_comprometido = new Ext.form.NumberField({
	fieldLabel:'Mo comprometido',
name:'mo_comprometido',
	value:''
});

this.mo_causado = new Ext.form.NumberField({
	fieldLabel:'Mo causado',
name:'mo_causado',
	value:''
});

this.mo_pagado = new Ext.form.NumberField({
	fieldLabel:'Mo pagado',
name:'mo_pagado',
	value:''
});

this.mo_disponible = new Ext.form.NumberField({
	fieldLabel:'Mo disponible',
name:'mo_disponible',
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

this.in_movimiento = new Ext.form.Checkbox({
	fieldLabel:'In movimiento',
	name:'in_movimiento',
	checked:true
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.id_tb084_accion_especifica,
                                                                                this.nu_partida,
                                                                                this.de_partida,
                                                                                this.mo_inicial,
                                                                                this.mo_actualizado,
                                                                                this.mo_precomprometido,
                                                                                this.mo_comprometido,
                                                                                this.mo_causado,
                                                                                this.mo_pagado,
                                                                                this.mo_disponible,
                                                                                this.in_activo,
                                                                                this.created_at,
                                                                                this.updated_at,
                                                                                this.in_movimiento,
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
                     PartidapresupuestoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    PartidapresupuestoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    PartidapresupuestoFiltro.main.win.close();
                    PartidapresupuestoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    PartidapresupuestoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    PartidapresupuestoFiltro.main.panelfiltro.getForm().reset();
    PartidapresupuestoLista.main.store_lista.baseParams={}
    PartidapresupuestoLista.main.store_lista.baseParams.paginar = 'si';
    PartidapresupuestoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = PartidapresupuestoFiltro.main.panelfiltro.getForm().getValues();
    PartidapresupuestoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("PartidapresupuestoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        PartidapresupuestoLista.main.store_lista.baseParams.paginar = 'si';
        PartidapresupuestoLista.main.store_lista.baseParams.BuscarBy = true;
        PartidapresupuestoLista.main.store_lista.load();


}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/storefkidtb084accionespecifica',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}

};

Ext.onReady(PartidapresupuestoFiltro.main.init,PartidapresupuestoFiltro.main);
</script>