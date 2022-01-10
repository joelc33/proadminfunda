<script type="text/javascript">
Ext.ns("CargoFiltro");
CargoFiltro.main = {
init:function(){




this.tx_cargo = new Ext.form.TextField({
	fieldLabel:'Tx cargo',
	name:'tx_cargo',
	value:''
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'in_activo',
	checked:true
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'created_at'
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'updated_at'
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.tx_cargo,
                                                                                this.in_activo,
                                                                                this.created_at,
                                                                                this.updated_at,
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
                     CargoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    CargoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    CargoFiltro.main.win.close();
                    CargoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    CargoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    CargoFiltro.main.panelfiltro.getForm().reset();
    CargoLista.main.store_lista.baseParams={}
    CargoLista.main.store_lista.baseParams.paginar = 'si';
    CargoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = CargoFiltro.main.panelfiltro.getForm().getValues();
    CargoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("CargoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        CargoLista.main.store_lista.baseParams.paginar = 'si';
        CargoLista.main.store_lista.baseParams.BuscarBy = true;
        CargoLista.main.store_lista.load();


}

};

Ext.onReady(CargoFiltro.main.init,CargoFiltro.main);
</script>