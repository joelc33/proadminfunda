<script type="text/javascript">
Ext.ns("ConfigPrimaProfesionalizacionLista");
ConfigPrimaProfesionalizacionLista.main = {
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
        ConfigPrimaProfesionalizacionLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigPrimaProfesionalizacion');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPrimaProfesionalizacion/editar',
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
	this.codigo  = ConfigPrimaProfesionalizacionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_prima_nivel_edu');
	ConfigPrimaProfesionalizacionLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigPrimaProfesionalizacion');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPrimaProfesionalizacion/editar/codigo/'+this.codigo,
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
	this.codigo  = ConfigPrimaProfesionalizacionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_prima_nivel_edu');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPrimaProfesionalizacion/eliminar',
            params:{
                co_prima_nivel_edu:ConfigPrimaProfesionalizacionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_prima_nivel_edu')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ConfigPrimaProfesionalizacionLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ConfigPrimaProfesionalizacionLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroConfigPrimaProfesionalizacion');
        ConfigPrimaProfesionalizacionLista.main.mascara.show();
        ConfigPrimaProfesionalizacionLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPrimaProfesionalizacion/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Prima Profesionalizacion',
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
    {header: 'co_prima_nivel_edu',hidden:true, menuDisabled:true,dataIndex: 'co_prima_nivel_edu'},
    {header: 'Nomina', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'nomina'},
    {header: 'Grupo', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'cod_grupo_nomina'},
    {header: 'Nivel Educativo', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'co_nivel_educativo'},
    {header: 'Porcentaje', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_porcentaje'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ConfigPrimaProfesionalizacionLista.main.editar.enable();ConfigPrimaProfesionalizacionLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorConfigPrimaProfesionalizacionLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPrimaProfesionalizacion/storelista',
    root:'data',
    fields:[
    {name: 'co_prima_nivel_edu'},
    {name: 'co_tp_nomina'},
    {name: 'co_grupo_nomina'},
    {name: 'co_nivel_educativo'},
    {name: 'nu_porcentaje'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'cod_grupo_nomina'},
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
Ext.onReady(ConfigPrimaProfesionalizacionLista.main.init, ConfigPrimaProfesionalizacionLista.main);
</script>
<div id="contenedorConfigPrimaProfesionalizacionLista"></div>
<div id="formularioConfigPrimaProfesionalizacion"></div>
<div id="filtroConfigPrimaProfesionalizacion"></div>
