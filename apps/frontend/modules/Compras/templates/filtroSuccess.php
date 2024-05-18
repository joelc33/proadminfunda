<script type="text/javascript">
Ext.ns("ComprasFiltro");
ComprasFiltro.main = {
init:function(){




this.co_requisicion = new Ext.form.NumberField({
	fieldLabel:'Co requisicion',
	name:'co_requisicion',
	value:''
});

this.co_ente = new Ext.form.NumberField({
	fieldLabel:'Co ente',
	name:'co_ente',
	value:''
});

this.co_usuario = new Ext.form.NumberField({
	fieldLabel:'Co usuario',
	name:'co_usuario',
	value:''
});

this.fecha_compra = new Ext.form.DateField({
	fieldLabel:'Fecha compra',
	name:'fecha_compra'
});

this.tx_observacion = new Ext.form.TextField({
	fieldLabel:'Tx observacion',
	name:'tx_observacion',
	value:''
});

this.co_solicitud = new Ext.form.NumberField({
	fieldLabel:'Co solicitud',
	name:'co_solicitud',
	value:''
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'created_at'
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_requisicion,
                                                                                this.co_ente,
                                                                                this.co_usuario,
                                                                                this.fecha_compra,
                                                                                this.tx_observacion,
                                                                                this.co_solicitud,
                                                                                this.created_at,
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
                     ComprasFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ComprasFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ComprasFiltro.main.win.close();
                    ComprasLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ComprasLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ComprasFiltro.main.panelfiltro.getForm().reset();
    ComprasLista.main.store_lista.baseParams={}
    ComprasLista.main.store_lista.baseParams.paginar = 'si';
    ComprasLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ComprasFiltro.main.panelfiltro.getForm().getValues();
    ComprasLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ComprasLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ComprasLista.main.store_lista.baseParams.paginar = 'si';
        ComprasLista.main.store_lista.baseParams.BuscarBy = true;
        ComprasLista.main.store_lista.load();


}

};

Ext.onReady(ComprasFiltro.main.init,ComprasFiltro.main);
</script>