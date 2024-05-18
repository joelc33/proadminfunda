<script type="text/javascript">
Ext.ns("ProductoFiltro");
ProductoFiltro.main = {
init:function(){

//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeCO_UNIDAD_PRODUCTO = this.getStoreCO_UNIDAD_PRODUCTO();
//<Stores de fk>



this.tx_producto = new Ext.form.TextField({
	fieldLabel:'Producto',
	name:'tx_producto',
        width:400,
	value:''
});

this.cod_producto = new Ext.form.TextField({
	fieldLabel:'Codigo',
	name:'cod_producto',
	value:''
});

this.co_clase = new Ext.form.ComboBox({
	fieldLabel:'Clase',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_clase_producto',
	hiddenName:'co_clase',
	//readOnly:(this.OBJ.co_clase!='')?true:false,
	//style:(this.main.OBJ.co_clase!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_clase',
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
                            
                            this.cod_producto,
                            this.tx_producto,
                            this.co_clase
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
                     ProductoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ProductoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ProductoFiltro.main.win.close();
                    ProductoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ProductoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ProductoFiltro.main.panelfiltro.getForm().reset();
    ProductoLista.main.store_lista.baseParams={}
    ProductoLista.main.store_lista.baseParams.paginar = 'si';
    ProductoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ProductoFiltro.main.panelfiltro.getForm().getValues();
    ProductoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ProductoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ProductoLista.main.store_lista.baseParams.paginar = 'si';
        ProductoLista.main.store_lista.baseParams.BuscarBy = true;
        ProductoLista.main.store_lista.load();


}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Producto/storefkcoclase',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_clase_producto'}
            ]
    });
    return this.store;
}
,getStoreCO_UNIDAD_PRODUCTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Producto/storefkcounidadproducto',
        root:'data',
        fields:[
            {name: 'co_unidad_producto'}
            ]
    });
    return this.store;
}

};

Ext.onReady(ProductoFiltro.main.init,ProductoFiltro.main);
</script>