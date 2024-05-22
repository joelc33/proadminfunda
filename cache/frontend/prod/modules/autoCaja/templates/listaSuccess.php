<script type="text/javascript">
Ext.ns("CajaLista");
CajaLista.main = {
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
        CajaLista.main.mascara.show();
        this.msg = Ext.get('formularioCaja');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Caja/editar',
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
	this.codigo  = CajaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_ruta');
	CajaLista.main.mascara.show();
        this.msg = Ext.get('formularioCaja');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Caja/editar/codigo/'+this.codigo,
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
	this.codigo  = CajaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_ruta');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Caja/eliminar',
            params:{
                co_ruta:CajaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_ruta')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    CajaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                CajaLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroCaja');
        CajaLista.main.mascara.show();
        CajaLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Caja/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Caja',
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
    {header: 'co_ruta',hidden:true, menuDisabled:true,dataIndex: 'co_ruta'},
    {header: 'Co solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud'},
    {header: 'Co tipo solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_tipo_solicitud'},
    {header: 'Co proceso', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_proceso'},
    {header: 'Observacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'observacion'},
    {header: 'Co estatus ruta', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_estatus_ruta'},
    {header: 'Co usuario', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_usuario'},
    {header: 'Nu orden', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_orden'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    {header: 'Updated at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'updated_at'},
    {header: 'In actual', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_actual'},
    {header: 'In cargar dato', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_cargar_dato'},
    {header: 'Tx ruta reporte', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_ruta_reporte'},
    {header: 'Tx imagen', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_imagen'},
    {header: 'Tx documento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_documento'},
    {header: 'Co usuario actualizo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_usuario_actualizo'},
    {header: 'Co solicitud anular', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud_anular'},
    {header: 'In anular', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_anular'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){CajaLista.main.editar.enable();CajaLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorCajaLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Caja/storelista',
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
    {name: 'co_usuario_actualizo'},
    {name: 'co_solicitud_anular'},
    {name: 'in_anular'},
           ]
    });
    return this.store;
}
};
Ext.onReady(CajaLista.main.init, CajaLista.main);
</script>
<div id="contenedorCajaLista"></div>
<div id="formularioCaja"></div>
<div id="filtroCaja"></div>
