<script type="text/javascript">
Ext.ns("ProgramaticaFiltro");
ProgramaticaFiltro.main = {
init:function(){




this.nu_sector = new Ext.form.TextField({
	fieldLabel:'Nu sector',
	name:'nu_sector',
	value:''
});

this.tx_denominacion = new Ext.form.TextField({
	fieldLabel:'Tx denominacion',
	name:'tx_denominacion',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.nu_sector,
                                                                                this.tx_denominacion,
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
                     ProgramaticaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ProgramaticaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ProgramaticaFiltro.main.win.close();
                    ProgramaticaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ProgramaticaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ProgramaticaFiltro.main.panelfiltro.getForm().reset();
    ProgramaticaLista.main.store_lista.baseParams={}
    ProgramaticaLista.main.store_lista.baseParams.paginar = 'si';
    ProgramaticaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ProgramaticaFiltro.main.panelfiltro.getForm().getValues();
    ProgramaticaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ProgramaticaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ProgramaticaLista.main.store_lista.baseParams.paginar = 'si';
        ProgramaticaLista.main.store_lista.baseParams.BuscarBy = true;
        ProgramaticaLista.main.store_lista.load();


}

};

Ext.onReady(ProgramaticaFiltro.main.init,ProgramaticaFiltro.main);
</script>