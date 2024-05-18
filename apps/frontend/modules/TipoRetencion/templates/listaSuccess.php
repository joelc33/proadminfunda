<script type="text/javascript">
Ext.ns("TipoRetencionLista");
TipoRetencionLista.main = {
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
        TipoRetencionLista.main.mascara.show();
        this.msg = Ext.get('formularioTipoRetencion');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TipoRetencion/editar',
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
	this.codigo  = TipoRetencionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_tipo_retencion');
	TipoRetencionLista.main.mascara.show();
        this.msg = Ext.get('formularioTipoRetencion');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TipoRetencion/editar/codigo/'+this.codigo,
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
	this.codigo  = TipoRetencionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_tipo_retencion');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TipoRetencion/eliminar',
            params:{
                co_tipo_retencion:TipoRetencionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_tipo_retencion')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    TipoRetencionLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                TipoRetencionLista.main.mascara.hide();
            }});
	}});
    }
});

this.cambiar_estado= new Ext.Button({
    text:'Cambiar Estado',
    iconCls: 'icon-anteriores',
    handler:function(){
	this.codigo  = TipoRetencionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_tipo_retencion');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea cambiar el estado a la retención?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TipoRetencion/cambiarEstado',
            params:{
                co_tipo_retencion:TipoRetencionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_tipo_retencion'),
                in_activo:TipoRetencionLista.main.gridPanel_.getSelectionModel().getSelected().get('in_activo')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    TipoRetencionLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                TipoRetencionLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroTipoRetencion');
        TipoRetencionLista.main.mascara.show();
        TipoRetencionLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/TipoRetencion/filtro',
             scripts: true
        });
    }
});

this.add_cuenta = new Ext.Button({
    text:'Agregar Cuenta Contable',
    iconCls: 'icon-nuevo',
    handler:function(){
        TipoRetencionLista.main.mascara.show();
        this.msg = Ext.get('formularioTipoRetencion');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TipoRetencion/planDeCuenta',
         scripts: true,
         text: "Cargando..",
         params:{
             co_tipo_retencion:TipoRetencionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_tipo_retencion')
         }
        });
    }
});


this.editar.disable();
this.eliminar.disable();
this.add_cuenta.disable();
this.cambiar_estado.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Tipo Retencion',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.add_cuenta,'-',this.cambiar_estado
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_tipo_retencion',hidden:true, menuDisabled:true,dataIndex: 'co_tipo_retencion'},
    {header: 'in_activo',hidden:true, menuDisabled:true,dataIndex: 'in_activo'},
    {header: 'Tipo de Retencion', width:500,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tipo_retencion'},
    {header: 'Clase de Retencion', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tx_clase_retencion'},
    {header: 'Cuenta Contable', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tx_cuenta'},
    {header: 'Estado', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'estado'}
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
        
        TipoRetencionLista.main.editar.enable();
        TipoRetencionLista.main.eliminar.enable();
        TipoRetencionLista.main.add_cuenta.enable();
        TipoRetencionLista.main.cambiar_estado.enable();
         
        var co_tipo_retencion = TipoRetencionLista.main.store_lista.getAt(rowIndex).get('co_tipo_retencion');
        var retencion = '';
        
        if(co_tipo_retencion!=4){
            retencion = 'Retenciones/index';
        }else{
            retencion = 'Retenciones/islr';
        }
    
        var msg = Ext.get('detalle');
        msg.load({
                url: '<?php echo $_SERVER['SCRIPT_NAME']?>/'+retencion,
                scripts: true,
                params:{
                    co_tipo_retencion: co_tipo_retencion
                },
                text: 'Cargando...'
        });        
    
        if(panel_detalle.collapsed == true){
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

this.gridPanel_.render("contenedorTipoRetencionLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TipoRetencion/storelista',
    root:'data',
    fields:[
            {name: 'co_tipo_retencion'},
            {name: 'tx_tipo_retencion'},
            {name: 'tx_clase_retencion'},
            {name: 'tx_cuenta'},
            {name: 'in_activo'},
            {name: 'estado'}
           ]
    });
    return this.store;
}
};
Ext.onReady(TipoRetencionLista.main.init, TipoRetencionLista.main);
</script>
<div id="contenedorTipoRetencionLista"></div>
<div id="formularioTipoRetencion"></div>
<div id="filtroTipoRetencion"></div>
