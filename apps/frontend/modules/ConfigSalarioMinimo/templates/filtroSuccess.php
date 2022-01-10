<script type="text/javascript">
Ext.ns("ConfigSalarioMinimoFiltro");
ConfigSalarioMinimoFiltro.main = {
init:function(){




this.mo_salario_minimo = new Ext.form.NumberField({
	fieldLabel:'Mo salario minimo',
name:'mo_salario_minimo',
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
                                                                                                            this.mo_salario_minimo,
                                                                                this.fe_ini,
                                                                                this.fe_fin,
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
                     ConfigSalarioMinimoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ConfigSalarioMinimoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ConfigSalarioMinimoFiltro.main.win.close();
                    ConfigSalarioMinimoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ConfigSalarioMinimoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ConfigSalarioMinimoFiltro.main.panelfiltro.getForm().reset();
    ConfigSalarioMinimoLista.main.store_lista.baseParams={}
    ConfigSalarioMinimoLista.main.store_lista.baseParams.paginar = 'si';
    ConfigSalarioMinimoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ConfigSalarioMinimoFiltro.main.panelfiltro.getForm().getValues();
    ConfigSalarioMinimoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ConfigSalarioMinimoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ConfigSalarioMinimoLista.main.store_lista.baseParams.paginar = 'si';
        ConfigSalarioMinimoLista.main.store_lista.baseParams.BuscarBy = true;
        ConfigSalarioMinimoLista.main.store_lista.load();


}

};

Ext.onReady(ConfigSalarioMinimoFiltro.main.init,ConfigSalarioMinimoFiltro.main);
</script>