<script type="text/javascript">
Ext.ns("PresupuestoEjercicioLista");
function change(val){
	if(val==true){
	    return '<span style="color:green;">Cargado</span>';
	}else if(val==false){
	    return '<span style="color:red;">Pendiente</span>';
	}
return val;
};
PresupuestoEjercicioLista.main = {
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
        PresupuestoEjercicioLista.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoEjercicio');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicio/editar',
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
	this.codigo  = PresupuestoEjercicioLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	PresupuestoEjercicioLista.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoEjercicio');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicio/editar/codigo/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Editar un registro
this.ae= new Ext.Button({
    text:'Accion Especifica',
    iconCls: 'icon-reporteest',
    handler:function(){
	this.codigo  = PresupuestoEjercicioLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	PresupuestoEjercicioLista.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoEjercicio');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAe/lista/codigo/'+this.codigo,
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
	this.codigo  = PresupuestoEjercicioLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicio/eliminar',
            params:{
                id:PresupuestoEjercicioLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    PresupuestoEjercicioLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                PresupuestoEjercicioLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroPresupuestoEjercicio');
        PresupuestoEjercicioLista.main.mascara.show();
        PresupuestoEjercicioLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicio/filtro',
             scripts: true
        });
    }
});

this.importar= new Ext.Button({
    text:'Generar Presupuesto',
    iconCls: 'icon-fin',
    handler:function(){
	this.codigo  = PresupuestoEjercicioLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea importar Presupuesto?<br><b>Nota:</b> No se podran modificar los cambios.', function(boton){
        if(boton=="yes"){
            Ext.Ajax.request({
                method:'POST',
                url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicio/ejecutar',
                params:{
                    id:PresupuestoEjercicioLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
                },
                success:function(result, request ) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if(obj.success==true){
                PresupuestoEjercicioLista.main.store_lista.load();
                        Ext.Msg.alert("Notificación",obj.msg);
                    }else{
                        Ext.Msg.alert("Notificación",obj.msg);
                    }
                    PresupuestoEjercicioLista.main.mascara.hide();
            }});
        }
        });
    }
});

this.editar.disable();
this.eliminar.disable();
this.ae.disable();
this.importar.disable();

function renderMonto(val, attr, record) { 
     return paqueteComunJS.funcion.getNumeroFormateado(val);     
} 

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Carga de Presupuesto de Gasto en Ejercicio',
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
        this.ae,'-',
        this.importar
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},
    {header: 'Ejercicio', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb013_anio_fiscal'},
    {header: 'Tipo', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb086_tipo_prac'},
    {header: 'Ejecutor', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'ejecutor'},
    {header: 'Numero', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_proyecto_ac'},
    {header: 'Descripcion', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'de_proyecto_ac'},
    {header: 'Monto Presupuestado', width:120,  menuDisabled:true, sortable: true, renderer:renderMonto, dataIndex: 'mo_presupuesto'},
    {header: 'Monto Cargado', width:120,  menuDisabled:true, sortable: true, renderer:renderMonto, dataIndex: 'mo_cargado'},
    {header: 'Estatus', width:100,  menuDisabled:true, sortable: true, renderer: change, dataIndex: 'in_cargado'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{
        cellclick:function(Grid, rowIndex, columnIndex,e ){
            PresupuestoEjercicioLista.main.editar.enable();
            PresupuestoEjercicioLista.main.eliminar.enable();
            PresupuestoEjercicioLista.main.ae.enable();
            PresupuestoEjercicioLista.main.importar.enable();
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

this.gridPanel_.render("contenedorPresupuestoEjercicioLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicio/storelista',
    root:'data',
    fields:[
            {name: 'id'},
            {name: 'id_tb080_sector'},
            {name: 'id_tb081_sub_sector'},
            {name: 'id_tb082_ejecutor'},
            {name: 'nu_proyecto_ac'},
            {name: 'de_proyecto_ac'},
            {name: 'id_tb013_anio_fiscal'},
            {name: 'id_tb086_tipo_prac'},
            {name: 'in_activo'},
            {name: 'created_at'},
            {name: 'updated_at'},
            {name: 'in_cargado'},
            {name: 'mo_cargado'},
            {name: 'mo_presupuesto'},
            {
				name: 'ejecutor',
				convert: function(v, r) {
						return r.nu_ejecutor + ' - ' + r.de_ejecutor;
				}
		    }
           ]
    });
    return this.store;
}
};
Ext.onReady(PresupuestoEjercicioLista.main.init, PresupuestoEjercicioLista.main);
</script>
<div id="contenedorPresupuestoEjercicioLista"></div>
<div id="formularioPresupuestoEjercicio"></div>
<div id="filtroPresupuestoEjercicio"></div>
