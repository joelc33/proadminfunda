<script type="text/javascript">
Ext.ns("SubsectorFiltro");
SubsectorFiltro.main = {
init:function(){

//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>



this.id_tb080_sector = new Ext.form.ComboBox({
	fieldLabel:'Id tb080 sector',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'id_tb080_sector',
	//readOnly:(this.OBJ.id_tb080_sector!='')?true:false,
	//style:(this.main.OBJ.id_tb080_sector!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb080_sector',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.nu_sub_sector = new Ext.form.TextField({
	fieldLabel:'Nu sub sector',
	name:'nu_sub_sector',
	value:''
});

this.de_sub_sector = new Ext.form.TextField({
	fieldLabel:'De sub sector',
	name:'de_sub_sector',
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
                                                                                                            this.id_tb080_sector,
                                                                                this.nu_sub_sector,
                                                                                this.de_sub_sector,
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
                     SubsectorFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    SubsectorFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    SubsectorFiltro.main.win.close();
                    SubsectorLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    SubsectorLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    SubsectorFiltro.main.panelfiltro.getForm().reset();
    SubsectorLista.main.store_lista.baseParams={}
    SubsectorLista.main.store_lista.baseParams.paginar = 'si';
    SubsectorLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = SubsectorFiltro.main.panelfiltro.getForm().getValues();
    SubsectorLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("SubsectorLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        SubsectorLista.main.store_lista.baseParams.paginar = 'si';
        SubsectorLista.main.store_lista.baseParams.BuscarBy = true;
        SubsectorLista.main.store_lista.load();


}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Subsector/storefkidtb080sector',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}

};

Ext.onReady(SubsectorFiltro.main.init,SubsectorFiltro.main);
</script>