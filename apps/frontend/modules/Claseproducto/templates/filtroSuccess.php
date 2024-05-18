<script type="text/javascript">
Ext.ns("ClaseproductoFiltro");
ClaseproductoFiltro.main = {
init:function(){

//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>



this.de_clase_producto = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'de_clase_producto',
	value:'',
	width:400
});

this.id_tb093_familia_producto = new Ext.form.ComboBox({
	fieldLabel:'Familia Producto',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_familia_producto',
	hiddenName:'id_tb093_familia_producto',
	//readOnly:(this.OBJ.id_tb093_familia_producto!='')?true:false,
	//style:(this.main.OBJ.id_tb093_familia_producto!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Familia Producto',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                          this.id_tb093_familia_producto,
													this.de_clase_producto,
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
                     ClaseproductoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ClaseproductoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ClaseproductoFiltro.main.win.close();
                    ClaseproductoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ClaseproductoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ClaseproductoFiltro.main.panelfiltro.getForm().reset();
    ClaseproductoLista.main.store_lista.baseParams={}
    ClaseproductoLista.main.store_lista.baseParams.paginar = 'si';
    ClaseproductoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ClaseproductoFiltro.main.panelfiltro.getForm().getValues();
    ClaseproductoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ClaseproductoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ClaseproductoLista.main.store_lista.baseParams.paginar = 'si';
        ClaseproductoLista.main.store_lista.baseParams.BuscarBy = true;
        ClaseproductoLista.main.store_lista.load();


}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Claseproducto/storefkidtb093familiaproducto',
        root:'data',
        fields:[
            {name: 'id'},{name: 'de_familia_producto'}
            ]
    });
    return this.store;
}

};

Ext.onReady(ClaseproductoFiltro.main.init,ClaseproductoFiltro.main);
</script>
