<script type="text/javascript">
Ext.ns("PartidapresupuestoLista");
PartidapresupuestoLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

//Agregar un registro
//Agregar un registro
this.agregar_partida = new Ext.Button({
    text:'Agregar Partida',
    iconCls: 'icon-nuevo',
    handler:function(){
        PartidapresupuestoLista.main.mascara.show();
        this.msg = Ext.get('formularioPartidapresupuesto');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/editar',
         scripts: true,
         text: "Cargando..",
         params:{
            id_tb084_accion_especifica:PartidapresupuestoLista.main.OBJ.codigo
         }
        });
    }
});

this.ver_desagregada = new Ext.Button({
    text:'Ver Desagregada',
    iconCls: 'icon-anteriores',
    handler:function(){
        PartidapresupuestoLista.main.mascara.show();
        this.msg = Ext.get('formularioPartidapresupuesto');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/listaDesagregada',
         scripts: true,
         text: "Cargando..",
         params:{
             nu_partida:PartidapresupuestoLista.main.gridPanel_.getSelectionModel().getSelected().get('nu_partida'),
             co_accion_especifica:PartidapresupuestoLista.main.gridPanel_.getSelectionModel().getSelected().get('id_tb084_accion_especifica')
         }
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Movimientos',
    iconCls: 'icon-reporteest',
    handler:function(){
	PartidapresupuestoLista.main.mascara.show();
        this.msg = Ext.get('formularioPartidapresupuesto');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/lista',
         scripts: true,
         text: "Cargando..",
         params:{
             codigo: PartidapresupuestoLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
         }
        });
    }
});

this.asignar_cuenta= new Ext.Button({
    text:'Asignar Cuenta Contable',
    iconCls: 'icon-add',
    handler:function(){
	this.msg = Ext.get('formularioPartidapresupuesto');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaContable/presupuesto',
         params:{
             id:PartidapresupuestoLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
         },
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Eliminar un registro
this.eliminar= new Ext.Button({
    text:'Eliminar',
    iconCls: 'icon-eliminar',
    handler:function(){
	this.codigo  = PartidapresupuestoLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/eliminar',
            params:{
                id:PartidapresupuestoLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    PartidapresupuestoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                PartidapresupuestoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroPartidapresupuesto');
        PartidapresupuestoLista.main.mascara.show();
        PartidapresupuestoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/filtro',
             scripts: true
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
		PartidapresupuestoLista.main.store_lista.baseParams={};
		PartidapresupuestoLista.main.store_lista.baseParams.paginar = 'si';
                PartidapresupuestoLista.main.store_lista.baseParams.codigo = PartidapresupuestoLista.main.OBJ.codigo;
		PartidapresupuestoLista.main.store_lista.load();
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
			PartidapresupuestoLista.main.store_lista.baseParams={};
			PartidapresupuestoLista.main.store_lista.baseParams.BuscarBy = true;
			PartidapresupuestoLista.main.store_lista.baseParams[this.paramName] = v;
			PartidapresupuestoLista.main.store_lista.baseParams.paginar = 'si';
      PartidapresupuestoLista.main.store_lista.baseParams.codigo = PartidapresupuestoLista.main.OBJ.codigo;
			PartidapresupuestoLista.main.store_lista.load();
		}
	}
});

this.editar.disable();
this.eliminar.disable();
this.asignar_cuenta.disable();
this.ver_desagregada.disable();

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
//        this.agregar_partida,'-',
                this.ver_desagregada,//'-',this.editar,
//                '-',this.asignar_cuenta,'-',
                this.buscador,'-',this.agregar_partida
    ],
    columns: [
    new Ext.grid.RowNumberer(),
        {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'}, 
        {header: 'id_tb084_accion_especifica',hidden:true, menuDisabled:true,dataIndex: 'id_tb084_accion_especifica'},         
        {header: 'Codigo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_partida'},
        {header: 'Cod. Contable', width:140,  menuDisabled:true, sortable: true,  dataIndex: 'tx_cuenta'},
        {header: 'Descripcion', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'de_partida'},
        {header: 'Inicial', width:100,  menuDisabled:true, sortable: true, renderer: formatoNumero, dataIndex: 'mo_inicial'},
        {header: 'Modificado', width:100,  menuDisabled:true, sortable: true, renderer: formatoNumero, dataIndex: 'mo_actualizado'},
        {header: 'Comprometido', width:80,  menuDisabled:true, sortable: true, renderer: formatoNumero, dataIndex: 'mo_comprometido'},
        {header: 'Causado', width:100,  menuDisabled:true, sortable: true, renderer: formatoNumero, dataIndex: 'mo_causado'},
        {header: 'Pagado', width:100,  menuDisabled:true, sortable: true, renderer: formatoNumero, dataIndex: 'mo_pagado'},
        {header: 'Disponible', width:150,  menuDisabled:true, sortable: true, renderer: formatoNumero, dataIndex: 'mo_disponible'}
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
      PartidapresupuestoLista.main.editar.enable();
      PartidapresupuestoLista.main.eliminar.enable();
      PartidapresupuestoLista.main.asignar_cuenta.enable();
      PartidapresupuestoLista.main.ver_desagregada.enable();
    }},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

//this.gridPanel_.render("contenedorPartidapresupuestoLista");

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
AccionespecificaLista.main.mascara.hide();

PartidapresupuestoLista.main.store_lista.baseParams.codigo=PartidapresupuestoLista.main.OBJ.codigo;

this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/storelista',
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
            {name: 'nu_nivel'}
           ]
    });
    return this.store;
}
};
Ext.onReady(PartidapresupuestoLista.main.init, PartidapresupuestoLista.main);
</script>
<div id="contenedorPartidapresupuestoLista"></div>
<div id="formularioPartidapresupuesto"></div>
<div id="filtroPartidapresupuesto"></div>
