<script type="text/javascript">
Ext.ns("RetencionesLista");
RetencionesLista.main = {
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
        RetencionesLista.main.mascara.show();
        this.msg = Ext.get('formularioRetenciones');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Retenciones/editar',
         scripts: true,
         text: "Cargando..",
         params:{
             co_tipo_retencion: RetencionesLista.main.OBJ.co_tipo_retencion
         }
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = RetencionesLista.main.gridPanel_.getSelectionModel().getSelected().get('co_retencion');
	RetencionesLista.main.mascara.show();
        this.msg = Ext.get('formularioRetenciones');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Retenciones/editar/codigo/'+this.codigo,
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
	this.codigo  = RetencionesLista.main.gridPanel_.getSelectionModel().getSelected().get('co_retencion');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Retenciones/eliminar',
            params:{
                co_retencion:RetencionesLista.main.gridPanel_.getSelectionModel().getSelected().get('co_retencion')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    RetencionesLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                RetencionesLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroRetenciones');
        RetencionesLista.main.mascara.show();
        RetencionesLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Retenciones/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

function renderUnidad(val, attr, record) {    
    
    return val+'%';
    
}

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Retenciones',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar
    ],
    columns: [
    new Ext.grid.RowNumberer(),
        {header: 'co_retencion',hidden:true, menuDisabled:true,dataIndex: 'co_retencion'},
        {header: 'Tipo de Proveedor', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_documento'},
        {header: 'Concepto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_ramo'},
        {header: 'Retención', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'nu_valor',renderer: renderUnidad},
        {header: 'Monto Mínimo', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'mo_minimo'},
        {header: 'Codigo', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'nu_concepto'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
        RetencionesLista.main.editar.enable();
        RetencionesLista.main.eliminar.enable();
    }},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

RetencionesLista.main.store_lista.baseParams.co_tipo_retencion = this.OBJ.co_tipo_retencion;
this.gridPanel_.render("contenedorRetencionesLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Retenciones/storelista',
    root:'data',
    fields:[
            {name: 'co_retencion'},
            {name: 'tx_documento'},
            {name: 'tx_tipo_retencion'},
            {name: 'nu_valor'},
            {name: 'nu_sustraendo'},
            {name: 'tx_ramo'},
            {name: 'mo_minimo'},
            {name: 'nu_concepto'},
           ]
    });
    return this.store;
}
};
Ext.onReady(RetencionesLista.main.init, RetencionesLista.main);
</script>
<div id="contenedorRetencionesLista"></div>
<div id="formularioRetenciones"></div>
<div id="filtroRetenciones"></div>
