<script type="text/javascript">
Ext.ns("CatalogoPartidaFiltro");
CatalogoPartidaFiltro.main = {
init:function(){




this.co_partida = new Ext.form.TextField({
	fieldLabel:'Co partida',
	name:'co_partida',
	value:''
});

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

this.id_tb013_anio_fiscal = new Ext.form.NumberField({
	fieldLabel:'Id tb013 anio fiscal',
	name:'id_tb013_anio_fiscal',
	value:''
});

this.in_movimiento = new Ext.form.Checkbox({
	fieldLabel:'In movimiento',
	name:'in_movimiento',
	checked:true
});

this.nu_nivel = new Ext.form.NumberField({
	fieldLabel:'Nu nivel',
	name:'nu_nivel',
	value:''
});

this.nu_pa = new Ext.form.TextField({
	fieldLabel:'Nu pa',
	name:'nu_pa',
	value:''
});

this.nu_ge = new Ext.form.TextField({
	fieldLabel:'Nu ge',
	name:'nu_ge',
	value:''
});

this.nu_es = new Ext.form.TextField({
	fieldLabel:'Nu es',
	name:'nu_es',
	value:''
});

this.nu_se = new Ext.form.TextField({
	fieldLabel:'Nu se',
	name:'nu_se',
	value:''
});

this.nu_sse = new Ext.form.TextField({
	fieldLabel:'Nu sse',
	name:'nu_sse',
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
                                                                                                            this.co_partida,
                                                                                this.nu_partida,
                                                                                this.de_partida,
                                                                                this.id_tb013_anio_fiscal,
                                                                                this.in_movimiento,
                                                                                this.nu_nivel,
                                                                                this.nu_pa,
                                                                                this.nu_ge,
                                                                                this.nu_es,
                                                                                this.nu_se,
                                                                                this.nu_sse,
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
                     CatalogoPartidaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    CatalogoPartidaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    CatalogoPartidaFiltro.main.win.close();
                    CatalogoPartidaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    CatalogoPartidaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    CatalogoPartidaFiltro.main.panelfiltro.getForm().reset();
    CatalogoPartidaLista.main.store_lista.baseParams={}
    CatalogoPartidaLista.main.store_lista.baseParams.paginar = 'si';
    CatalogoPartidaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = CatalogoPartidaFiltro.main.panelfiltro.getForm().getValues();
    CatalogoPartidaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("CatalogoPartidaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        CatalogoPartidaLista.main.store_lista.baseParams.paginar = 'si';
        CatalogoPartidaLista.main.store_lista.baseParams.BuscarBy = true;
        CatalogoPartidaLista.main.store_lista.load();


}

};

Ext.onReady(CatalogoPartidaFiltro.main.init,CatalogoPartidaFiltro.main);
</script>