<script type="text/javascript">
Ext.ns("ConfigTipoNominaLista");
function change(val){
	if(val==true){
	    return '<span style="color:green;">Activo</span>';
	}else if(val==false){
	    return '<span style="color:red;">Inactivo</span>';
	}
return val;
};
ConfigTipoNominaLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        ConfigTipoNominaLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigTipoNomina');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigTipoNomina/editar',
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = ConfigTipoNominaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_tp_nomina');
	ConfigTipoNominaLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigTipoNomina');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigTipoNomina/editar/codigo/'+this.codigo,
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
	this.codigo  = ConfigTipoNominaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_tp_nomina');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigTipoNomina/eliminar',
            params:{
                co_tp_nomina:ConfigTipoNominaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_tp_nomina')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ConfigTipoNominaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ConfigTipoNominaLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroConfigTipoNomina');
        ConfigTipoNominaLista.main.mascara.show();
        ConfigTipoNominaLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigTipoNomina/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Config Tipo Nomina',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.eliminar,'-',this.filtro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_tp_nomina',hidden:true, menuDisabled:true,dataIndex: 'co_tp_nomina'},
    {header: 'Cod. Nomina', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_nomina'},
    {header: 'Tipo Nomina', width:500,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tp_nomina'},
    {header: 'Estatus', width:100,  menuDisabled:true, sortable: true, renderer: change, dataIndex: 'in_activo'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ConfigTipoNominaLista.main.editar.enable();ConfigTipoNominaLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorConfigTipoNominaLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigTipoNomina/storelista',
    root:'data',
    fields:[
    {name: 'co_tp_nomina'},
    {name: 'tx_tp_nomina'},
    {name: 'nu_hora'},
    {name: 'co_nom_tipo_ingreso'},
    {name: 'nu_dia_derecho_vacaciones'},
    {name: 'nu_anio_antiguedad_vacaciones'},
    {name: 'nu_dia_vacaciones'},
    {name: 'co_nom_tipo_disfrute'},
    {name: 'nu_dia_adicional_anio'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'nu_nomina'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ConfigTipoNominaLista.main.init, ConfigTipoNominaLista.main);
</script>
<div id="contenedorConfigTipoNominaLista"></div>
<div id="formularioConfigTipoNomina"></div>
<div id="filtroConfigTipoNomina"></div>
