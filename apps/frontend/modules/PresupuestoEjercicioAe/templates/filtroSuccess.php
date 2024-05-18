<script type="text/javascript">
Ext.ns("PresupuestoEjercicioAeFiltro");
PresupuestoEjercicioAeFiltro.main = {
init:function(){

//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>



this.id_tb165_pac_tmp = new Ext.form.ComboBox({
	fieldLabel:'Id tb165 pac tmp',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'id_tb165_pac_tmp',
	//readOnly:(this.OBJ.id_tb165_pac_tmp!='')?true:false,
	//style:(this.main.OBJ.id_tb165_pac_tmp!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb165_pac_tmp',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.nu_accion_especifica = new Ext.form.TextField({
	fieldLabel:'Nu accion especifica',
	name:'nu_accion_especifica',
	value:''
});

this.de_accion_especifica = new Ext.form.TextField({
	fieldLabel:'De accion especifica',
	name:'de_accion_especifica',
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
                                                                                                            this.id_tb165_pac_tmp,
                                                                                this.nu_accion_especifica,
                                                                                this.de_accion_especifica,
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
                     PresupuestoEjercicioAeFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    PresupuestoEjercicioAeFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    PresupuestoEjercicioAeFiltro.main.win.close();
                    PresupuestoEjercicioAeLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    PresupuestoEjercicioAeLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    PresupuestoEjercicioAeFiltro.main.panelfiltro.getForm().reset();
    PresupuestoEjercicioAeLista.main.store_lista.baseParams={}
    PresupuestoEjercicioAeLista.main.store_lista.baseParams.paginar = 'si';
    PresupuestoEjercicioAeLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = PresupuestoEjercicioAeFiltro.main.panelfiltro.getForm().getValues();
    PresupuestoEjercicioAeLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("PresupuestoEjercicioAeLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        PresupuestoEjercicioAeLista.main.store_lista.baseParams.paginar = 'si';
        PresupuestoEjercicioAeLista.main.store_lista.baseParams.BuscarBy = true;
        PresupuestoEjercicioAeLista.main.store_lista.load();


}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAe/storefkidtb165pactmp',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}

};

Ext.onReady(PresupuestoEjercicioAeFiltro.main.init,PresupuestoEjercicioAeFiltro.main);
</script>