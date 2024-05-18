<script type="text/javascript">
Ext.ns("ModificaciondetalleFiltro");
ModificaciondetalleFiltro.main = {
init:function(){

//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>



this.id_tb096_presupuesto_modificacion = new Ext.form.ComboBox({
	fieldLabel:'Id tb096 presupuesto modificacion',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'id_tb096_presupuesto_modificacion',
	//readOnly:(this.OBJ.id_tb096_presupuesto_modificacion!='')?true:false,
	//style:(this.main.OBJ.id_tb096_presupuesto_modificacion!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb096_presupuesto_modificacion',
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

this.id_tb084_accion_especifica = new Ext.form.NumberField({
	fieldLabel:'Id tb084 accion especifica',
	name:'id_tb084_accion_especifica',
	value:''
});

this.id_tb085_presupuesto = new Ext.form.NumberField({
	fieldLabel:'Id tb085 presupuesto',
	name:'id_tb085_presupuesto',
	value:''
});

this.nu_partida = new Ext.form.TextField({
	fieldLabel:'Nu partida',
	name:'nu_partida',
	value:''
});

this.id_tb098_tipo_distribucion = new Ext.form.NumberField({
	fieldLabel:'Id tb098 tipo distribucion',
	name:'id_tb098_tipo_distribucion',
	value:''
});

this.mo_distribucion = new Ext.form.NumberField({
	fieldLabel:'Mo distribucion',
name:'mo_distribucion',
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
                                                                                                            this.id_tb096_presupuesto_modificacion,
                                                                                this.id_tb013_anio_fiscal,
                                                                                this.id_tb084_accion_especifica,
                                                                                this.id_tb085_presupuesto,
                                                                                this.nu_partida,
                                                                                this.id_tb098_tipo_distribucion,
                                                                                this.mo_distribucion,
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
                     ModificaciondetalleFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ModificaciondetalleFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ModificaciondetalleFiltro.main.win.close();
                    ModificaciondetalleLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ModificaciondetalleLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ModificaciondetalleFiltro.main.panelfiltro.getForm().reset();
    ModificaciondetalleLista.main.store_lista.baseParams={}
    ModificaciondetalleLista.main.store_lista.baseParams.paginar = 'si';
    ModificaciondetalleLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ModificaciondetalleFiltro.main.panelfiltro.getForm().getValues();
    ModificaciondetalleLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ModificaciondetalleLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ModificaciondetalleLista.main.store_lista.baseParams.paginar = 'si';
        ModificaciondetalleLista.main.store_lista.baseParams.BuscarBy = true;
        ModificaciondetalleLista.main.store_lista.load();


}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modificaciondetalle/storefkidtb096presupuestomodificacion',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}

};

Ext.onReady(ModificaciondetalleFiltro.main.init,ModificaciondetalleFiltro.main);
</script>