<script type="text/javascript">
Ext.ns("actividadLista");
actividadLista.main = {
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
		actividadLista.main.store_lista.baseParams={};
		actividadLista.main.store_lista.baseParams.paginar = 'si';
		actividadLista.main.store_lista.load();
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
			actividadLista.main.store_lista.baseParams={};
			actividadLista.main.store_lista.baseParams.BuscarBy = true;
			actividadLista.main.store_lista.baseParams[this.paramName] = v;
			actividadLista.main.store_lista.baseParams.paginar = 'si';
			actividadLista.main.store_lista.load();
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
    {header: 'Actividad', width:740,  menuDisabled:true, sortable: true, renderer: textoLargo, dataIndex: 'actividad'},
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

//this.gridPanel_.render("contenedoractividadLista");

this.winformPanel_ = new Ext.Window({
    title:'Sector > Sub Sector > Ejecutores > Proyecto / Accion Centralizada > Acciones Especificas > Actividades',
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

actividadLista.main.store_lista.baseParams.prac=actividadLista.main.OBJ.prac;
actividadLista.main.store_lista.baseParams.ae=actividadLista.main.OBJ.ae;
this.store_lista.load();
this.store_lista.on('beforeload',function(){
  panel_detalle.collapse();
});
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Poa/storelistaactividad',
    root:'data',
    fields:[
    {name: 'nu_actividad'},
    {name: 'nb_meta'},
    {name: 'mo_presupuesto'},
    {
        name: 'actividad',
        convert: function(v, r) {
            return r.nu_actividad + ' - ' + r.nb_meta;
        }
    }
           ]
    });
    return this.store;
}
};
Ext.onReady(actividadLista.main.init, actividadLista.main);
</script>
<div id="contenedoractividadLista"></div>
