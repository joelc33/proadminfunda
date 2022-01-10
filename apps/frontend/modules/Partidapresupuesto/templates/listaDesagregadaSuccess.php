<script type="text/javascript">
Ext.ns("PartidapresupuestoListaDesagregada");
PartidapresupuestoListaDesagregada.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

this.buscador = new Ext.form.TwinTriggerField({
	initComponent : function(){
		Ext.ux.form.SearchField.superclass.initComponent.call(this);
		this.on('specialkey', function(f, e){
			if(e.getKey() == e.ENTER){
				this.onTrigger2Click();
			}
		}, this);
	},
	xtype: 'twintriggerfield',
	trigger1Class: 'x-form-clear-trigger',
	trigger2Class: 'x-form-search-trigger',
	enableKeyEvents : true,
	validationEvent:false,
	validateOnBlur:false,
	emptyText: 'Campo de Filtro',
	width:350,
	hasSearch : false,
	paramName : 'variable',
	onTrigger1Click : function() {
		if (this.hiddenField) {
			this.hiddenField.value = '';
		}
		this.setRawValue('');
		this.lastSelectionText = '';
		this.applyEmptyText();
		this.value = '';
		this.fireEvent('clear', this);
		PartidapresupuestoListaDesagregada.main.store_lista.baseParams={};
		PartidapresupuestoListaDesagregada.main.store_lista.baseParams.paginar = 'si';
    PartidapresupuestoListaDesagregada.main.store_lista.baseParams.codigo = PartidapresupuestoListaDesagregada.main.OBJ.codigo;
		PartidapresupuestoListaDesagregada.main.store_lista.load();
	},
	onTrigger2Click : function(){
		var v = this.getRawValue();
		if(v.length < 1){
			    Ext.MessageBox.show({
				       title: 'Notificación',
				       msg: 'Debe ingresar un parametro de busqueda',
				       buttons: Ext.MessageBox.OK,
				       icon: Ext.MessageBox.WARNING
			    });
		}else{
			PartidapresupuestoListaDesagregada.main.store_lista.baseParams={};
			PartidapresupuestoListaDesagregada.main.store_lista.baseParams.BuscarBy = true;
			PartidapresupuestoListaDesagregada.main.store_lista.baseParams[this.paramName] = v;
			PartidapresupuestoListaDesagregada.main.store_lista.baseParams.paginar = 'si';
      PartidapresupuestoListaDesagregada.main.store_lista.baseParams.codigo = PartidapresupuestoListaDesagregada.main.OBJ.codigo;
			PartidapresupuestoListaDesagregada.main.store_lista.load();
		}
	}
});

this.editar= new Ext.Button({
    text:'Movimientos',
    iconCls: 'icon-reporteest',
    handler:function(){
	//PartidapresupuestoLista.main.mascara.show();
        this.msg = Ext.get('formularioPartidapresupuesto');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/lista',
         scripts: true,
         text: "Cargando..",
         params:{
             codigo: PartidapresupuestoListaDesagregada.main.gridPanel_.getSelectionModel().getSelected().get('id')
         }
        });
    }
});

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    //title:'Lista de Partidapresupuesto',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:520,
    border:false,
    tbar:[
        this.editar,'-',this.buscador
    ],
    columns: [
    new Ext.grid.RowNumberer(),
        {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},    
        {header: 'Codigo', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'nu_partida'},
        {header: 'Cod. Contable', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_cuenta'},
        {header: 'Descripcion', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'de_partida'},
        {header: 'Inicial', width:100,  menuDisabled:true, sortable: true, renderer: formatoNumero, dataIndex: 'mo_inicial'},
        {header: 'Modificado', width:100,  menuDisabled:true, sortable: true, renderer: formatoNumero, dataIndex: 'mo_actualizado'},
        {header: 'Comprometido', width:80,  menuDisabled:true, sortable: true, renderer: formatoNumero, dataIndex: 'mo_comprometido'},
        {header: 'Causado', width:100,  menuDisabled:true, sortable: true, renderer: formatoNumero, dataIndex: 'mo_causado'},
        {header: 'Pagado', width:100,  menuDisabled:true, sortable: true, renderer: formatoNumero, dataIndex: 'mo_pagado'},
        {header: 'Disponible', width:150,  menuDisabled:true, sortable: true, renderer: formatoNumero, dataIndex: 'mo_disponible'},
        {header: 'Aplicación', width:350,  menuDisabled:true, sortable: true,  dataIndex: 'aplicacion'}
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

//this.gridPanel_.render("contenedorPartidapresupuestoListaDesagregada");

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Partidas',
    modal:true,
    constrain:true,
    width:1200,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.gridPanel_
    ]
});
this.winformPanel_.show();
PartidapresupuestoListaDesagregada.main.mascara.hide();

PartidapresupuestoListaDesagregada.main.store_lista.baseParams.nu_partida=PartidapresupuestoListaDesagregada.main.OBJ.nu_partida;
PartidapresupuestoListaDesagregada.main.store_lista.baseParams.co_accion_especifica=PartidapresupuestoListaDesagregada.main.OBJ.co_accion_especifica;
this.store_lista.load();

},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/storelistaDesagregada',
    root:'data',
    fields:[
            {name: 'id'},
            {name: 'id_tb084_accion_especifica'},
            {name: 'nu_partida'},
            {name: 'de_partida'},
            {name: 'mo_inicial'},
            {name: 'mo_actualizado'},
            {name: 'mo_precomprometido'},
            {name: 'mo_comprometido'},
            {name: 'mo_causado'},
            {name: 'mo_pagado'},
            {name: 'mo_disponible'},
            {name: 'tx_cuenta'},
            {name: 'nu_nivel'},
            {name: 'aplicacion'}
           ]
    });
    return this.store;
}
};
Ext.onReady(PartidapresupuestoListaDesagregada.main.init, PartidapresupuestoListaDesagregada.main);
</script>
<div id="contenedorPartidapresupuestoListaDesagregada"></div>
<div id="formularioPartidapresupuesto"></div>
<div id="filtroPartidapresupuesto"></div>
