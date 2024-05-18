<script type="text/javascript">
Ext.ns("ProgramaFiltro");
ProgramaFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_SECTOR = this.getStoreCO_SECTOR();
//<Stores de fk>



this.co_sector = new Ext.form.ComboBox({
	fieldLabel:'Co sector',
	store: this.storeCO_SECTOR,
	typeAhead: true,
	valueField: 'co_sector',
	displayField:'co_sector',
	hiddenName:'co_sector',
	//readOnly:(this.OBJ.co_sector!='')?true:false,
	//style:(this.main.OBJ.co_sector!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_sector',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_SECTOR.load();

this.nu_programa = new Ext.form.TextField({
	fieldLabel:'Nu programa',
	name:'nu_programa',
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
                                                                                                            this.co_sector,
                                                                                this.nu_programa,
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
                     ProgramaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ProgramaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ProgramaFiltro.main.win.close();
                    ProgramaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ProgramaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ProgramaFiltro.main.panelfiltro.getForm().reset();
    ProgramaLista.main.store_lista.baseParams={}
    ProgramaLista.main.store_lista.baseParams.paginar = 'si';
    ProgramaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ProgramaFiltro.main.panelfiltro.getForm().getValues();
    ProgramaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ProgramaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ProgramaLista.main.store_lista.baseParams.paginar = 'si';
        ProgramaLista.main.store_lista.baseParams.BuscarBy = true;
        ProgramaLista.main.store_lista.load();


}
,getStoreCO_SECTOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Programa/storefkcosector',
        root:'data',
        fields:[
            {name: 'co_sector'}
            ]
    });
    return this.store;
}

};

Ext.onReady(ProgramaFiltro.main.init,ProgramaFiltro.main);
</script>