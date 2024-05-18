<script type="text/javascript">
Ext.ns("ejecutorLista");
ejecutorLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

//Editar un registro
this.editar= new Ext.Button({
    text:'Proyecto / Accion Centralizada',
    iconCls: 'icon-buscar',
    handler:function(){
	this.codigo  = ejecutorLista.main.gridPanel_.getSelectionModel().getSelected().get('co_sub_sector');
  this.id_ejecutor  = ejecutorLista.main.gridPanel_.getSelectionModel().getSelected().get('id_ejecutor');
	ejecutorLista.main.mascara.show();
        this.msg = Ext.get('formularioPrAc');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Poa/prac/subsector/'+this.codigo+'/ejecutor/'+this.id_ejecutor,
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
		ejecutorLista.main.store_lista.baseParams={};
		ejecutorLista.main.store_lista.baseParams.paginar = 'si';
		ejecutorLista.main.store_lista.load();
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
			ejecutorLista.main.store_lista.baseParams={};
			ejecutorLista.main.store_lista.baseParams.BuscarBy = true;
			ejecutorLista.main.store_lista.baseParams[this.paramName] = v;
			ejecutorLista.main.store_lista.baseParams.paginar = 'si';
			ejecutorLista.main.store_lista.load();
		}
	}
});

this.editar.disable();

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
        this.editar,'-',this.buscador
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_sub_sector',hidden:true, menuDisabled:true,dataIndex: 'co_sub_sector'},
    {header: 'id_ejecutor',hidden:true, menuDisabled:true,dataIndex: 'id_ejecutor'},
    {header: 'Ejecutor', width:540,  menuDisabled:true, sortable: true,  dataIndex: 'ejecutor'},
    {header: 'Presupuesto', width:200,  menuDisabled:true, sortable: true, renderer: formatoNumero, dataIndex: 'mo_presupuesto'},
    ],
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
      ejecutorLista.main.editar.enable();
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

//this.gridPanel_.render("contenedorejecutorLista");

this.winformPanel_ = new Ext.Window({
    title:'Sector > Sub Sector > Ejecutores',
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

ejecutorLista.main.store_lista.baseParams.co_sub_sector=ejecutorLista.main.OBJ.co_sub_sector;
this.store_lista.load();
this.store_lista.on('load',function(){
  ejecutorLista.main.editar.disable();
});
this.store_lista.on('beforeload',function(){
  panel_detalle.collapse();
});
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Poa/storelistaejecutor',
    root:'data',
    fields:[
    {name: 'co_sub_sector'},
    {name: 'id_ejecutor'},
    {name: 'de_ejecutor'},
    {name: 'mo_presupuesto'},
    {
        name: 'ejecutor',
        convert: function(v, r) {
            return r.id_ejecutor + ' - ' + r.de_ejecutor;
        }
    }
           ]
    });
    return this.store;
}
};
Ext.onReady(ejecutorLista.main.init, ejecutorLista.main);
</script>
<div id="contenedorejecutorLista"></div>
<div id="formularioPrAc"></div>
