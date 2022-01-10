<script type="text/javascript">
Ext.ns("EjecutorFiltro");
EjecutorFiltro.main = {
init:function(){




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
                                                                                                            this.nu_ejecutor,
                                                                                this.de_ejecutor,
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
                     EjecutorFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    EjecutorFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    EjecutorFiltro.main.win.close();
                    EjecutorLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    EjecutorLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    EjecutorFiltro.main.panelfiltro.getForm().reset();
    EjecutorLista.main.store_lista.baseParams={}
    EjecutorLista.main.store_lista.baseParams.paginar = 'si';
    EjecutorLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = EjecutorFiltro.main.panelfiltro.getForm().getValues();
    EjecutorLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("EjecutorLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        EjecutorLista.main.store_lista.baseParams.paginar = 'si';
        EjecutorLista.main.store_lista.baseParams.BuscarBy = true;
        EjecutorLista.main.store_lista.load();


}

};

Ext.onReady(EjecutorFiltro.main.init,EjecutorFiltro.main);
</script>