<script type="text/javascript">
Ext.ns("ejercicioFiltro");
ejercicioFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_USUARIO = this.getStoreCO_USUARIO();
//<Stores de fk>



this.tx_anio_fiscal = new Ext.form.TextField({
	fieldLabel:'Tx anio fiscal',
	name:'tx_anio_fiscal',
	value:''
});

this.fe_apertura = new Ext.form.DateField({
	fieldLabel:'Fe apertura',
	name:'fe_apertura'
});

this.co_usuario = new Ext.form.ComboBox({
	fieldLabel:'Co usuario',
	store: this.storeCO_USUARIO,
	typeAhead: true,
	valueField: 'co_usuario',
	displayField:'co_usuario',
	hiddenName:'co_usuario',
	//readOnly:(this.OBJ.co_usuario!='')?true:false,
	//style:(this.main.OBJ.co_usuario!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_usuario',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_USUARIO.load();

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
                                                                                                            this.tx_anio_fiscal,
                                                                                this.fe_apertura,
                                                                                this.co_usuario,
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
                     ejercicioFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ejercicioFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ejercicioFiltro.main.win.close();
                    ejercicioLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ejercicioLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ejercicioFiltro.main.panelfiltro.getForm().reset();
    ejercicioLista.main.store_lista.baseParams={}
    ejercicioLista.main.store_lista.baseParams.paginar = 'si';
    ejercicioLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ejercicioFiltro.main.panelfiltro.getForm().getValues();
    ejercicioLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ejercicioLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ejercicioLista.main.store_lista.baseParams.paginar = 'si';
        ejercicioLista.main.store_lista.baseParams.BuscarBy = true;
        ejercicioLista.main.store_lista.load();


}
,getStoreCO_USUARIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ejercicio/storefkcousuario',
        root:'data',
        fields:[
            {name: 'co_usuario'}
            ]
    });
    return this.store;
}

};

Ext.onReady(ejercicioFiltro.main.init,ejercicioFiltro.main);
</script>