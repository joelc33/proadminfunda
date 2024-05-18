<script type="text/javascript">
Ext.ns("ActividadFiltro");
ActividadFiltro.main = {
init:function(){




this.co_programa = new Ext.form.NumberField({
	fieldLabel:'Co programa',
	name:'co_programa',
	value:''
});

this.tx_actividad = new Ext.form.TextField({
	fieldLabel:'Tx actividad',
	name:'tx_actividad',
	value:''
});

this.tx_denominacion_act = new Ext.form.TextField({
	fieldLabel:'Tx denominacion act',
	name:'tx_denominacion_act',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_programa,
                                                                                this.tx_actividad,
                                                                                this.tx_denominacion_act,
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
                     ActividadFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ActividadFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ActividadFiltro.main.win.close();
                    ActividadLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ActividadLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ActividadFiltro.main.panelfiltro.getForm().reset();
    ActividadLista.main.store_lista.baseParams={}
    ActividadLista.main.store_lista.baseParams.paginar = 'si';
    ActividadLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ActividadFiltro.main.panelfiltro.getForm().getValues();
    ActividadLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ActividadLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ActividadLista.main.store_lista.baseParams.paginar = 'si';
        ActividadLista.main.store_lista.baseParams.BuscarBy = true;
        ActividadLista.main.store_lista.load();


}

};

Ext.onReady(ActividadFiltro.main.init,ActividadFiltro.main);
</script>