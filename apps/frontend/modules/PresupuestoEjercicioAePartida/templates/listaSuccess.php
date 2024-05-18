<script type="text/javascript">
Ext.ns("PresupuestoEjercicioAePartidaLista");
PresupuestoEjercicioAePartidaLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//objeto store
this.store_lista = this.getLista();

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        PresupuestoEjercicioAePartidaLista.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoEjercicioAePartida');
        this.msg.load({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAePartida/editar',
            scripts: true,
            text: "Cargando..",
            params:{
                id_tb166_pac_ae_tmp:PresupuestoEjercicioAePartidaLista.main.OBJ.id_tb166_pac_ae_tmp
            }
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = PresupuestoEjercicioAePartidaLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	PresupuestoEjercicioAePartidaLista.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoEjercicioAePartida');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAePartida/editar/codigo/'+this.codigo,
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
	this.codigo  = PresupuestoEjercicioAePartidaLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAePartida/eliminar',
            params:{
                id:PresupuestoEjercicioAePartidaLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    PresupuestoEjercicioAePartidaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                PresupuestoEjercicioAePartidaLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroPresupuestoEjercicioAePartida');
        PresupuestoEjercicioAePartidaLista.main.mascara.show();
        PresupuestoEjercicioAePartidaLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAePartida/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

function renderMontoPartida(val, attr, record) { 
     return paqueteComunJS.funcion.getNumeroFormateado(val);     
} 

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    //title:'Lista de PresupuestoEjercicioAePartida',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:520,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.eliminar,'-',this.filtro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},
    {header: 'Partida', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'nu_partida'},
    {header: 'Descripcion', width:450,  menuDisabled:true, sortable: true,  dataIndex: 'de_partida'},
    {header: 'Aplicacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb139_aplicacion'},
    {header: 'Monto', width:150,  menuDisabled:true, sortable: true, renderer:renderMontoPartida, dataIndex: 'mo_partida'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{
        cellclick:function(Grid, rowIndex, columnIndex,e ){
            PresupuestoEjercicioAePartidaLista.main.editar.enable();
            PresupuestoEjercicioAePartidaLista.main.eliminar.enable();
        }
    },
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

//this.gridPanel_.render("contenedorPresupuestoEjercicioAePartidaLista");

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Presupuesto Ejercicio A/E Partida',
    modal:true,
    constrain:true,
width:900,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.gridPanel_
    ]
});
this.winformPanel_.show();
PresupuestoEjercicioAeLista.main.mascara.hide();

this.store_lista.baseParams.id_tb166_pac_ae_tmp=PresupuestoEjercicioAePartidaLista.main.OBJ.id_tb166_pac_ae_tmp;
this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAePartida/storelista',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'id_tb166_pac_ae_tmp'},
    {name: 'nu_pa'},
    {name: 'nu_ge'},
    {name: 'nu_es'},
    {name: 'nu_se'},
    {name: 'nu_sse'},
    {name: 'nu_partida'},
    {name: 'de_partida'},
    {name: 'in_movimiento'},
    {name: 'in_activo'},
    {name: 'mo_partida'},
    {name: 'id_tb139_aplicacion'},
    {name: 'id_tb091_partida'},
    {name: 'id_tb140_tipo_ingreso'},
    {name: 'id_tb138_ambito'},
    {name: 'created_at'},
    {name: 'updated_at'},
           ]
    });
    return this.store;
}
};
Ext.onReady(PresupuestoEjercicioAePartidaLista.main.init, PresupuestoEjercicioAePartidaLista.main);
</script>
<div id="contenedorPresupuestoEjercicioAePartidaLista"></div>
<div id="formularioPresupuestoEjercicioAePartida"></div>
<div id="filtroPresupuestoEjercicioAePartida"></div>
