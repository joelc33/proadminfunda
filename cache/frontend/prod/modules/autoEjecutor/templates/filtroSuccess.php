<script type="text/javascript">
Ext.ns("EjecutorFiltro");
EjecutorFiltro.main = {
init:function(){

//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>



this.nu_ejecutor = new Ext.form.TextField({
	fieldLabel:'Nu ejecutor',
	name:'nu_ejecutor',
	value:''
});

this.de_ejecutor = new Ext.form.TextField({
	fieldLabel:'De ejecutor',
	name:'de_ejecutor',
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

this.tx_sigla = new Ext.form.TextField({
	fieldLabel:'Tx sigla',
	name:'tx_sigla',
	value:''
});

this.co_sector = new Ext.form.ComboBox({
	fieldLabel:'Co sector',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'co_sector',
	//readOnly:(this.OBJ.co_sector!='')?true:false,
	//style:(this.main.OBJ.co_sector!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_sector',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.id_tb151_tipo_ejecutor = new Ext.form.ComboBox({
	fieldLabel:'Id tb151 tipo ejecutor',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'id_tb151_tipo_ejecutor',
	//readOnly:(this.OBJ.id_tb151_tipo_ejecutor!='')?true:false,
	//style:(this.main.OBJ.id_tb151_tipo_ejecutor!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb151_tipo_ejecutor',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.nu_ejecutor,
                                                                                this.de_ejecutor,
                                                                                this.in_activo,
                                                                                this.created_at,
                                                                                this.updated_at,
                                                                                this.tx_sigla,
                                                                                this.co_sector,
                                                                                this.id_tb151_tipo_ejecutor,
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
                     EjecutorFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    EjecutorFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    EjecutorFiltro.main.win.close();
                    EjecutorLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    EjecutorLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    EjecutorFiltro.main.panelfiltro.getForm().reset();
    EjecutorLista.main.store_lista.baseParams={}
    EjecutorLista.main.store_lista.baseParams.paginar = 'si';
    EjecutorLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = EjecutorFiltro.main.panelfiltro.getForm().getValues();
    EjecutorLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("EjecutorLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        EjecutorLista.main.store_lista.baseParams.paginar = 'si';
        EjecutorLista.main.store_lista.baseParams.BuscarBy = true;
        EjecutorLista.main.store_lista.load();


}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Ejecutor/storefkcosector',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Ejecutor/storefkidtb151tipoejecutor',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}

};

Ext.onReady(EjecutorFiltro.main.init,EjecutorFiltro.main);
</script>