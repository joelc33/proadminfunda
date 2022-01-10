<script type="text/javascript">
Ext.ns("NominaMovimientoLista");
NominaMovimientoLista.main = {
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
        NominaMovimientoLista.main.mascara.show();
        this.msg = Ext.get('formularioNominaPeriodo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/editar',
         scripts: true,
         text: "Cargando..",
         params:{
            co_solicitud:NominaMovimientoLista.main.OBJ.co_solicitud
            }
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Calculos',
    iconCls: 'icon-calculator_link',
    handler:function(){
	NominaMovimientoLista.main.mascara.show();
        this.msg = Ext.get('formularioNominaPeriodo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/detalleCerrar',
         scripts: true,
         text: "Cargando..",
         params:{
            id_tbrh013_nomina:NominaMovimientoLista.main.gridPanel_.getSelectionModel().getSelected().get('id_tbrh013_nomina'),
            id_tbrh002_ficha:NominaMovimientoLista.main.gridPanel_.getSelectionModel().getSelected().get('id_tbrh002_ficha'),
            id_tbrh015_nom_trabajador:NominaMovimientoLista.main.gridPanel_.getSelectionModel().getSelected().get('id_tbrh015_nom_trabajador')
         },
        });
    }
});

//Eliminar un registro
this.eliminar= new Ext.Button({
    text:'Eliminar',
    iconCls: 'icon-eliminar',
    handler:function(){
	this.codigo  = NominaMovimientoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nomina');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/eliminar',
            params:{
                co_nomina:NominaMovimientoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nomina')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    NominaMovimientoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                NominaMovimientoLista.main.mascara.hide();
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
        NominaMovimientoLista.main.mascara.show();
        NominaMovimientoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

function formatoNroColorVerde(val){
	return "<span style='color:green;'>"+paqueteComunJS.funcion.getNumeroFormateado(val)+'</span>';
}

function formatoNroColorAzul(val){
	return "<span style='color:blue;'>"+paqueteComunJS.funcion.getNumeroFormateado(val)+'</span>';
}

function formatoNroColorRojo(val){
	return "<span style='color:red;'>"+paqueteComunJS.funcion.getNumeroFormateado(val)+'</span>';
}

function formatoNroColorGris(val){
	return "<span style='color:gray;'>"+paqueteComunJS.funcion.getNumeroFormateado(val)+'</span>';
}

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    //title:'Lista de NominaPeriodo',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:520,
    tbar:[
        this.editar,'-',this.filtro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'id_tbrh013_nomina',hidden:true, menuDisabled:true,dataIndex: 'id_tbrh013_nomina'},
    {header: 'id_tbrh002_ficha',hidden:true, menuDisabled:true,dataIndex: 'id_tbrh002_ficha'},
    {header: 'id_tbrh015_nom_trabajador',hidden:true, menuDisabled:true,dataIndex: 'id_tbrh015_nom_trabajador'},
    {header: 'N° Documento', width:120,  menuDisabled:true, sortable: true,  dataIndex: 'documento'},
    {header: 'Nombre y Apellido', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'nombre'},
    {header: 'Asignaciones', width:180,  menuDisabled:true, sortable: true, renderer: formatoNroColorAzul, dataIndex: 'mo_asignacion'},
    {header: 'Deducciones', width:180,  menuDisabled:true, sortable: true, renderer: formatoNroColorRojo, dataIndex: 'mo_deduccion'},
    {header: 'Patronales', width:180,  menuDisabled:true, sortable: true, renderer: formatoNroColorGris, dataIndex: 'mo_patronal'},
    {header: 'Monto a Pagar', width:180,  menuDisabled:true, sortable: true, renderer: formatoNroColorVerde, dataIndex: 'mo_pago'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{
        cellclick:function(Grid, rowIndex, columnIndex,e ){
            NominaMovimientoLista.main.editar.enable();
            NominaMovimientoLista.main.eliminar.enable();
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

//this.gridPanel_.render("contenedorNominaMovimientoLista");

this.winformPanel_ = new Ext.Window({
    title:'Movimientos de Nomina: ',
    modal:true,
    constrain:true,
width:1124,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.gridPanel_
    ]
});
this.winformPanel_.show();
NominaPeriodoLista.main.mascara.hide();

this.store_lista.baseParams.co_nomina=NominaMovimientoLista.main.OBJ.id_tbrh013_nomina;
this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/storelistaEmpleadoCerrar',
    root:'data',
    fields:[
    {name: 'id_tbrh013_nomina'},
    {name: 'id_tbrh002_ficha'},
    {name: 'id_tbrh015_nom_trabajador'},
    {name: 'nu_ficha'},
    {name: 'nu_cedula'},
    {name: 'inicial'},
    {
        name: 'documento',
        convert: function(v, r) {
                return r.inicial + ' - ' + r.nu_cedula;
        }
    },
    {name: 'nombre'},
    {name: 'nu_ficha'},
    {name: 'mo_pago'},
    {name: 'mo_asignacion'},
    {name: 'mo_deduccion'},
    {name: 'mo_patronal'}
    ]
    });
    return this.store;
}
};
Ext.onReady(NominaMovimientoLista.main.init, NominaMovimientoLista.main);
</script>
<div id="contenedorNominaMovimientoLista"></div>
<div id="formularioNominaPeriodo"></div>
<div id="filtroNominaPeriodo"></div>
