<script type="text/javascript">
Ext.ns("PresupuestoMasivoFiltro");
PresupuestoMasivoFiltro.main = {
init:function(){




this.nu_ejercicio = new Ext.form.NumberField({
	fieldLabel:'Nu ejercicio',
name:'nu_ejercicio',
	value:''
});

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

this.nu_sector = new Ext.form.TextField({
	fieldLabel:'Nu sector',
	name:'nu_sector',
	value:''
});

this.co_ac_pr = new Ext.form.TextField({
	fieldLabel:'Co ac pr',
	name:'co_ac_pr',
	value:''
});

this.nu_proyecto_ac = new Ext.form.TextField({
	fieldLabel:'Nu proyecto ac',
	name:'nu_proyecto_ac',
	value:''
});

this.de_proyecto_ac = new Ext.form.TextField({
	fieldLabel:'De proyecto ac',
	name:'de_proyecto_ac',
	value:''
});

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

this.nu_partida = new Ext.form.TextField({
	fieldLabel:'Nu partida',
	name:'nu_partida',
	value:''
});

this.nu_desagregado = new Ext.form.TextField({
	fieldLabel:'Nu desagregado',
	name:'nu_desagregado',
	value:''
});

this.nu_fi = new Ext.form.TextField({
	fieldLabel:'Nu fi',
	name:'nu_fi',
	value:''
});

this.de_partida = new Ext.form.TextField({
	fieldLabel:'De partida',
	name:'de_partida',
	value:''
});

this.mo_inicial = new Ext.form.NumberField({
	fieldLabel:'Mo inicial',
name:'mo_inicial',
	value:''
});

this.co_categoria = new Ext.form.TextField({
	fieldLabel:'Co categoria',
	name:'co_categoria',
	value:''
});

this.nu_pa = new Ext.form.TextField({
	fieldLabel:'Nu pa',
	name:'nu_pa',
	value:''
});

this.nu_aplicacion = new Ext.form.TextField({
	fieldLabel:'Nu aplicacion',
	name:'nu_aplicacion',
	value:''
});

this.nu_area_estrategica = new Ext.form.TextField({
	fieldLabel:'Nu area estrategica',
	name:'nu_area_estrategica',
	value:''
});

this.nu_amb = new Ext.form.TextField({
	fieldLabel:'Nu amb',
	name:'nu_amb',
	value:''
});

this.tip_gasto = new Ext.form.TextField({
	fieldLabel:'Tip gasto',
	name:'tip_gasto',
	value:''
});

this.nu_clasificacion_economica = new Ext.form.TextField({
	fieldLabel:'Nu clasificacion economica',
	name:'nu_clasificacion_economica',
	value:''
});

this.tipo_ordenador = new Ext.form.TextField({
	fieldLabel:'Tipo ordenador',
	name:'tipo_ordenador',
	value:''
});

this.tp_ingreso = new Ext.form.TextField({
	fieldLabel:'Tp ingreso',
	name:'tp_ingreso',
	value:''
});

this.nu_ff = new Ext.form.TextField({
	fieldLabel:'Nu ff',
	name:'nu_ff',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                this.nu_ejercicio,
                                                                                this.nu_ejecutor,
                                                                                this.de_ejecutor,
                                                                                this.nu_sector,
                                                                                this.co_ac_pr,
                                                                                this.nu_proyecto_ac,
                                                                                this.de_proyecto_ac,
                                                                                this.nu_accion_especifica,
                                                                                this.de_accion_especifica,
                                                                                this.nu_partida,
                                                                                this.nu_desagregado,
                                                                                this.nu_fi,
                                                                                this.de_partida,
                                                                                this.mo_inicial,
                                                                                this.co_categoria,
                                                                                this.nu_pa,
                                                                                this.nu_aplicacion,
                                                                                this.nu_area_estrategica,
                                                                                this.nu_amb,
                                                                                this.tip_gasto,
                                                                                this.nu_clasificacion_economica,
                                                                                this.tipo_ordenador,
                                                                                this.tp_ingreso,
                                                                                this.nu_ff,
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
                     PresupuestoMasivoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    PresupuestoMasivoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    PresupuestoMasivoFiltro.main.win.close();
                    PresupuestoMasivoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    PresupuestoMasivoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    PresupuestoMasivoFiltro.main.panelfiltro.getForm().reset();
    PresupuestoMasivoLista.main.store_lista.baseParams={}
    PresupuestoMasivoLista.main.store_lista.baseParams.paginar = 'si';
    PresupuestoMasivoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = PresupuestoMasivoFiltro.main.panelfiltro.getForm().getValues();
    PresupuestoMasivoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("PresupuestoMasivoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        PresupuestoMasivoLista.main.store_lista.baseParams.paginar = 'si';
        PresupuestoMasivoLista.main.store_lista.baseParams.BuscarBy = true;
        PresupuestoMasivoLista.main.store_lista.load();


}

};

Ext.onReady(PresupuestoMasivoFiltro.main.init,PresupuestoMasivoFiltro.main);
</script>