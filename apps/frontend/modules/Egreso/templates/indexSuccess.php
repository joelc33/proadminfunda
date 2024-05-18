<script type="text/javascript">
Ext.ns("EgresoLista");
EgresoLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
//Mascara general del modulo
this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        EgresoLista.main.mascara.show();
        this.msg = Ext.get('formularioTrabajador');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Egreso/editar',
         scripts: true,
         text: "Cargando..",
         params:{
             co_solicitud: EgresoLista.main.OBJ.co_solicitud
         }
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = EgresoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_trabajador');
	EgresoLista.main.mascara.show();
        this.msg = Ext.get('formularioTrabajador');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Egreso/editar/codigo/'+this.codigo,
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
	this.codigo  = EgresoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_trabajador');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Egreso/eliminar',
            params:{
                co_egreso:EgresoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_egreso'),
                co_ficha:EgresoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_ficha')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    EgresoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                EgresoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroTrabajador');
        EgresoLista.main.mascara.show();
        EgresoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Trabajador',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-', //this.editar,'-',
        this.eliminar
    ],
    columns: [
    new Ext.grid.RowNumberer(),            
        {header: 'co_egreso',hidden:true, menuDisabled:true,dataIndex: 'co_egreso'},
        {header: 'co_ficha',hidden:true, menuDisabled:true,dataIndex: 'co_ficha'},
        {header: 'Cédula', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cedula'},
        {header: 'Nombre y Apellido', width:400,  menuDisabled:true, sortable: true,  dataIndex: 'nb_primer_nombre'},
        {header: 'Fecha Egreso', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_egreso'},
        {header: 'Fecha Movimiento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_movimiento'},
        {header: 'Situación', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'tx_nom_situacion'},
        {header: 'Nomina', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tp_nomina'},
        {header: 'Tipo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_grupo_nomina'},
        {header: 'Cargo', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'tx_cargo'}        
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){EgresoLista.main.editar.enable();EgresoLista.main.eliminar.enable();}}
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        EgresoLista.main.winformPanel_.close();
    }
});

this.winformPanel_ = new Ext.Window({
    title:'Agregar Trabajador',
    modal:true,
    constrain:true,
    width:1300,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.gridPanel_
    ],
    buttons:[
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();

this.store_lista.baseParams.co_solicitud = this.OBJ.co_solicitud;
this.store_lista.load();

},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Egreso/storelista',
    root:'data',
    fields:[
                {name: 'co_trabajador'},
                {name: 'co_egreso'},
                {name: 'co_ficha'},
                {name: 'nu_cedula'},
                {name: 'nb_primer_nombre'},
                {name: 'nb_segundo_nombre'},
                {name: 'nb_primer_apellido'},
                {name: 'nb_segundo_apellido'},
                {name: 'co_documento'},
                {name: 'fe_egreso'},
                {name: 'fe_movimiento'},
                {name: 'tx_nom_situacion'},
                {name: 'tx_cargo'},
                {name: 'tx_grupo_nomina'},
                {name: 'tx_tp_nomina'}
           ]
    });
    return this.store;
}
};
Ext.onReady(EgresoLista.main.init, EgresoLista.main);
</script>
<div id="contenedorEgresoLista"></div>
<div id="formularioTrabajador"></div>
<div id="filtroTrabajador"></div>
