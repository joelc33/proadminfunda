<script type="text/javascript">
Ext.ns("inicioFiltro");
inicioFiltro.main = {
init:function(){




this.tx_menu = new Ext.form.TextField({
	fieldLabel:'Tx menu',
	name:'tx_menu',
	value:''
});

this.co_padre = new Ext.form.NumberField({
	fieldLabel:'Co padre',
	name:'co_padre',
	value:''
});

this.tx_href = new Ext.form.TextField({
	fieldLabel:'Tx href',
	name:'tx_href',
	value:''
});

this.nu_orden = new Ext.form.NumberField({
	fieldLabel:'Nu orden',
name:'nu_orden',
	value:''
});

this.tx_icono = new Ext.form.TextField({
	fieldLabel:'Tx icono',
	name:'tx_icono',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.tx_menu,
                                                                                this.co_padre,
                                                                                this.tx_href,
                                                                                this.nu_orden,
                                                                                this.tx_icono,
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
                     inicioFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    inicioFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    inicioFiltro.main.win.close();
                    inicioLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    inicioLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    inicioFiltro.main.panelfiltro.getForm().reset();
    inicioLista.main.store_lista.baseParams={}
    inicioLista.main.store_lista.baseParams.paginar = 'si';
    inicioLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = inicioFiltro.main.panelfiltro.getForm().getValues();
    inicioLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("inicioLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        inicioLista.main.store_lista.baseParams.paginar = 'si';
        inicioLista.main.store_lista.baseParams.BuscarBy = true;
        inicioLista.main.store_lista.load();


}

};

Ext.onReady(inicioFiltro.main.init,inicioFiltro.main);
</script>