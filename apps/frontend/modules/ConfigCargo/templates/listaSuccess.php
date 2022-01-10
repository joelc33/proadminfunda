<script type="text/javascript">
Ext.ns("ConfigCargoLista");
function change(val){
	if(val==true){
	    return '<span style="color:green;">Si</span>';
	}else if(val==false){
	    return '<span style="color:red;">No</span>';
	}
return val;
};
ConfigCargoLista.main = {
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
        ConfigCargoLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigCargo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigCargo/editar',
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
	this.codigo  = ConfigCargoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_cargo');
	ConfigCargoLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigCargo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigCargo/editar/codigo/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Editar un registro
this.parametro= new Ext.Button({
    text:'Parametros',
    iconCls: 'icon-reporteest',
    handler:function(){
	this.codigo  = ConfigCargoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_cargo');
	//ConfigCargoLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigCargo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigCargo/parametro/codigo/'+this.codigo,
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
	this.codigo  = ConfigCargoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_cargo');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigCargo/eliminar',
            params:{
                co_cargo:ConfigCargoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_cargo')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ConfigCargoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ConfigCargoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroConfigCargo');
        ConfigCargoLista.main.mascara.show();
        ConfigCargoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigCargo/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();
this.parametro.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de ConfigCargo',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',
        this.editar,'-',
        //this.eliminar,'-',
        this.filtro,'-',
        this.parametro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_cargo',hidden:true, menuDisabled:true,dataIndex: 'co_cargo'},
    {header: 'Cargo', width:350,  menuDisabled:true, sortable: true,  dataIndex: 'tx_cargo'},
    {header: 'Codigo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_codigo'},
    {header: 'Tipo tabulador', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'co_tp_tabulador'},
    {header: 'Tabulador', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tabulador'},
    {header: 'Aplica Comp.', width:200,  menuDisabled:true, sortable: true, renderer: change, dataIndex: 'in_compensacion'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
        ConfigCargoLista.main.editar.enable();
        ConfigCargoLista.main.eliminar.enable();
        ConfigCargoLista.main.parametro.enable();
    }},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorConfigCargoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigCargo/storelista',
    root:'data',
    fields:[
    {name: 'co_cargo'},
    {name: 'tx_cargo'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'co_tabulador2'},
    {name: 'nu_codigo'},
    {name: 'co_tp_tabulador'},
    {name: 'co_tabulador'},
    {name: 'in_compensacion'},
    {name: 'tabulador',
        convert:function(v,r){
        return r.nu_codigo_tab+' - '+paqueteComunJS.funcion.getNumeroFormateado(r.mo_sueldo);
        }
    }
           ]
    });
    return this.store;
}
};
Ext.onReady(ConfigCargoLista.main.init, ConfigCargoLista.main);
</script>
<div id="contenedorConfigCargoLista"></div>
<div id="formularioConfigCargo"></div>
<div id="filtroConfigCargo"></div>
