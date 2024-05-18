<script type="text/javascript">
Ext.ns("FondoTerceroLista");
FondoTerceroLista.main = {
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
        FondoTerceroLista.main.mascara.show();
        this.msg = Ext.get('formularioFondoTercero');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoTercero/editar',
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
	this.codigo  = FondoTerceroLista.main.gridPanel_.getSelectionModel().getSelected().get('co_ruta');
	FondoTerceroLista.main.mascara.show();
        this.msg = Ext.get('formularioFondoTercero');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoTercero/editar/codigo/'+this.codigo,
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
	this.codigo  = FondoTerceroLista.main.gridPanel_.getSelectionModel().getSelected().get('co_ruta');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoTercero/eliminar',
            params:{
                co_ruta:FondoTerceroLista.main.gridPanel_.getSelectionModel().getSelected().get('co_ruta')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    FondoTerceroLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                FondoTerceroLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroFondoTercero');
        FondoTerceroLista.main.mascara.show();
        FondoTerceroLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoTercero/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Fondo Tercero',
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
    {header: 'co_fondo_tercero',hidden:true, menuDisabled:true,dataIndex: 'co_fondo_tercero'},
    {header: 'Co solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){FondoTerceroLista.main.editar.enable();FondoTerceroLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

//this.gridPanel_.render("contenedorFondoTerceroLista");

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Fondo Tercero',
    modal:true,
    constrain:true,
    width:400,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.gridPanel_
    ]
});
this.winformPanel_.show();

this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoTercero/storelista',
    root:'data',
    fields:[
    {name: 'co_ruta'},
    {name: 'co_solicitud'},
    {name: 'co_tipo_solicitud'},
    {name: 'co_proceso'},
    {name: 'observacion'},
    {name: 'co_estatus_ruta'},
    {name: 'co_usuario'},
    {name: 'nu_orden'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'in_actual'},
    {name: 'in_cargar_dato'},
    {name: 'tx_ruta_reporte'},
    {name: 'tx_imagen'},
    {name: 'tx_documento'},
           ]
    });
    return this.store;
}
};
Ext.onReady(FondoTerceroLista.main.init, FondoTerceroLista.main);
</script>
<div id="contenedorFondoTerceroLista"></div>
<div id="formularioFondoTercero"></div>
<div id="filtroFondoTercero"></div>
