<script type="text/javascript">
Ext.ns("AeactividadesFiltro");
AeactividadesFiltro.main = {
init:function(){


this.nu_actividad = new Ext.form.TextField({
	fieldLabel:'Codigo',
	name:'nu_actividad',
	value:'',
	width:200
});

this.de_actividad = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'de_actividad',
	value:'',
	width:200
});


    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[

                                                                                this.nu_actividad,
                                                                                this.de_actividad,
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
                     AeactividadesFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    AeactividadesFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    AeactividadesFiltro.main.win.close();
                    AeactividadesLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    AeactividadesLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    AeactividadesFiltro.main.panelfiltro.getForm().reset();
    AeactividadesLista.main.store_lista.baseParams={}
    AeactividadesLista.main.store_lista.baseParams.paginar = 'si';
    AeactividadesLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = AeactividadesFiltro.main.panelfiltro.getForm().getValues();
    AeactividadesLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("AeactividadesLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        AeactividadesLista.main.store_lista.baseParams.paginar = 'si';
        AeactividadesLista.main.store_lista.baseParams.BuscarBy = true;
        AeactividadesLista.main.store_lista.load();


}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Aeactividades/storefkidtb084accionespecifica',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}

};

Ext.onReady(AeactividadesFiltro.main.init,AeactividadesFiltro.main);
</script>
