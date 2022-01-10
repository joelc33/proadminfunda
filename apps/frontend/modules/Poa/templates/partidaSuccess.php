<script type="text/javascript">
Ext.ns("partidaLista");
partidaLista.main = {
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
		partidaLista.main.store_lista.baseParams={};
		partidaLista.main.store_lista.baseParams.paginar = 'si';
		partidaLista.main.store_lista.load();
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
			partidaLista.main.store_lista.baseParams={};
			partidaLista.main.store_lista.baseParams.BuscarBy = true;
			partidaLista.main.store_lista.baseParams[this.paramName] = v;
			partidaLista.main.store_lista.baseParams.paginar = 'si';
			partidaLista.main.store_lista.load();
		}
	}
});

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    //title:'Lista de Sectores',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
    border:false,
//    frame:true,
    height:510,
    tbar:[
        '-',this.buscador
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_partida',hidden:true, menuDisabled:true,dataIndex: 'co_partida'},
    {header: 'Codigo', width:100,  menuDisabled:true, sortable: true, dataIndex: 'cu_partida'},
    {header: 'Denominacion', width:440,  menuDisabled:true, sortable: true, dataIndex: 'de_denominacion'},
    {header: 'Presupuesto', width:200,  menuDisabled:true, sortable: true, renderer: formatoNumero, dataIndex: 'mo_presupuesto'},
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

//this.gridPanel_.render("contenedorpartidaLista");

this.winformPanel_ = new Ext.Window({
    title:'Sector > Sub Sector > Ejecutores > Proyecto / Accion Centralizada > Acciones Especificas > Partidas',
    modal:true,
    constrain:true,
    width:800,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.gridPanel_
    ]
});
this.winformPanel_.show();
PoaLista.main.mascara.hide();

partidaLista.main.store_lista.baseParams.prac=partidaLista.main.OBJ.prac;
partidaLista.main.store_lista.baseParams.ae=partidaLista.main.OBJ.ae;
this.store_lista.load();
this.store_lista.on('beforeload',function(){
  panel_detalle.collapse();
});
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Poa/storelistapartida',
    root:'data',
    fields:[
    {name: 'co_partida'},
    {name: 'cu_partida'},
    {name: 'de_denominacion'},
    {name: 'mo_presupuesto'},
    {
        name: 'partida',
        convert: function(v, r) {
            return r.cu_partida + ' - ' + r.de_denominacion;
        }
    }
           ]
    });
    return this.store;
}
};
Ext.onReady(partidaLista.main.init, partidaLista.main);
</script>
<div id="contenedorpartidaLista"></div>
<div id="formularioAe"></div>
