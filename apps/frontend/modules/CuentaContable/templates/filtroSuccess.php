<script type="text/javascript">
Ext.ns("CuentaContableFiltro");
CuentaContableFiltro.main = {
init:function(){

//<Stores de fk>


this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'Descripcion Cuenta',
	name:'tx_descripcion',
	value:''
});

this.nu_cuenta_contable = new Ext.form.TextField({
	fieldLabel:'Cuenta Contable (sin puntos)',
	name:'nu_cuenta_contable',
	value:''
});

this.nu_nivel = new Ext.form.NumberField({
	fieldLabel:'Nivel',
	name:'nu_nivel',
	value:''
});


    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                        this.tx_descripcion,
                        this.nu_cuenta_contable,
                        this.nu_nivel
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
                     CuentaContableFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    CuentaContableFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    CuentaContableFiltro.main.win.close();
                    CuentaContable.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    CuentaContable.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    CuentaContableFiltro.main.panelfiltro.getForm().reset();
    CuentaContable.main.store_lista.baseParams={}
    CuentaContable.main.store_lista.baseParams.paginar = 'si';
    CuentaContable.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = CuentaContableFiltro.main.panelfiltro.getForm().getValues();
    CuentaContable.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("CuentaContable.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        CuentaContable.main.store_lista.baseParams.paginar = 'si';
        CuentaContable.main.store_lista.baseParams.BuscarBy = true;
        CuentaContable.main.store_lista.load();


}

};

Ext.onReady(CuentaContableFiltro.main.init,CuentaContableFiltro.main);
</script>