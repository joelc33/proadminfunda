<script type="text/javascript">
Ext.ns("TramiteLista");
TramiteLista.main = {
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
        TramiteLista.main.mascara.show();
        this.msg = Ext.get('formularioTramite');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Tramite/editar',
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
	this.codigo  = TramiteLista.main.gridPanel_.getSelectionModel().getSelected().get('co_tipo_solicitud');
	TramiteLista.main.mascara.show();
        this.msg = Ext.get('formularioTramite');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Tramite/editar/codigo/'+this.codigo,
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
	this.codigo  = TramiteLista.main.gridPanel_.getSelectionModel().getSelected().get('co_tipo_solicitud');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Tramite/eliminar',
            params:{
                co_tipo_solicitud:TramiteLista.main.gridPanel_.getSelectionModel().getSelected().get('co_tipo_solicitud')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    TramiteLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                TramiteLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroTramite');
        TramiteLista.main.mascara.show();
        TramiteLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Tramite/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Tramite',
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
        {header: 'co_tipo_solicitud',hidden:true, menuDisabled:true,dataIndex: 'co_tipo_solicitud'},
        {header: 'Proceso', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tx_proceso'},
        {header: 'Tramite', width:500,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tipo_solicitud'},
        {header: 'Ver', width:50,  menuDisabled:true, sortable: true,  dataIndex: 'in_ver'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
        TramiteLista.main.editar.enable();
        TramiteLista.main.eliminar.enable();
    
        var msg = Ext.get('detalle');
        msg.load({
                url: '<?php echo $_SERVER['SCRIPT_NAME']?>/ConfiguracionRuta/lista',
                scripts: true,
                params:
                {
                    codigo: TramiteLista.main.store_lista.getAt(rowIndex).get('co_tipo_solicitud')

                },
                text: 'Cargando...'
        });
        
    
        if(panel_detalle.collapsed == true)
        {
            panel_detalle.toggleCollapse();
        } 
        
    }},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorTramiteLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Tramite/storelista',
    root:'data',
    fields:[
    {name: 'co_tipo_solicitud'},
    {name: 'tx_tipo_solicitud'},
    {name: 'in_ver'},
    {name: 'tx_proceso'},
           ]
    });
    return this.store;
}
};
Ext.onReady(TramiteLista.main.init, TramiteLista.main);
</script>
<div id="contenedorTramiteLista"></div>
<div id="formularioTramite"></div>
<div id="filtroTramite"></div>
