<script type="text/javascript">
Ext.ns("RolFiltro");
RolFiltro.main = {
init:function(){




this.tx_rol = new Ext.form.TextField({
	fieldLabel:'Rol',
	name:'tx_rol',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.tx_rol,
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
                     RolFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    RolFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    RolFiltro.main.win.close();
                    RolLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    RolLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    RolFiltro.main.panelfiltro.getForm().reset();
    RolLista.main.store_lista.baseParams={}
    RolLista.main.store_lista.baseParams.paginar = 'si';
    RolLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = RolFiltro.main.panelfiltro.getForm().getValues();
    RolLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("RolLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        RolLista.main.store_lista.baseParams.paginar = 'si';
        RolLista.main.store_lista.baseParams.BuscarBy = true;
        RolLista.main.store_lista.load();


}

};

Ext.onReady(RolFiltro.main.init,RolFiltro.main);
</script>