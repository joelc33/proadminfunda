<script type="text/javascript">
Ext.ns("ProcesoFiltro");
ProcesoFiltro.main = {
init:function(){




this.tx_proceso = new Ext.form.TextField({
	fieldLabel:'Proceso',
	name:'tx_proceso',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.tx_proceso,
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
                     ProcesoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ProcesoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ProcesoFiltro.main.win.close();
                    ProcesoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ProcesoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ProcesoFiltro.main.panelfiltro.getForm().reset();
    ProcesoLista.main.store_lista.baseParams={}
    ProcesoLista.main.store_lista.baseParams.paginar = 'si';
    ProcesoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ProcesoFiltro.main.panelfiltro.getForm().getValues();
    ProcesoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ProcesoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ProcesoLista.main.store_lista.baseParams.paginar = 'si';
        ProcesoLista.main.store_lista.baseParams.BuscarBy = true;
        ProcesoLista.main.store_lista.load();


}

};

Ext.onReady(ProcesoFiltro.main.init,ProcesoFiltro.main);
</script>