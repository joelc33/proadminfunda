<script type="text/javascript">
Ext.ns("MovimientoFiltro");
MovimientoFiltro.main = {
init:function(){

//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>

this.mo_movimiento = new Ext.form.NumberField({
	fieldLabel:'Monto',
name:'mo_movimiento',
	value:'',
	width:200
});

this.id_tb088_tipo_movimiento = new Ext.form.ComboBox({
	fieldLabel:'Tipo',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'id_tb088_tipo_movimiento',
	//readOnly:(this.OBJ.id_tb088_tipo_movimiento!='')?true:false,
	//style:(this.main.OBJ.id_tb088_tipo_movimiento!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Tipo',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.nu_referencia = new Ext.form.TextField({
	fieldLabel:'Referencia',
	name:'nu_referencia',
	value:'',
	width:200
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[

                                                                                this.mo_movimiento,
                                                                                this.id_tb088_tipo_movimiento,
                                                                                this.nu_referencia
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
                     MovimientoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    MovimientoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    MovimientoFiltro.main.win.close();
                    MovimientoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    MovimientoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    MovimientoFiltro.main.panelfiltro.getForm().reset();
    MovimientoLista.main.store_lista.baseParams={}
    MovimientoLista.main.store_lista.baseParams.paginar = 'si';
    MovimientoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = MovimientoFiltro.main.panelfiltro.getForm().getValues();
    MovimientoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("MovimientoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        MovimientoLista.main.store_lista.baseParams.paginar = 'si';
        MovimientoLista.main.store_lista.baseParams.BuscarBy = true;
        MovimientoLista.main.store_lista.load();


}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/storefkidtb085presupuesto',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/storefkidtb088tipomovimiento',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}

};

Ext.onReady(MovimientoFiltro.main.init,MovimientoFiltro.main);
</script>
