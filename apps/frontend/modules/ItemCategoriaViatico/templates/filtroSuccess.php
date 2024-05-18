<script type="text/javascript">
Ext.ns("ItemCategoriaViaticoFiltro");
ItemCategoriaViaticoFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_CATEGORIA = this.getStoreCO_CATEGORIA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_ITEM_VIATICO = this.getStoreCO_ITEM_VIATICO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TIPO_VIATICO = this.getStoreCO_TIPO_VIATICO();
//<Stores de fk>



this.co_categoria = new Ext.form.ComboBox({
	fieldLabel:'Co categoria',
	store: this.storeCO_CATEGORIA,
	typeAhead: true,
	valueField: 'co_categoria',
	displayField:'co_categoria',
	hiddenName:'co_categoria',
	//readOnly:(this.OBJ.co_categoria!='')?true:false,
	//style:(this.main.OBJ.co_categoria!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_categoria',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_CATEGORIA.load();

this.co_item_viatico = new Ext.form.ComboBox({
	fieldLabel:'Co item viatico',
	store: this.storeCO_ITEM_VIATICO,
	typeAhead: true,
	valueField: 'co_item_viatico',
	displayField:'co_item_viatico',
	hiddenName:'co_item_viatico',
	//readOnly:(this.OBJ.co_item_viatico!='')?true:false,
	//style:(this.main.OBJ.co_item_viatico!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_item_viatico',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_ITEM_VIATICO.load();

this.cant_ut = new Ext.form.NumberField({
	fieldLabel:'Cant ut',
name:'cant_ut',
	value:''
});

this.co_tipo_viatico = new Ext.form.ComboBox({
	fieldLabel:'Co tipo viatico',
	store: this.storeCO_TIPO_VIATICO,
	typeAhead: true,
	valueField: 'co_tipo_viatico',
	displayField:'co_tipo_viatico',
	hiddenName:'co_tipo_viatico',
	//readOnly:(this.OBJ.co_tipo_viatico!='')?true:false,
	//style:(this.main.OBJ.co_tipo_viatico!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tipo_viatico',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_VIATICO.load();

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_categoria,
                                                                                this.co_item_viatico,
                                                                                this.cant_ut,
                                                                                this.co_tipo_viatico,
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
                     ItemCategoriaViaticoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ItemCategoriaViaticoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ItemCategoriaViaticoFiltro.main.win.close();
                    ItemCategoriaViaticoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ItemCategoriaViaticoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ItemCategoriaViaticoFiltro.main.panelfiltro.getForm().reset();
    ItemCategoriaViaticoLista.main.store_lista.baseParams={}
    ItemCategoriaViaticoLista.main.store_lista.baseParams.paginar = 'si';
    ItemCategoriaViaticoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ItemCategoriaViaticoFiltro.main.panelfiltro.getForm().getValues();
    ItemCategoriaViaticoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ItemCategoriaViaticoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ItemCategoriaViaticoLista.main.store_lista.baseParams.paginar = 'si';
        ItemCategoriaViaticoLista.main.store_lista.baseParams.BuscarBy = true;
        ItemCategoriaViaticoLista.main.store_lista.load();


}
,getStoreCO_CATEGORIA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ItemCategoriaViatico/storefkcocategoria',
        root:'data',
        fields:[
            {name: 'co_categoria'}
            ]
    });
    return this.store;
}
,getStoreCO_ITEM_VIATICO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ItemCategoriaViatico/storefkcoitemviatico',
        root:'data',
        fields:[
            {name: 'co_item_viatico'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_VIATICO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ItemCategoriaViatico/storefkcotipoviatico',
        root:'data',
        fields:[
            {name: 'co_tipo_viatico'}
            ]
    });
    return this.store;
}

};

Ext.onReady(ItemCategoriaViaticoFiltro.main.init,ItemCategoriaViaticoFiltro.main);
</script>