<script type="text/javascript">
Ext.ns("DescripcionCuentaFiltro");
DescripcionCuentaFiltro.main = {
init:function(){




this.tx_descripcion_cuenta = new Ext.form.TextField({
	fieldLabel:'Tx descripcion cuenta',
	name:'tx_descripcion_cuenta',
	value:''
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
                                                                                                            this.tx_descripcion_cuenta,
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
                     DescripcionCuentaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    DescripcionCuentaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    DescripcionCuentaFiltro.main.win.close();
                    DescripcionCuentaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    DescripcionCuentaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    DescripcionCuentaFiltro.main.panelfiltro.getForm().reset();
    DescripcionCuentaLista.main.store_lista.baseParams={}
    DescripcionCuentaLista.main.store_lista.baseParams.paginar = 'si';
    DescripcionCuentaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = DescripcionCuentaFiltro.main.panelfiltro.getForm().getValues();
    DescripcionCuentaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("DescripcionCuentaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        DescripcionCuentaLista.main.store_lista.baseParams.paginar = 'si';
        DescripcionCuentaLista.main.store_lista.baseParams.BuscarBy = true;
        DescripcionCuentaLista.main.store_lista.load();


}

};

Ext.onReady(DescripcionCuentaFiltro.main.init,DescripcionCuentaFiltro.main);
</script>