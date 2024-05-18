<script type="text/javascript">
Ext.ns("TramiteFiltro");
TramiteFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_PROCESO = this.getStoreCO_PROCESO();
//<Stores de fk>



this.tx_tipo_solicitud = new Ext.form.TextField({
	fieldLabel:'Tramite',
	name:'tx_tipo_solicitud',
	value:''
});

this.in_ver = new Ext.form.Checkbox({
	fieldLabel:'Ver',
	name:'in_ver',
	checked:true
});

this.co_proceso = new Ext.form.ComboBox({
	fieldLabel:'Proceso',
	store: this.storeCO_PROCESO,
	typeAhead: true,
	valueField: 'co_proceso',
	displayField:'tx_proceso',
	hiddenName:'tx_proceso',
	//readOnly:(this.OBJ.co_proceso!='')?true:false,
	//style:(this.main.OBJ.co_proceso!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_PROCESO.load();

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[this.tx_tipo_solicitud,
                          this.co_proceso]
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
                     TramiteFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    TramiteFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    TramiteFiltro.main.win.close();
                    TramiteLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    TramiteLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    TramiteFiltro.main.panelfiltro.getForm().reset();
    TramiteLista.main.store_lista.baseParams={}
    TramiteLista.main.store_lista.baseParams.paginar = 'si';
    TramiteLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = TramiteFiltro.main.panelfiltro.getForm().getValues();
    TramiteLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("TramiteLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        TramiteLista.main.store_lista.baseParams.paginar = 'si';
        TramiteLista.main.store_lista.baseParams.BuscarBy = true;
        TramiteLista.main.store_lista.load();


}
,getStoreCO_PROCESO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Tramite/storefkcoproceso',
        root:'data',
        fields:[
            {name: 'co_proceso'},
            {name: 'tx_proceso'}
            ]
    });
    return this.store;
}

};

Ext.onReady(TramiteFiltro.main.init,TramiteFiltro.main);
</script>