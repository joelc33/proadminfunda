<script type="text/javascript">
Ext.ns("TrasladosFiltro");
TrasladosFiltro.main = {
init:function(){




this.co_ficha = new Ext.form.NumberField({
	fieldLabel:'Co ficha',
	name:'co_ficha',
	value:''
});

this.co_tp_nomina = new Ext.form.NumberField({
	fieldLabel:'Co tp nomina',
	name:'co_tp_nomina',
	value:''
});

this.co_grupo_nomina = new Ext.form.NumberField({
	fieldLabel:'Co grupo nomina',
	name:'co_grupo_nomina',
	value:''
});

this.co_cargo_estructura = new Ext.form.NumberField({
	fieldLabel:'Co cargo estructura',
	name:'co_cargo_estructura',
	value:''
});

this.in_sueldo_tab = new Ext.form.Checkbox({
	fieldLabel:'In sueldo tab',
	name:'in_sueldo_tab',
	checked:true
});

this.nu_horas = new Ext.form.NumberField({
	fieldLabel:'Nu horas',
name:'nu_horas',
	value:''
});

this.mo_salario_base = new Ext.form.NumberField({
	fieldLabel:'Mo salario base',
name:'mo_salario_base',
	value:''
});

this.co_tp_cargo = new Ext.form.NumberField({
	fieldLabel:'Co tp cargo',
	name:'co_tp_cargo',
	value:''
});

this.fe_ingreso = new Ext.form.DateField({
	fieldLabel:'Fe ingreso',
	name:'fe_ingreso'
});

this.fe_finiquito = new Ext.form.DateField({
	fieldLabel:'Fe finiquito',
	name:'fe_finiquito'
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
                                                                                                            this.co_ficha,
                                                                                this.co_tp_nomina,
                                                                                this.co_grupo_nomina,
                                                                                this.co_cargo_estructura,
                                                                                this.in_sueldo_tab,
                                                                                this.nu_horas,
                                                                                this.mo_salario_base,
                                                                                this.co_tp_cargo,
                                                                                this.fe_ingreso,
                                                                                this.fe_finiquito,
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
                     TrasladosFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    TrasladosFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    TrasladosFiltro.main.win.close();
                    TrasladosLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    TrasladosLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    TrasladosFiltro.main.panelfiltro.getForm().reset();
    TrasladosLista.main.store_lista.baseParams={}
    TrasladosLista.main.store_lista.baseParams.paginar = 'si';
    TrasladosLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = TrasladosFiltro.main.panelfiltro.getForm().getValues();
    TrasladosLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("TrasladosLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        TrasladosLista.main.store_lista.baseParams.paginar = 'si';
        TrasladosLista.main.store_lista.baseParams.BuscarBy = true;
        TrasladosLista.main.store_lista.load();


}

};

Ext.onReady(TrasladosFiltro.main.init,TrasladosFiltro.main);
</script>