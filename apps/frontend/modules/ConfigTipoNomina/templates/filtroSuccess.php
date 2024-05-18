<script type="text/javascript">
Ext.ns("ConfigTipoNominaFiltro");
ConfigTipoNominaFiltro.main = {
init:function(){




this.tx_tp_domina = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'tx_tp_domina',
	value:'',
    width:400
});

this.nu_hora = new Ext.form.NumberField({
	fieldLabel:'Nu hora',
name:'nu_hora',
	value:''
});

this.co_nom_tipo_ingreso = new Ext.form.NumberField({
	fieldLabel:'Co nom tipo ingreso',
	name:'co_nom_tipo_ingreso',
	value:''
});

this.nu_dia_derecho_vacaciones = new Ext.form.NumberField({
	fieldLabel:'Nu dia derecho vacaciones',
name:'nu_dia_derecho_vacaciones',
	value:''
});

this.nu_anio_antiguedad_vacaciones = new Ext.form.NumberField({
	fieldLabel:'Nu anio antiguedad vacaciones',
name:'nu_anio_antiguedad_vacaciones',
	value:''
});

this.nu_dia_vacaciones = new Ext.form.NumberField({
	fieldLabel:'Nu dia vacaciones',
name:'nu_dia_vacaciones',
	value:''
});

this.co_nom_tipo_disfrute = new Ext.form.NumberField({
	fieldLabel:'Co nom tipo disfrute',
	name:'co_nom_tipo_disfrute',
	value:''
});

this.nu_dia_adicional_anio = new Ext.form.NumberField({
	fieldLabel:'Nu dia adicional anio',
name:'nu_dia_adicional_anio',
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

this.nu_nomina = new Ext.form.TextField({
	fieldLabel:'Cod. Nomina',
	name:'nu_nomina',
	value:'',
    width:100
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                        this.nu_nomina,
                        this.tx_tp_domina
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
                     ConfigTipoNominaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ConfigTipoNominaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ConfigTipoNominaFiltro.main.win.close();
                    ConfigTipoNominaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ConfigTipoNominaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ConfigTipoNominaFiltro.main.panelfiltro.getForm().reset();
    ConfigTipoNominaLista.main.store_lista.baseParams={}
    ConfigTipoNominaLista.main.store_lista.baseParams.paginar = 'si';
    ConfigTipoNominaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ConfigTipoNominaFiltro.main.panelfiltro.getForm().getValues();
    ConfigTipoNominaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ConfigTipoNominaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ConfigTipoNominaLista.main.store_lista.baseParams.paginar = 'si';
        ConfigTipoNominaLista.main.store_lista.baseParams.BuscarBy = true;
        ConfigTipoNominaLista.main.store_lista.load();


}

};

Ext.onReady(ConfigTipoNominaFiltro.main.init,ConfigTipoNominaFiltro.main);
</script>