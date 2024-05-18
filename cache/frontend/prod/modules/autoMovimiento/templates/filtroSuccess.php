<script type="text/javascript">
Ext.ns("MovimientoFiltro");
MovimientoFiltro.main = {
init:function(){

//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeCO_USUARIO = this.getStoreCO_USUARIO();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeCO_COMPRAS = this.getStoreCO_COMPRAS();
//<Stores de fk>



this.co_partida = new Ext.form.ComboBox({
	fieldLabel:'Co partida',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'co_partida',
	//readOnly:(this.OBJ.co_partida!='')?true:false,
	//style:(this.main.OBJ.co_partida!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_partida',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.nu_monto = new Ext.form.NumberField({
	fieldLabel:'Nu monto',
name:'nu_monto',
	value:''
});

this.nu_anio = new Ext.form.NumberField({
	fieldLabel:'Nu anio',
name:'nu_anio',
	value:''
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'created_at'
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'updated_at'
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

this.co_tipo_movimiento = new Ext.form.ComboBox({
	fieldLabel:'Co tipo movimiento',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'co_tipo_movimiento',
	//readOnly:(this.OBJ.co_tipo_movimiento!='')?true:false,
	//style:(this.main.OBJ.co_tipo_movimiento!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tipo_movimiento',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.co_detalle_compra = new Ext.form.NumberField({
	fieldLabel:'Co detalle compra',
	name:'co_detalle_compra',
	value:''
});

this.tx_observacion = new Ext.form.TextField({
	fieldLabel:'Tx observacion',
	name:'tx_observacion',
	value:''
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'in_activo',
	checked:true
});

this.co_compra_servicio = new Ext.form.ComboBox({
	fieldLabel:'Co compra servicio',
	store: this.storeCO_COMPRAS,
	typeAhead: true,
	valueField: 'co_compras',
	displayField:'co_compras',
	hiddenName:'co_compra_servicio',
	//readOnly:(this.OBJ.co_compra_servicio!='')?true:false,
	//style:(this.main.OBJ.co_compra_servicio!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_compra_servicio',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_COMPRAS.load();

this.co_factura = new Ext.form.NumberField({
	fieldLabel:'Co factura',
	name:'co_factura',
	value:''
});

this.mo_saldo_anterior = new Ext.form.NumberField({
	fieldLabel:'Mo saldo anterior',
name:'mo_saldo_anterior',
	value:''
});

this.mo_saldo_nuevo = new Ext.form.NumberField({
	fieldLabel:'Mo saldo nuevo',
name:'mo_saldo_nuevo',
	value:''
});

this.co_solicitud_anular = new Ext.form.NumberField({
	fieldLabel:'Co solicitud anular',
	name:'co_solicitud_anular',
	value:''
});

this.in_anular = new Ext.form.Checkbox({
	fieldLabel:'In anular',
	name:'in_anular',
	checked:true
});

this.in_cerrado = new Ext.form.Checkbox({
	fieldLabel:'In cerrado',
	name:'in_cerrado',
	checked:true
});

this.nu_monto_soberano = new Ext.form.NumberField({
	fieldLabel:'Nu monto soberano',
name:'nu_monto_soberano',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_partida,
                                                                                this.nu_monto,
                                                                                this.nu_anio,
                                                                                this.created_at,
                                                                                this.updated_at,
                                                                                this.co_usuario,
                                                                                this.co_tipo_movimiento,
                                                                                this.co_detalle_compra,
                                                                                this.tx_observacion,
                                                                                this.in_activo,
                                                                                this.co_compra_servicio,
                                                                                this.co_factura,
                                                                                this.mo_saldo_anterior,
                                                                                this.mo_saldo_nuevo,
                                                                                this.co_solicitud_anular,
                                                                                this.in_anular,
                                                                                this.in_cerrado,
                                                                                this.nu_monto_soberano,
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
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/storefkcopartida',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreCO_USUARIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/storefkcousuario',
        root:'data',
        fields:[
            {name: 'co_usuario'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/storefkcotipomovimiento',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreCO_COMPRAS:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/storefkcocompraservicio',
        root:'data',
        fields:[
            {name: 'co_compras'}
            ]
    });
    return this.store;
}

};

Ext.onReady(MovimientoFiltro.main.init,MovimientoFiltro.main);
</script>