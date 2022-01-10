<script type="text/javascript">
Ext.ns("MarcaFiltro");
MarcaFiltro.main = {
init:function(){



this.tx_marca = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'tx_marca',
	value:'',
	width:400
});


    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[this.tx_marca]
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
                     MarcaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    MarcaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    MarcaFiltro.main.win.close();
                    MarcaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    MarcaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    MarcaFiltro.main.panelfiltro.getForm().reset();
    MarcaLista.main.store_lista.baseParams={}
    MarcaLista.main.store_lista.baseParams.paginar = 'si';
    MarcaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = MarcaFiltro.main.panelfiltro.getForm().getValues();
    MarcaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("MarcaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        MarcaLista.main.store_lista.baseParams.paginar = 'si';
        MarcaLista.main.store_lista.baseParams.BuscarBy = true;
        MarcaLista.main.store_lista.load();


}

};

Ext.onReady(MarcaFiltro.main.init,MarcaFiltro.main);
</script>
