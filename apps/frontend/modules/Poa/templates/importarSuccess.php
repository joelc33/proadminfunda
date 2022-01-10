<script type="text/javascript">
Ext.ns("importarLista");
importarLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){

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
		importarLista.main.store_lista.baseParams={};
		importarLista.main.store_lista.baseParams.paginar = 'si';
		importarLista.main.store_lista.load();
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
			importarLista.main.store_lista.baseParams={};
			importarLista.main.store_lista.baseParams.BuscarBy = true;
			importarLista.main.store_lista.baseParams[this.paramName] = v;
			importarLista.main.store_lista.baseParams.paginar = 'si';
			importarLista.main.store_lista.load();
		}
	}
});

this.importar= new Ext.Button({
    text:'Ejecutar Importacion',
    iconCls: 'icon-fin',
    handler:function(){
    	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea importar POA <?php echo $sf_request->getAttribute('ejercicio'); ?>?<br><b>Nota:</b> No se podran modificar los cambios.', function(boton){
    	if(boton=="yes"){
        //AsignacionpresupuestoLista.main.mascara.show();
            Ext.Ajax.request({
                method:'POST',
                url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Poa/ejecutar',
                success:function(result, request ) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if(obj.success=="true"){
    		                AsignacionpresupuestoLista.main.store_lista.load();
                        Ext.Msg.alert("Notificación",obj.msg);
                    }else{
                        Ext.Msg.alert("Notificación",obj.msg);
                    }
                    AsignacionpresupuestoLista.main.mascara.hide();
                    importarLista.main.winformPanel_.close();
                }});
    	}});
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
        this.importar,'-',this.buscador
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'Ejercicio', width:60,  menuDisabled:true, sortable: true, dataIndex: 'ef_uno'},
    {header: 'Ejecutor', width:60,  menuDisabled:true, sortable: true, dataIndex: 'id_ejecutor'},
    {header: 'Proy / AC', width:120,  menuDisabled:true, sortable: true, dataIndex: 'nu_pr_ac'},
    {header: 'AE', width:60,  menuDisabled:true, sortable: true, dataIndex: 'nu_ae'},
    {header: 'Codigo', width:80,  menuDisabled:true, sortable: true, dataIndex: 'cu_partida'},
    {header: 'Denominacion', width:280,  menuDisabled:true, sortable: true, dataIndex: 'de_denominacion'},
    {header: 'Presupuesto', width:150,  menuDisabled:true, sortable: true, renderer: formatoNumero, dataIndex: 'mo_presupuesto'},
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

//this.gridPanel_.render("contenedorimportarLista");

this.winformPanel_ = new Ext.Window({
    title:'Importar POA Ejercicio: <?php echo $sf_request->getAttribute('ejercicio'); ?>',
    modal:true,
    constrain:true,
    width:850,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.gridPanel_
    ]
});
this.winformPanel_.show();
AsignacionpresupuestoLista.main.mascara.hide();

this.store_lista.load();
this.store_lista.on('beforeload',function(){
  panel_detalle.collapse();
});
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Poa/storelistaimportar',
    root:'data',
    fields:[
    {name: 'ef_uno'},
    {name: 'nu_pr_ac'},
    {name: 'id_ejecutor'},
    {name: 'nu_ae'},
    {name: 'nu_partida'},
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
Ext.onReady(importarLista.main.init, importarLista.main);
</script>
<div id="contenedorimportarLista"></div>
