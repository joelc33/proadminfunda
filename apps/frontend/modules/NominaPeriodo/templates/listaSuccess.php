<script type="text/javascript">
Ext.ns("NominaPeriodoLista");
NominaPeriodoLista.main = {
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
        NominaPeriodoLista.main.mascara.show();
        this.msg = Ext.get('formularioNominaPeriodo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/editar',
         scripts: true,
         text: "Cargando..",
         params:{
            co_solicitud:NominaPeriodoLista.main.OBJ.co_solicitud
            }
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = NominaPeriodoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nomina');
	NominaPeriodoLista.main.mascara.show();
        this.msg = Ext.get('formularioNominaPeriodo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/editar/codigo/'+this.codigo,
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
	this.codigo  = NominaPeriodoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nomina');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/eliminar',
            params:{
                co_nomina:NominaPeriodoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nomina')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    NominaPeriodoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                NominaPeriodoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroNominaPeriodo');
        NominaPeriodoLista.main.mascara.show();
        NominaPeriodoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    //title:'Lista de NominaPeriodo',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:450,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.eliminar,'-',this.filtro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_nomina',hidden:true, menuDisabled:true,dataIndex: 'co_nomina'},
    {header: 'Nomina', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'nomina'},
    {header: 'Sub-Grupo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'cod_grupo_nomina'},
    {header: 'Frecuencia de Pago', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'co_nom_frecuencia_pago'},
    {header: 'N°', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_nomina'},
    {header: 'Inicio', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_inicio'},
    {header: 'Cierre', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_fin'},
    {header: 'Fecha de Pago', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_pago'},
    {header: 'Estatus', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'id_tbrh060_nomina_estatus'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){NominaPeriodoLista.main.editar.enable();NominaPeriodoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

//this.gridPanel_.render("contenedorNominaPeriodoLista");

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Nomina Periodo',
    modal:true,
    constrain:true,
width:1114,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.gridPanel_
    ]
});
this.winformPanel_.show();

this.store_lista.baseParams.co_solicitud=NominaPeriodoLista.main.OBJ.co_solicitud;
this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/storelista',
    root:'data',
    fields:[
    {name: 'co_nomina'},
    {name: 'co_solicitud'},
    {name: 'co_tp_nomina'},
    {name: 'co_nom_frecuencia_pago'},
    {name: 'nu_nomina'},
    {name: 'de_nomina'},
    {name: 'de_observacion'},
    {name: 'fe_inicio'},
    {name: 'fe_fin'},
    {name: 'fe_pago'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'in_procesado'},
    {name: 'id_tbrh060_nomina_estatus'},
    {name: 'cod_grupo_nomina'},
    {
        name: 'nomina',
        convert: function(v, r) {
                return r.cod_nomina + ' - ' + r.co_tp_nomina;
        }
    }
           ]
    });
    return this.store;
}
};
Ext.onReady(NominaPeriodoLista.main.init, NominaPeriodoLista.main);
</script>
<div id="contenedorNominaPeriodoLista"></div>
<div id="formularioNominaPeriodo"></div>
<div id="filtroNominaPeriodo"></div>
