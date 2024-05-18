<script type="text/javascript">
Ext.ns("EstructuraOrganizativaFiltro");
EstructuraOrganizativaFiltro.main = {
init:function(){




this.co_padre = new Ext.form.NumberField({
	fieldLabel:'Co padre',
	name:'co_padre',
	value:''
});

this.tx_nom_estructura_administrativa = new Ext.form.TextField({
	fieldLabel:'Tx nom estructura administrativa',
	name:'tx_nom_estructura_administrativa',
	value:''
});

this.nu_centro_costo = new Ext.form.TextField({
	fieldLabel:'Nu centro costo',
	name:'nu_centro_costo',
	value:''
});

this.co_ente = new Ext.form.NumberField({
	fieldLabel:'Co ente',
	name:'co_ente',
	value:''
});

this.co_nivel_jerarquico = new Ext.form.NumberField({
	fieldLabel:'Co nivel jerarquico',
	name:'co_nivel_jerarquico',
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

this.co_dependencia = new Ext.form.NumberField({
	fieldLabel:'Co dependencia',
	name:'co_dependencia',
	value:''
});

this.co_enteorgano = new Ext.form.NumberField({
	fieldLabel:'Co enteorgano',
name:'co_enteorgano',
	value:''
});

this.nu_codigo = new Ext.form.TextField({
	fieldLabel:'Nu codigo',
	name:'nu_codigo',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_padre,
                                                                                this.tx_nom_estructura_administrativa,
                                                                                this.nu_centro_costo,
                                                                                this.co_ente,
                                                                                this.co_nivel_jerarquico,
                                                                                this.in_activo,
                                                                                this.created_at,
                                                                                this.updated_at,
                                                                                this.co_dependencia,
                                                                                this.co_enteorgano,
                                                                                this.nu_codigo,
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
                     EstructuraOrganizativaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    EstructuraOrganizativaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    EstructuraOrganizativaFiltro.main.win.close();
                    EstructuraOrganizativaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    EstructuraOrganizativaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    EstructuraOrganizativaFiltro.main.panelfiltro.getForm().reset();
    EstructuraOrganizativaLista.main.store_lista.baseParams={}
    EstructuraOrganizativaLista.main.store_lista.baseParams.paginar = 'si';
    EstructuraOrganizativaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = EstructuraOrganizativaFiltro.main.panelfiltro.getForm().getValues();
    EstructuraOrganizativaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("EstructuraOrganizativaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        EstructuraOrganizativaLista.main.store_lista.baseParams.paginar = 'si';
        EstructuraOrganizativaLista.main.store_lista.baseParams.BuscarBy = true;
        EstructuraOrganizativaLista.main.store_lista.load();


}

};

Ext.onReady(EstructuraOrganizativaFiltro.main.init,EstructuraOrganizativaFiltro.main);
</script>