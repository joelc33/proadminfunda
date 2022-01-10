<script type="text/javascript">
Ext.ns("TrabajadorFiltro");
TrabajadorFiltro.main = {
init:function(){




this.nu_cedula = new Ext.form.NumberField({
	fieldLabel:'Nu cedula',
name:'nu_cedula',
	value:''
});

this.nb_primer_nombre = new Ext.form.TextField({
	fieldLabel:'Nb primer nombre',
	name:'nb_primer_nombre',
	value:''
});

this.nb_segundo_nombre = new Ext.form.TextField({
	fieldLabel:'Nb segundo nombre',
	name:'nb_segundo_nombre',
	value:''
});

this.nb_primer_apellido = new Ext.form.TextField({
	fieldLabel:'Nb primer apellido',
	name:'nb_primer_apellido',
	value:''
});

this.nb_segundo_apellido = new Ext.form.TextField({
	fieldLabel:'Nb segundo apellido',
	name:'nb_segundo_apellido',
	value:''
});

this.co_documento = new Ext.form.NumberField({
	fieldLabel:'Co documento',
	name:'co_documento',
	value:''
});

this.co_ente = new Ext.form.NumberField({
	fieldLabel:'Co ente',
	name:'co_ente',
	value:''
});

this.co_edo_civil = new Ext.form.NumberField({
	fieldLabel:'Co edo civil',
	name:'co_edo_civil',
	value:''
});

this.fe_nacimiento = new Ext.form.DateField({
	fieldLabel:'Fe nacimiento',
	name:'fe_nacimiento'
});

this.co_tp_motricida = new Ext.form.TextField({
	fieldLabel:'Co tp motricida',
	name:'co_tp_motricida',
	value:''
});

this.nu_hijo = new Ext.form.NumberField({
	fieldLabel:'Nu hijo',
name:'nu_hijo',
	value:''
});

this.tx_direccion_domicilio = new Ext.form.TextField({
	fieldLabel:'Tx direccion domicilio',
	name:'tx_direccion_domicilio',
	value:''
});

this.co_parroquia_domicilio = new Ext.form.NumberField({
	fieldLabel:'Co parroquia domicilio',
	name:'co_parroquia_domicilio',
	value:''
});

this.tx_ciudad_domicilio = new Ext.form.TextField({
	fieldLabel:'Tx ciudad domicilio',
	name:'tx_ciudad_domicilio',
	value:''
});

this.tx_ciudad_nacimiento = new Ext.form.TextField({
	fieldLabel:'Tx ciudad nacimiento',
	name:'tx_ciudad_nacimiento',
	value:''
});

this.co_parroquia_nacimiento = new Ext.form.NumberField({
	fieldLabel:'Co parroquia nacimiento',
	name:'co_parroquia_nacimiento',
	value:''
});

this.co_nacionalidad = new Ext.form.NumberField({
	fieldLabel:'Co nacionalidad',
	name:'co_nacionalidad',
	value:''
});

this.nu_seguro_social = new Ext.form.NumberField({
	fieldLabel:'Nu seguro social',
name:'nu_seguro_social',
	value:''
});

this.nu_rif = new Ext.form.TextField({
	fieldLabel:'Nu rif',
	name:'nu_rif',
	value:''
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'created_at'
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'updated_at'
});

this.co_nivel_educativo = new Ext.form.NumberField({
	fieldLabel:'Co nivel educativo',
	name:'co_nivel_educativo',
	value:''
});

this.nu_anio_aprobado_educativo = new Ext.form.NumberField({
	fieldLabel:'Nu anio aprobado educativo',
name:'nu_anio_aprobado_educativo',
	value:''
});

this.co_profesion = new Ext.form.NumberField({
	fieldLabel:'Co profesion',
	name:'co_profesion',
	value:''
});

this.fe_graduacion = new Ext.form.DateField({
	fieldLabel:'Fe graduacion',
	name:'fe_graduacion'
});

this.tx_correo_electronico = new Ext.form.TextField({
	fieldLabel:'Tx correo electronico',
	name:'tx_correo_electronico',
	value:''
});

this.co_solicitud = new Ext.form.NumberField({
	fieldLabel:'Co solicitud',
	name:'co_solicitud',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.nu_cedula,
                                                                                this.nb_primer_nombre,
                                                                                this.nb_segundo_nombre,
                                                                                this.nb_primer_apellido,
                                                                                this.nb_segundo_apellido,
                                                                                this.co_documento,
                                                                                this.co_ente,
                                                                                this.co_edo_civil,
                                                                                this.fe_nacimiento,
                                                                                this.co_tp_motricida,
                                                                                this.nu_hijo,
                                                                                this.tx_direccion_domicilio,
                                                                                this.co_parroquia_domicilio,
                                                                                this.tx_ciudad_domicilio,
                                                                                this.tx_ciudad_nacimiento,
                                                                                this.co_parroquia_nacimiento,
                                                                                this.co_nacionalidad,
                                                                                this.nu_seguro_social,
                                                                                this.nu_rif,
                                                                                this.created_at,
                                                                                this.updated_at,
                                                                                this.co_nivel_educativo,
                                                                                this.nu_anio_aprobado_educativo,
                                                                                this.co_profesion,
                                                                                this.fe_graduacion,
                                                                                this.tx_correo_electronico,
                                                                                this.co_solicitud,
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
                     TrabajadorFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    TrabajadorFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    TrabajadorFiltro.main.win.close();
                    TrabajadorLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    TrabajadorLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    TrabajadorFiltro.main.panelfiltro.getForm().reset();
    TrabajadorLista.main.store_lista.baseParams={}
    TrabajadorLista.main.store_lista.baseParams.paginar = 'si';
    TrabajadorLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = TrabajadorFiltro.main.panelfiltro.getForm().getValues();
    TrabajadorLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("TrabajadorLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        TrabajadorLista.main.store_lista.baseParams.paginar = 'si';
        TrabajadorLista.main.store_lista.baseParams.BuscarBy = true;
        TrabajadorLista.main.store_lista.load();


}

};

Ext.onReady(TrabajadorFiltro.main.init,TrabajadorFiltro.main);
</script>