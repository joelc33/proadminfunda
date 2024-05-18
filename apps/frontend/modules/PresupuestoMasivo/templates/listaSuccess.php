<script type="text/javascript">
Ext.ns("PresupuestoMasivoLista");
function change(val){
	if(val==true){
	    return '<span style="color:green;">Cargado</span>';
	}else if(val==false){
	    return '<span style="color:red;">Pendiente</span>';
	}
return val;
};
PresupuestoMasivoLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

//Agregar un registro
this.importar = new Ext.Button({
    text:'Importar',
    iconCls: 'icon-descargar',
    handler:function(){
        PresupuestoMasivoLista.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoMasivo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoMasivo/importar',
         scripts: true,
         text: "Cargando.."
        });
    }
});

function renderMonto(val, attr, record) { 
     return paqueteComunJS.funcion.getNumeroFormateado(val);     
} 

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Carga de Presupuesto Masivo',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
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
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorPresupuestoMasivoLista");


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
Ext.onReady(PresupuestoMasivoLista.main.init, PresupuestoMasivoLista.main);
</script>
<div id="contenedorPresupuestoMasivoLista"></div>
<div id="formularioPresupuestoMasivo"></div>
<div id="filtroPresupuestoEjercicio"></div>