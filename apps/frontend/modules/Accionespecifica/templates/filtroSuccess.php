<script type="text/javascript">
Ext.ns("AccionespecificaFiltro");
AccionespecificaFiltro.main = {
init:function(){

this.nu_accion_especifica = new Ext.form.TextField({
	fieldLabel:'Codigo',
	name:'nu_accion_especifica',
	value:'',
	width:200,
});

this.de_accion_especifica = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'de_accion_especifica',
	value:'',
	width:200,
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[

                                                                                this.nu_accion_especifica,
                                                                                this.de_accion_especifica
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
                     AccionespecificaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    AccionespecificaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    AccionespecificaFiltro.main.win.close();
                    AccionespecificaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    AccionespecificaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    AccionespecificaFiltro.main.panelfiltro.getForm().reset();
    AccionespecificaLista.main.store_lista.baseParams={}
    AccionespecificaLista.main.store_lista.baseParams.paginar = 'si';
    AccionespecificaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = AccionespecificaFiltro.main.panelfiltro.getForm().getValues();
    AccionespecificaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("AccionespecificaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        AccionespecificaLista.main.store_lista.baseParams.paginar = 'si';
        AccionespecificaLista.main.store_lista.baseParams.BuscarBy = true;
        AccionespecificaLista.main.store_lista.load();


}

};

Ext.onReady(AccionespecificaFiltro.main.init,AccionespecificaFiltro.main);
</script>
