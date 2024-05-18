<script type="text/javascript">
Ext.ns("IvaFacturaFiltro");
IvaFacturaFiltro.main = {
init:function(){




this.nu_valor = new Ext.form.NumberField({
	fieldLabel:'Nu valor',
name:'nu_valor',
	value:''
});

this.fe_desde = new Ext.form.DateField({
	fieldLabel:'Fe desde',
	name:'fe_desde'
});

this.fe_hasta = new Ext.form.DateField({
	fieldLabel:'Fe hasta',
	name:'fe_hasta'
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'in_activo',
	checked:true
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.nu_valor,
                                                                                this.fe_desde,
                                                                                this.fe_hasta,
                                                                                this.in_activo,
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
                     IvaFacturaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    IvaFacturaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    IvaFacturaFiltro.main.win.close();
                    IvaFacturaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    IvaFacturaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    IvaFacturaFiltro.main.panelfiltro.getForm().reset();
    IvaFacturaLista.main.store_lista.baseParams={}
    IvaFacturaLista.main.store_lista.baseParams.paginar = 'si';
    IvaFacturaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = IvaFacturaFiltro.main.panelfiltro.getForm().getValues();
    IvaFacturaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("IvaFacturaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        IvaFacturaLista.main.store_lista.baseParams.paginar = 'si';
        IvaFacturaLista.main.store_lista.baseParams.BuscarBy = true;
        IvaFacturaLista.main.store_lista.load();


}

};

Ext.onReady(IvaFacturaFiltro.main.init,IvaFacturaFiltro.main);
</script>