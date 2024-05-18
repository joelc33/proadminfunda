<script type="text/javascript">
Ext.ns("NominaPeriodoEditar");
NominaPeriodoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_TP_NOMINA = this.getStoreCO_TP_NOMINA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_NOM_FRECUENCIA_PAGO = this.getStoreCO_NOM_FRECUENCIA_PAGO();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//objeto store
this.store_lista = this.getLista();
//<Stores de fk>
this.storeCO_GRUPO_NOMINA = this.getStoreCO_GRUPO_NOMINA();
//<Stores de fk>

//<ClavePrimaria>
this.co_nomina = new Ext.form.Hidden({
    name:'co_nomina',
    value:this.OBJ.co_nomina});
//</ClavePrimaria>

//<ClavePrimaria>
this.co_solicitud = new Ext.form.Hidden({
    name:'tbrh013_nomina[co_solicitud]',
    value:this.OBJ.co_solicitud});
//</ClavePrimaria>

this.co_tp_nomina = new Ext.form.ComboBox({
	fieldLabel:'Nomina',
	store: this.storeCO_TP_NOMINA,
	typeAhead: true,
	valueField: 'co_tp_nomina',
	displayField:'nomina',
	hiddenName:'tbrh013_nomina[co_tp_nomina]',
	//readOnly:(this.OBJ.co_tp_nomina!='')?true:false,
	//style:(this.main.OBJ.co_tp_nomina!='')?'background:#c9c9c9;':'',
    readOnly:true,
    style:'background:#E5E5FF;',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Nomina...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeCO_TP_NOMINA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tp_nomina,
	value:  this.OBJ.co_tp_nomina,
	objStore: this.storeCO_TP_NOMINA
});

this.co_grupo_nomina = new Ext.form.ComboBox({
	fieldLabel:'Sub-Grupo',
	store: this.storeCO_GRUPO_NOMINA,
	typeAhead: true,
	valueField: 'co_grupo_nomina',
	displayField:'cod_grupo_nomina',
	hiddenName:'tbrh013_nomina[co_grupo_nomina]',
    readOnly:true,
    style:'background:#E5E5FF;',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Grupo...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false,
	listeners:{
		select: function(){
			NominaPeriodoEditar.main.cargarDisponible(this.getValue());
		}
	}
});
/*
this.storeCO_CUENTA_BANCARIA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_grupo_nomina,
	value:  this.OBJ.co_grupo_nomina,
	objStore: this.storeCO_CUENTA_BANCARIA
});*/

if(this.OBJ.co_tp_nomina){
  	this.storeCO_GRUPO_NOMINA.load({
		params: {
			tipo:this.OBJ.co_tp_nomina
		},
		callback: function(){
			NominaPeriodoEditar.main.co_grupo_nomina.setValue(NominaPeriodoEditar.main.OBJ.co_grupo_nomina);
		}
	});

}

this.co_nom_frecuencia_pago = new Ext.form.ComboBox({
	fieldLabel:'Frecuencia de Pago',
	store: this.storeCO_NOM_FRECUENCIA_PAGO,
	typeAhead: true,
	valueField: 'co_nom_frecuencia_pago',
	displayField:'tx_nom_frecuencia_pago',
	hiddenName:'tbrh013_nomina[co_nom_frecuencia_pago]',
	//readOnly:(this.OBJ.co_nom_frecuencia_pago!='')?true:false,
	//style:(this.main.OBJ.co_nom_frecuencia_pago!='')?'background:#c9c9c9;':'',
    readOnly:true,
    style:'background:#E5E5FF;',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Frecuencia...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeCO_NOM_FRECUENCIA_PAGO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_nom_frecuencia_pago,
	value:  this.OBJ.co_nom_frecuencia_pago,
	objStore: this.storeCO_NOM_FRECUENCIA_PAGO
});

this.de_observacion = new Ext.form.TextArea({
	fieldLabel:'Observacion',
	name:'tbrh013_nomina[de_observacion]',
	value:this.OBJ.de_observacion,
	allowBlank:false,
	width:400,
    readOnly:true,
    style:'background:#E5E5FF;',
});

this.fe_inicio = new Ext.form.DateField({
	fieldLabel:'Fecha Inicio',
	name:'tbrh013_nomina[fe_inicio]',
	value:this.OBJ.fe_inicio,
	allowBlank:false,
	width:100,
    readOnly:true,
    style:'background:#E5E5FF;',
});

