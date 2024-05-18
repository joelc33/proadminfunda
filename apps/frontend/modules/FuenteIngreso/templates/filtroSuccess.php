<script type="text/javascript">
Ext.ns("FuenteIngresoFiltro");
FuenteIngresoFiltro.main = {
init:function(){




this.tx_fuente_ingreso = new Ext.form.TextField({
	fieldLabel:'Tx fuente ingreso',
	name:'tx_fuente_ingreso',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.tx_fuente_ingreso,
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
                     FuenteIngresoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    FuenteIngresoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    FuenteIngresoFiltro.main.win.close();
                    FuenteIngresoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    FuenteIngresoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    FuenteIngresoFiltro.main.panelfiltro.getForm().reset();
    FuenteIngresoLista.main.store_lista.baseParams={}
    FuenteIngresoLista.main.store_lista.baseParams.paginar = 'si';
    FuenteIngresoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = FuenteIngresoFiltro.main.panelfiltro.getForm().getValues();
    FuenteIngresoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("FuenteIngresoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        FuenteIngresoLista.main.store_lista.baseParams.paginar = 'si';
        FuenteIngresoLista.main.store_lista.baseParams.BuscarBy = true;
        FuenteIngresoLista.main.store_lista.load();


}

};

Ext.onReady(FuenteIngresoFiltro.main.init,FuenteIngresoFiltro.main);
</script>