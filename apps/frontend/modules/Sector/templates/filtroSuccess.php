<script type="text/javascript">
Ext.ns("SectorFiltro");
SectorFiltro.main = {
init:function(){




this.nu_sector = new Ext.form.TextField({
	fieldLabel:'Nu sector',
	name:'nu_sector',
	value:''
});

this.de_sector = new Ext.form.TextField({
	fieldLabel:'De sector',
	name:'de_sector',
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
                                                                                                            this.nu_sector,
                                                                                this.de_sector,
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
                     SectorFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    SectorFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    SectorFiltro.main.win.close();
                    SectorLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    SectorLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    SectorFiltro.main.panelfiltro.getForm().reset();
    SectorLista.main.store_lista.baseParams={}
    SectorLista.main.store_lista.baseParams.paginar = 'si';
    SectorLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = SectorFiltro.main.panelfiltro.getForm().getValues();
    SectorLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("SectorLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        SectorLista.main.store_lista.baseParams.paginar = 'si';
        SectorLista.main.store_lista.baseParams.BuscarBy = true;
        SectorLista.main.store_lista.load();


}

};

Ext.onReady(SectorFiltro.main.init,SectorFiltro.main);
</script>