this.fe_fin = new Ext.form.DateField({
	fieldLabel:'Fecha Cierre',
	name:'tbrh013_nomina[fe_fin]',
	value:this.OBJ.fe_fin,
	allowBlank:false,
	width:100,
    readOnly:true,
    style:'background:#E5E5FF;',
});

this.fe_pago = new Ext.form.DateField({
	fieldLabel:'Fecha de Pago',
	name:'tbrh013_nomina[fe_pago]',
	value:this.OBJ.fe_pago,
	allowBlank:false,
	width:100,
    readOnly:true,
    style:'background:#E5E5FF;',
});

this.id_tbrh060_nomina_estatus = new Ext.form.ComboBox({
	fieldLabel:'Id tbrh060 nomina estatus',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'tbrh013_nomina[id_tbrh060_nomina_estatus]',
	//readOnly:(this.OBJ.id_tbrh060_nomina_estatus!='')?true:false,
	//style:(this.main.OBJ.id_tbrh060_nomina_estatus!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tbrh060_nomina_estatus',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tbrh060_nomina_estatus,
	value:  this.OBJ.id_tbrh060_nomina_estatus,
	objStore: this.storeID
});

function renderMonto(val, attr, record) {
     return paqueteComunJS.funcion.getNumeroFormateado(val);
}

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    //title:'Lista de NominaPeriodo',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
	border: false,
//    frame:true,
    height:300,
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_nomina',hidden:true, menuDisabled:true,dataIndex: 'co_nomina'},
	{header: 'Codigo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_concepto'},
	{header: 'Descripcion', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'tx_concepto'},
	{header: 'Partida Presup.', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cuenta_presupuesto'},
    {header: 'Tipo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tp_concepto'},
    {header: 'Monto', width:150,  menuDisabled:true, sortable: true, renderer:renderMonto, dataIndex: 'nu_monto'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    bbar: new Ext.PagingToolbar({
        pageSize: 100,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:900,
	labelWidth: 150,
	border: false,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_nomina,
                    this.co_solicitud,
                    this.co_tp_nomina,
                    this.co_grupo_nomina,
					this.de_observacion,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Resumen por Concepto',
    modal:true,
    constrain:true,
width:914,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.formPanel_,
		this.gridPanel_
    ]
});
this.winformPanel_.show();
NominaPeriodoLista.main.mascara.hide();

this.store_lista.baseParams.co_nomina=NominaPeriodoEditar.main.OBJ.co_nomina;
this.store_lista.baseParams.co_grupo_nomina=NominaPeriodoEditar.main.OBJ.co_grupo_nomina;
this.store_lista.load();

}
,getStoreCO_TP_NOMINA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/storefkcotpnomina',
        root:'data',
        fields:[
            {name: 'co_tp_nomina'},{name: 'tx_tp_nomina'},
			{
				name: 'nomina',
				convert: function(v, r) {
						return r.nu_nomina + ' - ' + r.tx_tp_nomina;
				}
		    }
            ]
    });
    return this.store;
}
,getStoreCO_NOM_FRECUENCIA_PAGO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/storefkconomfrecuenciapago',
        root:'data',
        fields:[
            {name: 'co_nom_frecuencia_pago'},{name: 'tx_nom_frecuencia_pago'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/storefkidtbrh060nominaestatus',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/storelistaTipoConcepto',
    root:'data',
    fields:[
		{name: 'nu_concepto'},
		{name: 'tx_concepto'},
		{name: 'tx_tp_concepto'},
		{name: 'nu_monto'},
		{name: 'nu_cuenta_presupuesto'},
           ]
    });
    return this.store;
},
getStoreCO_GRUPO_NOMINA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoTipo/storefkcogruponomina',
        root:'data',
        fields:[
            {name: 'co_grupo_nomina'},
            {name: 'cod_grupo_nomina'},
            {name: 'tx_grupo_nomina'},
            {
				name: 'grupo',
				convert: function(v, r) {
						return r.cod_grupo_nomina + ' - ' + r.tx_grupo_nomina;
				}
		    }
            ]
    });
    return this.store;
}
};
Ext.onReady(NominaPeriodoEditar.main.init, NominaPeriodoEditar.main);
</script>
