<script type="text/javascript">
Ext.ns("NovedadTrabajadorFiltro");
NovedadTrabajadorFiltro.main = {
init:function(){




this.co_solicitud = new Ext.form.NumberField({
	fieldLabel:'Co solicitud',
	name:'co_solicitud',
	value:''
});

this.nu_cedula = new Ext.form.NumberField({
	fieldLabel:'Nu cedula',
name:'nu_cedula',
	value:''
});

this.nb_trabajador = new Ext.form.TextField({
	fieldLabel:'Nb trabajador',
	name:'nb_trabajador',
	value:''
});

this.nu_concepto = new Ext.form.TextField({
	fieldLabel:'Nu concepto',
	name:'nu_concepto',
	value:''
});

this.nu_valor = new Ext.form.NumberField({
	fieldLabel:'Nu valor',
name:'nu_valor',
	value:''
});

this.fe_novedad = new Ext.form.DateField({
	fieldLabel:'Fe novedad',
	name:'fe_novedad'
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
                                                                                                            this.co_solicitud,
                                                                                this.nu_cedula,
                                                                                this.nb_trabajador,
                                                                                this.nu_concepto,
                                                                                this.nu_valor,
                                                                                this.fe_novedad,
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
                     NovedadTrabajadorFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    NovedadTrabajadorFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    NovedadTrabajadorFiltro.main.win.close();
                    NovedadTrabajadorLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    NovedadTrabajadorLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    NovedadTrabajadorFiltro.main.panelfiltro.getForm().reset();
    NovedadTrabajadorLista.main.store_lista.baseParams={}
    NovedadTrabajadorLista.main.store_lista.baseParams.paginar = 'si';
    NovedadTrabajadorLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = NovedadTrabajadorFiltro.main.panelfiltro.getForm().getValues();
    NovedadTrabajadorLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("NovedadTrabajadorLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        NovedadTrabajadorLista.main.store_lista.baseParams.paginar = 'si';
        NovedadTrabajadorLista.main.store_lista.baseParams.BuscarBy = true;
        NovedadTrabajadorLista.main.store_lista.load();


}

};

Ext.onReady(NovedadTrabajadorFiltro.main.init,NovedadTrabajadorFiltro.main);
</script>