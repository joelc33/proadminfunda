<script type="text/javascript">
Ext.ns("PresupuestoEjercicioAeLista");
PresupuestoEjercicioAeLista.main = {
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
        PresupuestoEjercicioAeLista.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoEjercicioAe');
            this.msg.load({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAe/editar',
            scripts: true,
            text: "Cargando..",
            params:{
                id_tb165_pac_tmp:PresupuestoEjercicioAeLista.main.OBJ.id_tb165_pac_tmp
            }
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = PresupuestoEjercicioAeLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	PresupuestoEjercicioAeLista.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoEjercicioAe');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAe/editar/codigo/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Editar un registro
this.partida= new Ext.Button({
    text:'Partidas',
    iconCls: 'icon-reporteest',
    handler:function(){
	this.codigo  = PresupuestoEjercicioAeLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	PresupuestoEjercicioAeLista.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoEjercicioAe');
        this.msg.load({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAePartida/lista/codigo/'+this.codigo,
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
	this.codigo  = PresupuestoEjercicioAeLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAe/eliminar',
            params:{
                id:PresupuestoEjercicioAeLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    PresupuestoEjercicioAeLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                PresupuestoEjercicioAeLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroPresupuestoEjercicioAe');
        PresupuestoEjercicioAeLista.main.mascara.show();
        PresupuestoEjercicioAeLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAe/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();
this.partida.disable();

function renderMonto(val, attr, record) { 
     return paqueteComunJS.funcion.getNumeroFormateado(val);     
} 

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    //title:'Lista de PresupuestoEjercicioAe',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:400,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.eliminar,'-',this.filtro,'-',this.partida
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},
    {header: 'Nº AE', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_accion_especifica'},
    {header: 'Descripcion', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'de_accion_especifica'},
    {header: 'Monto Cargado', width:120,  menuDisabled:true, sortable: true, renderer:renderMonto, dataIndex: 'mo_cargado'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{
        cellclick:function(Grid, rowIndex, columnIndex,e ){
            PresupuestoEjercicioAeLista.main.editar.enable();
            PresupuestoEjercicioAeLista.main.eliminar.enable();
            PresupuestoEjercicioAeLista.main.partida.enable();
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

//this.gridPanel_.render("contenedorPresupuestoEjercicioAeLista");

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Presupuesto Ejercicio A/E',
    modal:true,
    constrain:true,
    width:814,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.gridPanel_
    ]
});
this.winformPanel_.show();
PresupuestoEjercicioLista.main.mascara.hide();

this.store_lista.baseParams.id_tb165_pac_tmp=PresupuestoEjercicioAeLista.main.OBJ.id_tb165_pac_tmp;
this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAe/storelista',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'id_tb165_pac_tmp'},
    {name: 'nu_accion_especifica'},
    {name: 'de_accion_especifica'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'mo_cargado'},
           ]
    });
    return this.store;
}
};
Ext.onReady(PresupuestoEjercicioAeLista.main.init, PresupuestoEjercicioAeLista.main);
</script>
<div id="contenedorPresupuestoEjercicioAeLista"></div>
<div id="formularioPresupuestoEjercicioAe"></div>
<div id="filtroPresupuestoEjercicioAe"></div>
