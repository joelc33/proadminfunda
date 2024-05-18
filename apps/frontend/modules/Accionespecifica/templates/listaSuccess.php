<script type="text/javascript">
Ext.ns("AccionespecificaLista");
AccionespecificaLista.main = {
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
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        AccionespecificaLista.main.mascara.show();
        this.msg = Ext.get('formularioAccionespecifica');
        this.msg.load({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Accionespecifica/editar',
            scripts: true,
            text: "Cargando..",
            params:{
                id_tb083_proyecto_ac:AccionespecificaLista.main.OBJ.codigo
            }
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Partidas',
    iconCls: 'icon-reporteest',
    handler:function(){
	this.codigo  = AccionespecificaLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	AccionespecificaLista.main.mascara.show();
        this.msg = Ext.get('formularioAccionespecifica');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/lista/codigo/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});

this.actividad= new Ext.Button({
    text:'Actividades',
    iconCls: 'icon-reporteest',
    handler:function(){
	this.codigo  = AccionespecificaLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	AccionespecificaLista.main.mascara.show();
        this.msg = Ext.get('formularioAccionespecifica');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Aeactividades/lista/codigo/'+this.codigo,
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
	this.codigo  = AccionespecificaLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Accionespecifica/eliminar',
            params:{
                id:AccionespecificaLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    AccionespecificaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                AccionespecificaLista.main.mascara.hide();
            }});
	}});
    }
});

//Editar un registro
this.editar_ae= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = AccionespecificaLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	AccionespecificaLista.main.mascara.show();
        this.msg = Ext.get('formularioAccionespecifica');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Accionespecifica/editar/codigo/'+this.codigo,
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
		AccionespecificaLista.main.store_lista.baseParams={};
		AccionespecificaLista.main.store_lista.baseParams.paginar = 'si';
    AccionespecificaLista.main.store_lista.baseParams.codigo = AccionespecificaLista.main.OBJ.codigo;
		AccionespecificaLista.main.store_lista.load();
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
			AccionespecificaLista.main.store_lista.baseParams={};
			AccionespecificaLista.main.store_lista.baseParams.BuscarBy = true;
			AccionespecificaLista.main.store_lista.baseParams[this.paramName] = v;
			AccionespecificaLista.main.store_lista.baseParams.paginar = 'si';
      AccionespecificaLista.main.store_lista.baseParams.codigo = AccionespecificaLista.main.OBJ.codigo;
			AccionespecificaLista.main.store_lista.load();
		}
	}
});

this.editar.disable();
this.actividad.disable();
this.editar_ae.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    //title:'Lista de Accionespecifica',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:520,
    border:false,
    tbar:[
        this.editar,'-',this.actividad,'-',this.buscador,'-',this.nuevo,'-',this.editar_ae
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},
    {header: 'Codigo', width:60,  menuDisabled:true, sortable: true,  dataIndex: 'nu_accion_especifica'},
    {header: 'Descripcion', width:840,  menuDisabled:true, sortable: true,  dataIndex: 'de_accion_especifica'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
      AccionespecificaLista.main.editar.enable();
      AccionespecificaLista.main.actividad.enable();
      AccionespecificaLista.main.editar_ae.enable();
    }},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

//this.gridPanel_.render("contenedorAccionespecificaLista");

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Acciones Especificas',
    modal:true,
    constrain:true,
width:1000,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.gridPanel_
    ]
});
this.winformPanel_.show();
AsignacionpresupuestoLista.main.mascara.hide();

AccionespecificaLista.main.store_lista.baseParams.codigo=AccionespecificaLista.main.OBJ.codigo;

this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Accionespecifica/storelista',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'id_tb083_proyecto_ac'},
    {name: 'nu_accion_especifica'},
    {name: 'de_accion_especifica'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
           ]
    });
    return this.store;
}
};
Ext.onReady(AccionespecificaLista.main.init, AccionespecificaLista.main);
</script>
<div id="contenedorAccionespecificaLista"></div>
<div id="formularioAccionespecifica"></div>
<div id="filtroAccionespecifica"></div>
