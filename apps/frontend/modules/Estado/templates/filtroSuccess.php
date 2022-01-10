<script type="text/javascript">
Ext.ns("EstadoFiltro");
EstadoFiltro.main = {
init:function(){




this.nb_estado = new Ext.form.TextField({
	fieldLabel:'Estado',
	name:'nb_estado',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.nb_estado,
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
                     EstadoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    EstadoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    EstadoFiltro.main.win.close();
                    EstadoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    EstadoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    EstadoFiltro.main.panelfiltro.getForm().reset();
    EstadoLista.main.store_lista.baseParams={}
    EstadoLista.main.store_lista.baseParams.paginar = 'si';
    EstadoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = EstadoFiltro.main.panelfiltro.getForm().getValues();
    EstadoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("EstadoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        EstadoLista.main.store_lista.baseParams.paginar = 'si';
        EstadoLista.main.store_lista.baseParams.BuscarBy = true;
        EstadoLista.main.store_lista.load();


}

};

Ext.onReady(EstadoFiltro.main.init,EstadoFiltro.main);
</script>