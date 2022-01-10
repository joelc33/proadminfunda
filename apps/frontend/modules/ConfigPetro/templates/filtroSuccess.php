<script type="text/javascript">
Ext.ns("ConfigPetroFiltro");
ConfigPetroFiltro.main = {
init:function(){




this.mo_petro = new Ext.form.NumberField({
	fieldLabel:'Mo petro',
name:'mo_petro',
	value:''
});

this.fe_ini = new Ext.form.DateField({
	fieldLabel:'Fe ini',
	name:'fe_ini'
});

this.fe_fin = new Ext.form.DateField({
	fieldLabel:'Fe fin',
	name:'fe_fin'
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
                                                                                                            this.mo_petro,
                                                                                this.fe_ini,
                                                                                this.fe_fin,
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
                     ConfigPetroFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ConfigPetroFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ConfigPetroFiltro.main.win.close();
                    ConfigPetroLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ConfigPetroLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ConfigPetroFiltro.main.panelfiltro.getForm().reset();
    ConfigPetroLista.main.store_lista.baseParams={}
    ConfigPetroLista.main.store_lista.baseParams.paginar = 'si';
    ConfigPetroLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ConfigPetroFiltro.main.panelfiltro.getForm().getValues();
    ConfigPetroLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ConfigPetroLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ConfigPetroLista.main.store_lista.baseParams.paginar = 'si';
        ConfigPetroLista.main.store_lista.baseParams.BuscarBy = true;
        ConfigPetroLista.main.store_lista.load();


}

};

Ext.onReady(ConfigPetroFiltro.main.init,ConfigPetroFiltro.main);
</script>