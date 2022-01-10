<script type="text/javascript">
Ext.ns("PoaLista");
PoaLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

//Editar un registro
this.editar= new Ext.Button({
    text:'Sub-Sector',
    iconCls: 'icon-buscar',
    handler:function(){
	this.codigo  = PoaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_sector');
	PoaLista.main.mascara.show();
        this.msg = Ext.get('formularioSubSector');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Poa/subsector/sector/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});

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
		PoaLista.main.store_lista.baseParams={};
		PoaLista.main.store_lista.baseParams.paginar = 'si';
		PoaLista.main.store_lista.load();
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
			PoaLista.main.store_lista.baseParams={};
			PoaLista.main.store_lista.baseParams.BuscarBy = true;
			PoaLista.main.store_lista.baseParams[this.paramName] = v;
			PoaLista.main.store_lista.baseParams.paginar = 'si';
			PoaLista.main.store_lista.load();
		}
	}
});

this.editar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Sectores',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.editar,'-',this.buscador
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_sector',hidden:true, menuDisabled:true,dataIndex: 'co_sector'},
    {header: 'Sector', width:400,  menuDisabled:true, sortable: true,  dataIndex: 'sector'},
    {header: 'Presupuesto', width:200,  menuDisabled:true, sortable: true, renderer: formatoNumero, dataIndex: 'mo_presupuesto'},
    ],
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
      PoaLista.main.editar.enable();
    }},
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

this.gridPanel_.render("contenedorPoaLista");

this.store_lista.load();
this.store_lista.on('load',function(){
  PoaLista.main.editar.disable();
});
this.store_lista.on('beforeload',function(){
  panel_detalle.collapse();
});
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Poa/storelista',
    root:'data',
    fields:[
    {name: 'co_sector'},
    {name: 'de_sector'},
    {name: 'mo_presupuesto'},
    {
        name: 'sector',
        convert: function(v, r) {
            return r.co_sector + ' - ' + r.de_sector;
        }
    }
           ]
    });
    return this.store;
}
};
Ext.onReady(PoaLista.main.init, PoaLista.main);
</script>
<div id="contenedorPoaLista"></div>
<div id="formularioSubSector"></div>
