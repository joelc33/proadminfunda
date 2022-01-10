<script type="text/javascript">
Ext.ns("PartidaFiltro");
PartidaFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_ANIO_FISCAL = this.getStoreCO_ANIO_FISCAL();
//<Stores de fk>



this.co_partida = new Ext.form.TextField({
	fieldLabel:'Codigo',
	name:'co_partida',
	value:'',
	width:200
});

this.nu_partida = new Ext.form.TextField({
	fieldLabel:'Numero',
	name:'nu_partida',
	value:'',
	width:200
});

this.de_partida = new Ext.form.TextField({
	fieldLabel:'Denominacion',
	name:'de_partida',
	value:'',
	width:200
});

this.id_tb013_anio_fiscal = new Ext.form.ComboBox({
	fieldLabel:'Ejercicio Fiscal',
	store: this.storeCO_ANIO_FISCAL,
	typeAhead: true,
	valueField: 'co_anio_fiscal',
	displayField:'co_anio_fiscal',
	hiddenName:'id_tb013_anio_fiscal',
	//readOnly:(this.OBJ.id_tb013_anio_fiscal!='')?true:false,
	//style:(this.main.OBJ.id_tb013_anio_fiscal!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Ejercicio Fiscal',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_ANIO_FISCAL.load();


this.nu_nivel = new Ext.form.NumberField({
	fieldLabel:'Nivel',
	name:'nu_nivel',
	value:'',
	width:100
});

this.nu_pa = new Ext.form.TextField({
	fieldLabel:'PA',
	name:'nu_pa',
	value:'',
	width:100
});

this.nu_ge = new Ext.form.TextField({
	fieldLabel:'GE',
	name:'nu_ge',
	value:'',
	width:100
});

this.nu_es = new Ext.form.TextField({
	fieldLabel:'ES',
	name:'nu_es',
	value:'',
	width:100
});

this.nu_se = new Ext.form.TextField({
	fieldLabel:'SE',
	name:'nu_se',
	value:'',
	width:100
});

this.nu_sse = new Ext.form.TextField({
	fieldLabel:'SSE',
	name:'nu_sse',
	value:'',
	width:100
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_partida,
                                                                                this.nu_partida,
                                                                                this.de_partida,
                                                                                this.id_tb013_anio_fiscal,
                                                                                this.nu_nivel,
                                                                                this.nu_pa,
                                                                                this.nu_ge,
                                                                                this.nu_es,
                                                                                this.nu_se,
                                                                                this.nu_sse,
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
                     PartidaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    PartidaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    PartidaFiltro.main.win.close();
                    PartidaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    PartidaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    PartidaFiltro.main.panelfiltro.getForm().reset();
    PartidaLista.main.store_lista.baseParams={}
    PartidaLista.main.store_lista.baseParams.paginar = 'si';
    PartidaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = PartidaFiltro.main.panelfiltro.getForm().getValues();
    PartidaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("PartidaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        PartidaLista.main.store_lista.baseParams.paginar = 'si';
        PartidaLista.main.store_lista.baseParams.BuscarBy = true;
        PartidaLista.main.store_lista.load();


}
,getStoreCO_ANIO_FISCAL:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partida/storefkidtb013aniofiscal',
        root:'data',
        fields:[
            {name: 'co_anio_fiscal'}
            ]
    });
    return this.store;
}

};

Ext.onReady(PartidaFiltro.main.init,PartidaFiltro.main);
</script>
