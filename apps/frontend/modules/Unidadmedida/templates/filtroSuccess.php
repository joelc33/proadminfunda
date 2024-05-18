<script type="text/javascript">
Ext.ns("UnidadmedidaFiltro");
UnidadmedidaFiltro.main = {
init:function(){




this.de_unidad_medida = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'de_unidad_medida',
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
                                                                                    this.de_unidad_medida,
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
                     UnidadmedidaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    UnidadmedidaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    UnidadmedidaFiltro.main.win.close();
                    UnidadmedidaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    UnidadmedidaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    UnidadmedidaFiltro.main.panelfiltro.getForm().reset();
    UnidadmedidaLista.main.store_lista.baseParams={}
    UnidadmedidaLista.main.store_lista.baseParams.paginar = 'si';
    UnidadmedidaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = UnidadmedidaFiltro.main.panelfiltro.getForm().getValues();
    UnidadmedidaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("UnidadmedidaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        UnidadmedidaLista.main.store_lista.baseParams.paginar = 'si';
        UnidadmedidaLista.main.store_lista.baseParams.BuscarBy = true;
        UnidadmedidaLista.main.store_lista.load();


}

};

Ext.onReady(UnidadmedidaFiltro.main.init,UnidadmedidaFiltro.main);
</script>
