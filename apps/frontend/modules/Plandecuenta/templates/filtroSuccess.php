<script type="text/javascript">
Ext.ns("PlandecuentaFiltro");
PlandecuentaFiltro.main = {
init:function(){




this.tx_codigo_cuenta = new Ext.form.TextField({
	fieldLabel:'Tx codigo cuenta',
	name:'tx_codigo_cuenta',
	value:''
});

this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'Tx descripcion',
	name:'tx_descripcion',
	value:''
});

this.tx_tipo = new Ext.form.TextField({
	fieldLabel:'Tx tipo',
	name:'tx_tipo',
	value:''
});

this.co_tipo = new Ext.form.NumberField({
	fieldLabel:'Co tipo',
	name:'co_tipo',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.tx_codigo_cuenta,
                                                                                this.tx_descripcion,
                                                                                this.tx_tipo,
                                                                                this.co_tipo,
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
                     PlandecuentaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    PlandecuentaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    PlandecuentaFiltro.main.win.close();
                    PlandecuentaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    PlandecuentaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    PlandecuentaFiltro.main.panelfiltro.getForm().reset();
    PlandecuentaLista.main.store_lista.baseParams={}
    PlandecuentaLista.main.store_lista.baseParams.paginar = 'si';
    PlandecuentaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = PlandecuentaFiltro.main.panelfiltro.getForm().getValues();
    PlandecuentaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("PlandecuentaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        PlandecuentaLista.main.store_lista.baseParams.paginar = 'si';
        PlandecuentaLista.main.store_lista.baseParams.BuscarBy = true;
        PlandecuentaLista.main.store_lista.load();


}

};

Ext.onReady(PlandecuentaFiltro.main.init,PlandecuentaFiltro.main);
</script>