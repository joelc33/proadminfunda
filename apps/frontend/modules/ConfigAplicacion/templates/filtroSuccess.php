<script type="text/javascript">
Ext.ns("ConfigAplicacionFiltro");
ConfigAplicacionFiltro.main = {
init:function(){




this.nu_anio_fiscal = new Ext.form.NumberField({
	fieldLabel:'Año',
    name:'nu_anio_fiscal',
	value:'',
    width:100
});

this.tx_tip_aplicacion = new Ext.form.TextField({
	fieldLabel:'N° Aplicacion',
	name:'tx_tip_aplicacion',
	value:'',
    width:300
});

this.tx_aplicacion = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'tx_aplicacion',
	value:'',
    width:300
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.nu_anio_fiscal,
                                                                                this.tx_tip_aplicacion,
                                                                                this.tx_aplicacion,
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
                     ConfigAplicacionFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ConfigAplicacionFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ConfigAplicacionFiltro.main.win.close();
                    ConfigAplicacionLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ConfigAplicacionLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ConfigAplicacionFiltro.main.panelfiltro.getForm().reset();
    ConfigAplicacionLista.main.store_lista.baseParams={}
    ConfigAplicacionLista.main.store_lista.baseParams.paginar = 'si';
    ConfigAplicacionLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ConfigAplicacionFiltro.main.panelfiltro.getForm().getValues();
    ConfigAplicacionLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ConfigAplicacionLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ConfigAplicacionLista.main.store_lista.baseParams.paginar = 'si';
        ConfigAplicacionLista.main.store_lista.baseParams.BuscarBy = true;
        ConfigAplicacionLista.main.store_lista.load();


}

};

Ext.onReady(ConfigAplicacionFiltro.main.init,ConfigAplicacionFiltro.main);
</script>