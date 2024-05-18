<script type="text/javascript">
Ext.ns("MovimientoLista");
MovimientoLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista_devengado = this.getLista();
this.store_lista_liquidado      = this.getLista();
this.store_lista_recaudado       = this.getLista();
this.store_lista_aumento      = this.getListaMovimiento();
this.store_lista_disminucion  = this.getListaMovimiento();


//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        MovimientoLista.main.mascara.show();
        this.msg = Ext.get('formularioMovimiento');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/editar',
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
	this.codigo  = MovimientoLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	MovimientoLista.main.mascara.show();
        this.msg = Ext.get('formularioMovimiento');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/editar/codigo/'+this.codigo,
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
	this.codigo  = MovimientoLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/eliminar',
            params:{
                id:MovimientoLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    MovimientoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                MovimientoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Exportar',
    iconCls: 'icon-descargar',
    handler:function(){
        window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/movimiento_XLS.php?tipo=1&partida='+MovimientoLista.main.OBJ.codigo);
    }
});

this.filtro2 = new Ext.Button({
    text:'Exportar',
    iconCls: 'icon-descargar',
    handler:function(){
        window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/movimiento_XLS.php?tipo=2&partida='+MovimientoLista.main.OBJ.codigo);
    }
});

this.filtro3 = new Ext.Button({
    text:'Exportar',
    iconCls: 'icon-descargar',
    handler:function(){
        window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/movimiento_XLS.php?tipo=3&partida='+MovimientoLista.main.OBJ.codigo);
    }
});

this.filtro4 = new Ext.Button({
    text:'Exportar',
    iconCls: 'icon-descargar',
    handler:function(){
        window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/movimiento_XLS.php?tipo=2&partida='+MovimientoLista.main.OBJ.codigo);
    }
});

this.filtro5 = new Ext.Button({
    text:'Exportar',
    iconCls: 'icon-descargar',
    handler:function(){
        window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/movimiento_XLS.php?tipo=1&partida='+MovimientoLista.main.OBJ.codigo);
    }
});

this.editar.disable();
this.eliminar.disable();

function formatoNro(val){
	return '<p align="right">'+paqueteComunJS.funcion.getNumeroFormateado(val)+'</p>';
}

