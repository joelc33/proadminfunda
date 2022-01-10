<script type="text/javascript">
Ext.ns("NovedadTrabajadorLista");
NovedadTrabajadorLista.main = {
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
        NovedadTrabajadorLista.main.mascara.show();
        this.msg = Ext.get('formularioNovedadTrabajador');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NovedadTrabajador/editar',
         scripts: true,
         text: "Cargando..",
         params:{
            co_solicitud:NovedadTrabajadorLista.main.OBJ.co_solicitud
        }
        });
    }
});

//Agregar un registro
this.carga = new Ext.Button({
    text:'Carga Masiva',
    iconCls: 'icon-descargar',
    handler:function(){
        NovedadTrabajadorLista.main.mascara.show();
        this.msg = Ext.get('formularioNovedadTrabajador');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NovedadTrabajador/carga',
         scripts: true,
         text: "Cargando..",
         params:{
            co_solicitud:NovedadTrabajadorLista.main.OBJ.co_solicitud
        }
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = NovedadTrabajadorLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	NovedadTrabajadorLista.main.mascara.show();
        this.msg = Ext.get('formularioNovedadTrabajador');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NovedadTrabajador/editar/codigo/'+this.codigo,
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
	this.codigo  = NovedadTrabajadorLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NovedadTrabajador/eliminar',
            params:{
                id:NovedadTrabajadorLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    NovedadTrabajadorLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                NovedadTrabajadorLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroNovedadTrabajador');
        NovedadTrabajadorLista.main.mascara.show();
        NovedadTrabajadorLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/NovedadTrabajador/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    //title:'Lista de NovedadTrabajador',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.eliminar,'-',this.filtro,'-',this.carga
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},
    {header: 'Cedula', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cedula'},
    {header: 'Nombre', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'nb_trabajador'},
    {header: 'Concepto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_concepto'},
    {header: 'Valor', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_valor'},
    {header: 'Fecha Novedad', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_novedad'},
    {header: 'Fecha Ejec.', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_ejecucion'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){NovedadTrabajadorLista.main.editar.enable();NovedadTrabajadorLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 500,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

//this.gridPanel_.render("contenedorNovedadTrabajadorLista");

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Novedad Trabajador',
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

this.store_lista.baseParams.co_solicitud=NovedadTrabajadorLista.main.OBJ.co_solicitud;
this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NovedadTrabajador/storelista',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'co_solicitud'},
    {name: 'nu_cedula'},
    {name: 'nb_trabajador'},
    {name: 'nu_concepto'},
    {name: 'nu_valor'},
    {name: 'fe_novedad'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'fe_ejecucion'},
           ]
    });
    return this.store;
}
};
Ext.onReady(NovedadTrabajadorLista.main.init, NovedadTrabajadorLista.main);
</script>
<div id="contenedorNovedadTrabajadorLista"></div>
<div id="formularioNovedadTrabajador"></div>
<div id="filtroNovedadTrabajador"></div>
