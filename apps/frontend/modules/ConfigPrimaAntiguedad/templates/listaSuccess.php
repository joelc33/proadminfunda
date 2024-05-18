<script type="text/javascript">
Ext.ns("ConfigPrimaAntiguedadLista");
function change(val){
	if(val==true){
	    return '<span style="color:green;">Activo</span>';
	}else if(val==false){
	    return '<span style="color:red;">Inactivo</span>';
	}
return val;
};
ConfigPrimaAntiguedadLista.main = {
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
        ConfigPrimaAntiguedadLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigPrimaAntiguedad');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPrimaAntiguedad/editar',
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
	this.codigo  = ConfigPrimaAntiguedadLista.main.gridPanel_.getSelectionModel().getSelected().get('co_prima_antiguedad');
	ConfigPrimaAntiguedadLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigPrimaAntiguedad');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPrimaAntiguedad/editar/codigo/'+this.codigo,
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
	this.codigo  = ConfigPrimaAntiguedadLista.main.gridPanel_.getSelectionModel().getSelected().get('co_prima_antiguedad');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPrimaAntiguedad/eliminar',
            params:{
                co_prima_antiguedad:ConfigPrimaAntiguedadLista.main.gridPanel_.getSelectionModel().getSelected().get('co_prima_antiguedad')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ConfigPrimaAntiguedadLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ConfigPrimaAntiguedadLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroConfigPrimaAntiguedad');
        ConfigPrimaAntiguedadLista.main.mascara.show();
        ConfigPrimaAntiguedadLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPrimaAntiguedad/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Configuracion Prima Antiguedad',
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
    {header: 'co_prima_antiguedad',hidden:true, menuDisabled:true,dataIndex: 'co_prima_antiguedad'},
    {header: 'Nomina', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'nomina'},
    {header: 'Grupo', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'cod_grupo_nomina'},
    {header: 'Años', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_anio'},
    {header: 'Porcentaje', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_porcentaje'},
    {header: 'Condicional', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'de_condicional'},
    {header: 'Estatus', width:100,  menuDisabled:true, sortable: true, renderer: change, dataIndex: 'in_activo'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ConfigPrimaAntiguedadLista.main.editar.enable();ConfigPrimaAntiguedadLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorConfigPrimaAntiguedadLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPrimaAntiguedad/storelista',
    root:'data',
    fields:[
            {name: 'co_prima_antiguedad'},
            {name: 'co_tp_nomina'},
            {name: 'co_grupo_nomina'},
            {name: 'cod_grupo_nomina'},
            {name: 'nu_anio'},
            {name: 'nu_porcentaje'},
            {name: 'in_activo'},
            {name: 'created_at'},
            {name: 'updated_at'},
            {name: 'de_condicional'},
            {
                name: 'nomina',
                convert: function(v, r) {
                        return r.nu_nomina + ' - ' + r.tx_tp_nomina;
                }
            },
            {
                name: 'grupo',
                convert: function(v, r) {
                        return r.cod_grupo_nomina + ' - ' + r.tx_grupo_nomina;
                }
            }
           ]
    });
    return this.store;
}
};
Ext.onReady(ConfigPrimaAntiguedadLista.main.init, ConfigPrimaAntiguedadLista.main);
</script>
<div id="contenedorConfigPrimaAntiguedadLista"></div>
<div id="formularioConfigPrimaAntiguedad"></div>
<div id="filtroConfigPrimaAntiguedad"></div>