//Grid principal
this.gridPanel_Devengado = new Ext.grid.GridPanel({
    //title:'Lista de Movimiento',
    //iconCls: 'icon-libro',
    store: this.store_lista_devengado,
    loadMask:true,
//    frame:true,
    height:520,
    border:false,    
    tbar:[
        this.filtro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
        {header: 'Solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud'},
        {header: 'Monto', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'nu_monto',renderer:formatoNro},
        {header: 'Fecha', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
//        {header: 'Orden de Pago', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_serial'},
//        {header: 'RIF', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_rif'},
//        {header: 'Razon Social', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'tx_razon_social'}        


    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true
});

this.gridPanel_Liquidado = new Ext.grid.GridPanel({
    //title:'Lista de Movimiento',
    //iconCls: 'icon-libro',
    store: this.store_lista_liquidado,
    loadMask:true,
//    frame:true,
    height:520,
    border:false,
    tbar:[
        this.filtro2
    ],
    columns: [
    new Ext.grid.RowNumberer(),
        {header: 'Solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud'},
        {header: 'Monto', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'nu_monto',renderer:formatoNro},
        {header: 'Fecha', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
//        {header: 'Orden de Pago', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_serial'}, 
//        {header: 'RIF', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_rif'},
//        {header: 'Razon Social', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'tx_razon_social'}        

    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true
});

this.gridPanel_Recaudado = new Ext.grid.GridPanel({
    store: this.store_lista_recaudado,
    loadMask:true,
    height:520,
    border:false,
    tbar:[
        this.filtro3
    ],
    columns: [
    new Ext.grid.RowNumberer(),
        {header: 'Solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud'},
        {header: 'Monto', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'nu_monto',renderer:formatoNro},
        {header: 'Fecha', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
//        {header: 'Orden de Pago', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_serial'}, 
//        {header: 'RIF', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_rif'},
//        {header: 'Razon Social', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'tx_razon_social'}        
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true
});


this.gridPanel_Aumento = new Ext.grid.GridPanel({
    store: this.store_lista_aumento,
    loadMask:true,
    height:520,
    border:false,
    tbar:[
        this.filtro4
    ],
    columns: [
    new Ext.grid.RowNumberer(),
        {header: 'Solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud'},
        {header: 'Monto', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'mo_distribucion',renderer:formatoNro},
        {header: 'Fecha', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
        {header: 'Nro', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_modificacion'}, 
        {header: 'Descripción', width:400,  menuDisabled:true, sortable: true,  dataIndex: 'de_modificacion'}        
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true
});

this.gridPanel_Disminucion = new Ext.grid.GridPanel({
    store: this.store_lista_disminucion,
    loadMask:true,
    height:520,
    border:false,
    tbar:[
        this.filtro5
    ],
    columns: [
    new Ext.grid.RowNumberer(),
        {header: 'Solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud'},
        {header: 'Monto', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'mo_distribucion',renderer:formatoNro},
        {header: 'Fecha', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
        //{header: 'Orden de Pago', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_serial'}, 
        {header: 'Nro', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_modificacion'}, 
        {header: 'Descripción', width:400,  menuDisabled:true, sortable: true,  dataIndex: 'de_modificacion'}         
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true
});


this.total_devengado = new Ext.form.DisplayField({
    value:"<span style='font-size:12px;'><b>Total Devengado: </b>0,00</b></span>"
});

this.total_liquidado = new Ext.form.DisplayField({
    value:"<span style='font-size:12px;'><b>Total Liquidado: </b>0,00</b></span>"
});

this.total_recaudado = new Ext.form.DisplayField({
    value:"<span style='font-size:12px;'><b>Total Recaudado: </b>0,00</b></span>"
});

this.total_aumento = new Ext.form.DisplayField({
    value:"<span style='font-size:12px;'><b>Total Aumento: </b>0,00</b></span>"
});

this.total_disminucion = new Ext.form.DisplayField({
    value:"<span style='font-size:12px;'><b>Total Disminución: </b>0,00</b></span>"
});

this.tabuladores = new Ext.TabPanel({
        resizeTabs:true, // turn on tab resizing
        minTabWidth: 100,
        border:false,
        enableTabScroll:true,
        autoWidth:true,
      //  deferredRender:false,
        autoHeight:true,
        activeTab: 0,
        defaults: {autoScroll:true},
        items:[
                {
                        title: 'Devengado',
                        items:[this.gridPanel_Devengado]
                },
                {
                        title: 'Liquidado',
                        items:[this.gridPanel_Liquidado]
                },
                {
                        title: 'Recaudado',
                        items:[this.gridPanel_Recaudado]
                },
                {
                        title: 'Aumento',
                        items:[this.gridPanel_Aumento]
                },
                {
                        title: 'Disminucion',
                        items:[this.gridPanel_Disminucion]
                }
        ],
        bbar: new Ext.ux.StatusBar({
            id: 'basic-statusbar',
            autoScroll:true,
            defaults:{style:'color:black;font-size:30px;',autoWidth:true},
            items:[ this.total_devengado,'-',
                    this.total_liquidado,'-',
                    this.total_recaudado,'-',
                    this.total_aumento,'-',
                    this.total_disminucion]
        }), 
});

//this.gridPanel_.render("contenedorMovimientoLista");

this.winformPanel_ = new Ext.Window({
    title:'Movimientos Presupuesto de Ingreso',
    modal:true,
    constrain:true,
    width:1000,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.tabuladores
    ]
});
this.winformPanel_.show();
PresupuestoIngresoLista.main.mascara.hide();

MovimientoLista.main.store_lista_devengado.baseParams.codigo=MovimientoLista.main.OBJ.codigo;
MovimientoLista.main.store_lista_devengado.baseParams.co_tipo_movimiento ='9';
MovimientoLista.main.store_lista_devengado.load({
    callback: function(){
                var monto = paqueteComunJS.funcion.getSumaColumnaGrid({
                    store:MovimientoLista.main.store_lista_devengado,
                    campo:'nu_monto'
                });
                    
                MovimientoLista.main.total_devengado.setValue("<span style='font-size:12px;'><b>Total Devengado: </b>"+paqueteComunJS.funcion.getNumeroFormateado(monto)+"</b></span>");     

    }
});

MovimientoLista.main.store_lista_liquidado.baseParams.codigo=MovimientoLista.main.OBJ.codigo;
MovimientoLista.main.store_lista_liquidado.baseParams.co_tipo_movimiento ='10';
MovimientoLista.main.store_lista_liquidado.load({
    callback: function(){
                var monto = paqueteComunJS.funcion.getSumaColumnaGrid({
                    store:MovimientoLista.main.store_lista_liquidado,
                    campo:'nu_monto'
                });
                    
                MovimientoLista.main.total_liquidado.setValue("<span style='font-size:12px;'><b>Total Liquidado: </b>"+paqueteComunJS.funcion.getNumeroFormateado(monto)+"</b></span>");     

    }
});

MovimientoLista.main.store_lista_recaudado.baseParams.codigo=MovimientoLista.main.OBJ.codigo;
MovimientoLista.main.store_lista_recaudado.baseParams.co_tipo_movimiento ='11';
MovimientoLista.main.store_lista_recaudado.load({
    callback: function(){
                var monto = paqueteComunJS.funcion.getSumaColumnaGrid({
                    store:MovimientoLista.main.store_lista_recaudado,
                    campo:'nu_monto'
                });
                    
                MovimientoLista.main.total_recaudado.setValue("<span style='font-size:12px;'><b>Total Recaudado: </b>"+paqueteComunJS.funcion.getNumeroFormateado(monto)+"</b></span>");     

    }
});

MovimientoLista.main.store_lista_aumento.baseParams.codigo=MovimientoLista.main.OBJ.codigo;
MovimientoLista.main.store_lista_aumento.baseParams.co_tipo_movimiento ='7';
MovimientoLista.main.store_lista_aumento.load({
    callback: function(){
                var monto = paqueteComunJS.funcion.getSumaColumnaGrid({
                    store:MovimientoLista.main.store_lista_aumento,
                    campo:'mo_distribucion'
                });
                    
                MovimientoLista.main.total_aumento.setValue("<span style='font-size:12px;'><b>Total Aumento: </b>"+paqueteComunJS.funcion.getNumeroFormateado(monto)+"</b></span>");     

    }
});

MovimientoLista.main.store_lista_disminucion.baseParams.codigo=MovimientoLista.main.OBJ.codigo;
MovimientoLista.main.store_lista_disminucion.baseParams.co_tipo_movimiento ='8';
MovimientoLista.main.store_lista_disminucion.load({
    callback: function(){
                var monto = paqueteComunJS.funcion.getSumaColumnaGrid({
                    store:MovimientoLista.main.store_lista_disminucion,
                    campo:'mo_distribucion'
                });
                    
                MovimientoLista.main.total_disminucion.setValue("<span style='font-size:12px;'><b>Total Disminución: </b>"+paqueteComunJS.funcion.getNumeroFormateado(monto)+"</b></span>");     

    }
});

},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/storelistaIngreso',
    root:'data',
    fields:[
            {name: 'nu_monto'},
            {name: 'created_at'},
            {name: 'co_solicitud'}
           ]
    });
    return this.store;
},
getListaMovimiento: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/storelistaMovimientoIngreso',
    root:'data',
    fields:[
            {name: 'de_tipo_movimiento'},
            {name: 'mo_distribucion'},
            {name: 'created_at'},
            {name: 'co_solicitud'},
            {name: 'de_modificacion'},
            {name: 'nu_modificacion'}
           ]
    });
    return this.store;
}
};
Ext.onReady(MovimientoLista.main.init, MovimientoLista.main);
</script>
<div id="contenedorMovimientoLista"></div>
<div id="formularioMovimiento"></div>
<div id="filtroMovimiento"></div>
