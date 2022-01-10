<script type="text/javascript">
Ext.ns("PartidaproductoFiltro");
PartidaproductoFiltro.main = {
init:function(){




this.nu_partida = new Ext.form.TextField({
	fieldLabel:'Nu partida',
	name:'nu_partida',
	value:''
});

this.co_producto = new Ext.form.NumberField({
	fieldLabel:'Co producto',
	name:'co_producto',
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
                                                                                                            this.nu_partida,
                                                                                this.co_producto,
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
                     PartidaproductoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    PartidaproductoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    PartidaproductoFiltro.main.win.close();
                    PartidaproductoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    PartidaproductoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    PartidaproductoFiltro.main.panelfiltro.getForm().reset();
    PartidaproductoLista.main.store_lista.baseParams={}
    PartidaproductoLista.main.store_lista.baseParams.paginar = 'si';
    PartidaproductoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = PartidaproductoFiltro.main.panelfiltro.getForm().getValues();
    PartidaproductoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("PartidaproductoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        PartidaproductoLista.main.store_lista.baseParams.paginar = 'si';
        PartidaproductoLista.main.store_lista.baseParams.BuscarBy = true;
        PartidaproductoLista.main.store_lista.load();


}

};

Ext.onReady(PartidaproductoFiltro.main.init,PartidaproductoFiltro.main);
</script>