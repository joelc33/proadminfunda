<script type="text/javascript">
Ext.ns("FamiliaproductoFiltro");
FamiliaproductoFiltro.main = {
init:function(){




this.de_familia_producto = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'de_familia_producto',
	value:'',
	width:400
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.de_familia_producto,

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
                     FamiliaproductoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    FamiliaproductoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    FamiliaproductoFiltro.main.win.close();
                    FamiliaproductoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    FamiliaproductoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    FamiliaproductoFiltro.main.panelfiltro.getForm().reset();
    FamiliaproductoLista.main.store_lista.baseParams={}
    FamiliaproductoLista.main.store_lista.baseParams.paginar = 'si';
    FamiliaproductoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = FamiliaproductoFiltro.main.panelfiltro.getForm().getValues();
    FamiliaproductoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("FamiliaproductoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        FamiliaproductoLista.main.store_lista.baseParams.paginar = 'si';
        FamiliaproductoLista.main.store_lista.baseParams.BuscarBy = true;
        FamiliaproductoLista.main.store_lista.load();


}

};

Ext.onReady(FamiliaproductoFiltro.main.init,FamiliaproductoFiltro.main);
</script>
