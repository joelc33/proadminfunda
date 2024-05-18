<script type="text/javascript">
Ext.ns("ConfigCargoFiltro");
ConfigCargoFiltro.main = {
init:function(){




this.tx_cargo = new Ext.form.TextField({
	fieldLabel:'Cargo',
	name:'tx_cargo',
	value:'',
	width:200
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

this.co_tabulador2 = new Ext.form.NumberField({
	fieldLabel:'Co tabulador2',
	name:'co_tabulador2',
	value:''
});

this.nu_codigo = new Ext.form.TextField({
	fieldLabel:'Codigo',
	name:'nu_codigo',
	value:'',
	width:200
});

this.co_tp_tabulador = new Ext.form.NumberField({
	fieldLabel:'Co tp tabulador',
name:'co_tp_tabulador',
	value:''
});

this.co_tabulador = new Ext.form.NumberField({
	fieldLabel:'Co tabulador',
name:'co_tabulador',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                            this.tx_cargo,
                            this.nu_codigo
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
                     ConfigCargoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ConfigCargoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ConfigCargoFiltro.main.win.close();
                    ConfigCargoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ConfigCargoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ConfigCargoFiltro.main.panelfiltro.getForm().reset();
    ConfigCargoLista.main.store_lista.baseParams={}
    ConfigCargoLista.main.store_lista.baseParams.paginar = 'si';
    ConfigCargoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ConfigCargoFiltro.main.panelfiltro.getForm().getValues();
    ConfigCargoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ConfigCargoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ConfigCargoLista.main.store_lista.baseParams.paginar = 'si';
        ConfigCargoLista.main.store_lista.baseParams.BuscarBy = true;
        ConfigCargoLista.main.store_lista.load();


}

};

Ext.onReady(ConfigCargoFiltro.main.init,ConfigCargoFiltro.main);
</script>