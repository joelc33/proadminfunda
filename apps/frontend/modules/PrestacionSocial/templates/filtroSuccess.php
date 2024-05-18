<script type="text/javascript">
Ext.ns("PrestacionSocialFiltro");
PrestacionSocialFiltro.main = {
init:function(){




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

this.co_solicitud = new Ext.form.NumberField({
	fieldLabel:'Co solicitud',
	name:'co_solicitud',
	value:''
});

this.co_usuario = new Ext.form.NumberField({
	fieldLabel:'Co usuario',
	name:'co_usuario',
	value:''
});

this.co_documento = new Ext.form.NumberField({
	fieldLabel:'Co documento',
	name:'co_documento',
	value:''
});

this.nu_documento = new Ext.form.TextField({
	fieldLabel:'Nu documento',
	name:'nu_documento',
	value:''
});

this.nb_persona = new Ext.form.TextField({
	fieldLabel:'Nb persona',
	name:'nb_persona',
	value:''
});

this.ap_persona = new Ext.form.TextField({
	fieldLabel:'Ap persona',
	name:'ap_persona',
	value:''
});

this.co_tipo_trabajador = new Ext.form.NumberField({
	fieldLabel:'Co tipo trabajador',
	name:'co_tipo_trabajador',
	value:''
});

this.co_ejecutor = new Ext.form.NumberField({
	fieldLabel:'Co ejecutor',
	name:'co_ejecutor',
	value:''
});

this.co_situacion_trabajador = new Ext.form.NumberField({
	fieldLabel:'Co situacion trabajador',
	name:'co_situacion_trabajador',
	value:''
});

this.fe_ingreso = new Ext.form.DateField({
	fieldLabel:'Fe ingreso',
	name:'fe_ingreso'
});

this.fe_egreso = new Ext.form.DateField({
	fieldLabel:'Fe egreso',
	name:'fe_egreso'
});

this.fe_movimiento = new Ext.form.DateField({
	fieldLabel:'Fe movimiento',
	name:'fe_movimiento'
});

this.de_observacion = new Ext.form.TextField({
	fieldLabel:'De observacion',
	name:'de_observacion',
	value:''
});

this.mo_pago = new Ext.form.NumberField({
	fieldLabel:'Mo pago',
name:'mo_pago',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.in_activo,
                                                                                this.created_at,
                                                                                this.updated_at,
                                                                                this.co_solicitud,
                                                                                this.co_usuario,
                                                                                this.co_documento,
                                                                                this.nu_documento,
                                                                                this.nb_persona,
                                                                                this.ap_persona,
                                                                                this.co_tipo_trabajador,
                                                                                this.co_ejecutor,
                                                                                this.co_situacion_trabajador,
                                                                                this.fe_ingreso,
                                                                                this.fe_egreso,
                                                                                this.fe_movimiento,
                                                                                this.de_observacion,
                                                                                this.mo_pago,
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
                     PrestacionSocialFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    PrestacionSocialFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    PrestacionSocialFiltro.main.win.close();
                    PrestacionSocialLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    PrestacionSocialLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    PrestacionSocialFiltro.main.panelfiltro.getForm().reset();
    PrestacionSocialLista.main.store_lista.baseParams={}
    PrestacionSocialLista.main.store_lista.baseParams.paginar = 'si';
    PrestacionSocialLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = PrestacionSocialFiltro.main.panelfiltro.getForm().getValues();
    PrestacionSocialLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("PrestacionSocialLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        PrestacionSocialLista.main.store_lista.baseParams.paginar = 'si';
        PrestacionSocialLista.main.store_lista.baseParams.BuscarBy = true;
        PrestacionSocialLista.main.store_lista.load();


}

};

Ext.onReady(PrestacionSocialFiltro.main.init,PrestacionSocialFiltro.main);
</script>