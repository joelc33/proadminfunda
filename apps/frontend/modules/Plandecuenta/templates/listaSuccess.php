<script type="text/javascript">
Ext.ns("PlandecuentaLista");
PlandecuentaLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();
this.storeCO_TIPO_CUENTA = this.getStoreCO_TIPO_CUENTA();

this.tx_codigo_cuenta = new Ext.form.TextField({
	fieldLabel:'Cuenta',
	name:'tx_codigo_cuenta',
        value:'4.',
	width:100
});

this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'Denominación',
	name:'tx_descripcion',
	width:550
});

this.tx_tipo = new Ext.form.ComboBox({
	fieldLabel:'Tipo',
	store: this.storeCO_TIPO_CUENTA,
	typeAhead: true,
	valueField: 'tx_sigla',
	displayField:'tx_tipo_partida_presupuestaria',
	hiddenName:'tx_tipo',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_CUENTA.load();

this.formFiltroPrincipal = new Ext.form.FormPanel({
    title:'Buscar Plan de Cuenta',
    iconCls: 'icon-electores',
    collapsible: true,
    titleCollapse: true,
    autoWidth:true,
    border:false,
    padding:'10px',
    items   : [
       this.tx_codigo_cuenta,
       this.tx_descripcion,
       this.tx_tipo
    ],
    keys: [{
		key:[Ext.EventObject.ENTER],
		handler: function() {
			PlandecuentaLista.main.aplicarFiltroByFormulario();
		}}
    ],
    buttonAlign:'center',
    buttons:[
        {
            text:'Consultar',
            iconCls:'icon-buscar',
            handler:function(){
                PlandecuentaLista.main.aplicarFiltroByFormulario();
            }
        },
        {
            text:'Limpiar',
            iconCls:'icon-limpiar',
            handler:function(){
                PlandecuentaLista.main.limpiarCamposByFormFiltro();
            }
        }
    ]
});


//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Agregar Cuenta Nivel 1',
    iconCls: 'icon-nuevo',
    handler:function(){
        PlandecuentaLista.main.mascara.show();
        this.msg = Ext.get('formularioPlandecuenta');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Plandecuenta/editar',
         scripts: true,
         text: "Cargando.."
        });
    }
});

this.secundaria = new Ext.Button({
    text:'Agregar Cuenta Secundaria',
    iconCls: 'icon-nuevo',
    handler:function(){
        PlandecuentaLista.main.mascara.show();
        this.msg = Ext.get('formularioPlandecuenta');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Plandecuenta/editar',
         scripts: true,
         text: "Cargando..",
         params:{
             tx_prefijo:PlandecuentaLista.main.gridPanel_.getSelectionModel().getSelected().get('tx_codigo_cuenta'),
             nivel: PlandecuentaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_tipo')
         }
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = PlandecuentaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_partida_presupuestaria');
	PlandecuentaLista.main.mascara.show();
        this.msg = Ext.get('formularioPlandecuenta');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Plandecuenta/editar/codigo/'+this.codigo,
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
	this.codigo  = PlandecuentaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_partida_presupuestaria');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Plandecuenta/eliminar',
            params:{
                tx_codigo_cuenta:PlandecuentaLista.main.gridPanel_.getSelectionModel().getSelected().get('tx_codigo_cuenta')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    PlandecuentaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                PlandecuentaLista.main.editar.disable();
                PlandecuentaLista.main.secundaria.disable();
                PlandecuentaLista.main.eliminar.disable();
                PlandecuentaLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroPlandecuenta');
        PlandecuentaLista.main.mascara.show();
        PlandecuentaLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Plandecuenta/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.secundaria.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Planes de Cuenta',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.secundaria,'-',this.editar,'-',this.eliminar // ,'-',this.filtro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_partida_presupuestaria',hidden:true, menuDisabled:true,dataIndex: 'co_partida_presupuestaria'},
    {header: 'Cuenta', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_codigo_cuenta'},
    {header: 'Denominación', width:700,  menuDisabled:true, sortable: true,  dataIndex: 'tx_descripcion'},
    {header: 'Nivel', width:60,  menuDisabled:true, sortable: true,  dataIndex: 'co_tipo'},
    {header: 'Tipo', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tipo'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
        
        var co_tipo = PlandecuentaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_tipo');
        
        if(co_tipo == 4){
             PlandecuentaLista.main.secundaria.disable();
        }else{
             PlandecuentaLista.main.secundaria.enable();
        }
            
        PlandecuentaLista.main.editar.enable();       
        PlandecuentaLista.main.eliminar.enable();
    }},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.panel = new Ext.Panel({
//	title: 'Lista de contribuyente',
	border:false,
	items: [this.formFiltroPrincipal,this.gridPanel_]
});

this.panel.render("contenedorPlandecuentaLista");



this.store_lista.load();
},
aplicarFiltroByFormulario: function(){
	//Capturamos los campos con su value para posteriormente verificar cual
	//esta lleno y trabajar en base a ese.
	var campo = PlandecuentaLista.main.formFiltroPrincipal.getForm().getValues();

	PlandecuentaLista.main.store_lista.baseParams={}

	var swfiltrar = false;
	for(campName in campo){
	    if(campo[campName]!=''){
		swfiltrar = true;
		eval(" PlandecuentaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
	    }
	}
	if(swfiltrar==true){
	    PlandecuentaLista.main.store_lista.baseParams.BuscarBy = true;
	    PlandecuentaLista.main.store_lista.load();
	}else{
	    PlandecuentaLista.main.formFiltroPrincipal.getForm().reset();
            PlandecuentaLista.main.store_lista.baseParams={};
            PlandecuentaLista.main.store_lista.load();
	}

        PlandecuentaLista.main.editar.disable();
        PlandecuentaLista.main.secundaria.disable();
        PlandecuentaLista.main.eliminar.disable();

	},
	limpiarCamposByFormFiltro: function(){
	PlandecuentaLista.main.formFiltroPrincipal.getForm().reset();
	PlandecuentaLista.main.store_lista.baseParams={};
	PlandecuentaLista.main.store_lista.load();
        
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Plandecuenta/storelista',
    root:'data',
    fields:[
            {name: 'co_partida_presupuestaria'},
            {name: 'tx_codigo_cuenta'},
            {name: 'tx_descripcion'},
            {name: 'tx_tipo'},
            {name: 'co_tipo'},
           ]
    });
    return this.store;
},getStoreCO_TIPO_CUENTA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Plandecuenta/storefkcotipocuenta',
        root:'data',
        fields:[
            {name: 'co_partida_presupuestaria'},
            {name: 'tx_tipo_partida_presupuestaria'},
            {name: 'tx_sigla'}
            ]
    });
    return this.store;
}
};
Ext.onReady(PlandecuentaLista.main.init, PlandecuentaLista.main);
</script>
<div id="contenedorPlandecuentaLista"></div>
<div id="formularioPlandecuenta"></div>
<div id="filtroPlandecuenta"></div>
