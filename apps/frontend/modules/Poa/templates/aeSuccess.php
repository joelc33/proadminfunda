<script type="text/javascript">
Ext.ns("aeLista");
aeLista.main = {
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
    text:'Partidas',
    iconCls: 'icon-buscar',
    handler:function(){
	this.codigo  = aeLista.main.gridPanel_.getSelectionModel().getSelected().get('nu_ae');
  this.nu_pr_ac  = aeLista.main.gridPanel_.getSelectionModel().getSelected().get('nu_pr_ac')
	aeLista.main.mascara.show();
        this.msg = Ext.get('formularioPartida');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Poa/partida/ae/'+this.codigo+'/prac/'+this.nu_pr_ac,
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Editar un registro
this.actividad= new Ext.Button({
    text:'Actividades',
    iconCls: 'icon-buscar',
    handler:function(){
	this.codigo  = aeLista.main.gridPanel_.getSelectionModel().getSelected().get('nu_ae');
  this.nu_pr_ac  = aeLista.main.gridPanel_.getSelectionModel().getSelected().get('nu_pr_ac')
	aeLista.main.mascara.show();
        this.msg = Ext.get('formularioActividad');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Poa/actividad/ae/'+this.codigo+'/prac/'+this.nu_pr_ac,
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
		aeLista.main.store_lista.baseParams={};
		aeLista.main.store_lista.baseParams.paginar = 'si';
		aeLista.main.store_lista.load();
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
			aeLista.main.store_lista.baseParams={};
			aeLista.main.store_lista.baseParams.BuscarBy = true;
			aeLista.main.store_lista.baseParams[this.paramName] = v;
			aeLista.main.store_lista.baseParams.paginar = 'si';
			aeLista.main.store_lista.load();
		}
	}
});

this.editar.disable();
this.actividad.disable();

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
        this.editar,'-',this.actividad,'-',this.buscador
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'nu_pr_ac',hidden:true, menuDisabled:true,dataIndex: 'nu_pr_ac'},
    {header: 'nu_ae',hidden:true, menuDisabled:true,dataIndex: 'nu_ae'},
    {header: 'Accion Especifica', width:540,  menuDisabled:true, sortable: true, renderer: textoLargo, dataIndex: 'ae'},
    {header: 'Presupuesto', width:200,  menuDisabled:true, sortable: true, renderer: formatoNumero, dataIndex: 'mo_presupuesto'},
    ],
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
      aeLista.main.editar.enable();
      aeLista.main.actividad.enable();
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

//this.gridPanel_.render("contenedoraeLista");

this.winformPanel_ = new Ext.Window({
    title:'Sector > Sub Sector > Ejecutores > Proyecto / Accion Centralizada > Acciones Especificas',
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

aeLista.main.store_lista.baseParams.prac=aeLista.main.OBJ.prac;
this.store_lista.load();
this.store_lista.on('load',function(){
  aeLista.main.editar.disable();
  aeLista.main.actividad.disable();
});
this.store_lista.on('beforeload',function(){
  panel_detalle.collapse();
});
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Poa/storelistaae',
    root:'data',
    fields:[
    {name: 'nu_pr_ac'},
    {name: 'nu_ae'},
    {name: 'de_ae'},
    {name: 'mo_presupuesto'},
    {
        name: 'ae',
        convert: function(v, r) {
            return r.nu_ae + ' - ' + r.de_ae;
        }
    }
           ]
    });
    return this.store;
}
};
Ext.onReady(aeLista.main.init, aeLista.main);
</script>
<div id="contenedoraeLista"></div>
<div id="formularioPartida"></div>
<div id="formularioActividad"></div>
