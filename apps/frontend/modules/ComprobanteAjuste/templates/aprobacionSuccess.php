<script type="text/javascript">
Ext.ns("ComprobanteAjuste");
ComprobanteAjuste.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.store_lista = this.getLista();
this.store_lista_resumen   = this.getListaResumen();

this.co_comprobante_ajuste = new Ext.form.Hidden({
    name:'tb168_comprobante_ajustes[co_comprobante_ajuste]',
    value:this.OBJ.co_comprobante_ajuste
});

this.co_solicitud_ajuste = new Ext.form.Hidden({
    name:'tb168_comprobante_ajuste[co_solicitud_ajuste]',
    value:this.OBJ.co_solicitud_ajuste
    
});

this.co_solicitud = new Ext.form.Hidden({
    name:'tb168_comprobante_ajuste[co_solicitud]',
    value:this.OBJ.co_solicitud
});

this.co_orden_pago = new Ext.form.Hidden({
    name:'tb168_comprobante_ajuste[co_orden_pago]'
});

this.Registro = Ext.data.Record.create([
         {name: 'co_partida_comprobante_ajuste', type: 'number'},
         {name: 'co_partida_afectada', type: 'number'},
         {name: 'co_categoria_afectada', type: 'string'},
         {name: 'co_partida_desafectada', type:'number'},
         {name: 'co_categoria_desafectada', type:'string'},
         {name: 'co_detalle_compras', type:'number'},
         {name: 'monto', type:'number'},
]);

this.hiddenJsonPartida  = new Ext.form.Hidden({
        name:'json_partida',
        value:''
});


this.nu_odp = new Ext.form.TextField({
	fieldLabel:'ODP',
	name:'tb168_comprobante_ajuste[nu_odp]',
	readOnly:true,
        style:'background:#c9c9c9;',
        value: this.OBJ.nu_odp,
	width:150
});

if(this.OBJ.co_comprobante_ajuste!=''){
    ComprobanteAjuste.main.buscarODP();
}



this.tipo_solicitud = new Ext.form.TextField({
	fieldLabel:'Tipo Solicitud',
	name:'tb168_comprobante_ajuste[tx_tipo_solicitud]',
	value:this.OBJ.tx_descripcion,        
        readOnly:true,
        style:'background:#c9c9c9;',
	width:500
});


this.compositefieldODP = new Ext.form.CompositeField({
fieldLabel: 'Orden de Pago',
width:300,
items: [
	this.nu_odp
	]
});

this.fieldBusqueda= new Ext.form.FieldSet({
        items:[
            this.co_orden_pago,
            this.co_solicitud_ajuste,
            this.compositefieldODP,
            this.tipo_solicitud 
       ]
});



this.guardar = new Ext.Button({
    text: 'Procesar',
    iconCls: 'icon-fin',
    handler: function () {       
	Ext.MessageBox.confirm('Confirmación', '¿Esta seguro procesar el comprobante de ajuste?', function(boton){
	if(boton=="yes"){
             var flag = true;
             ComprobanteAjuste.main.store_lista_resumen.baseParams.co_comprobante_ajuste=ComprobanteAjuste.main.OBJ.co_comprobante_ajuste;
             ComprobanteAjuste.main.store_lista_resumen.load({
                 callback: function(){
                   ComprobanteAjuste.main.store_lista_resumen.each(function(record){
                            var    nu_partida;
                            var    de_partida;
                            var    mo_disponible;
                            var    monto;
                            var    monto_total;
                            var    id;

                            record.fields.each(function(field){
                                if(field.name=='id'){
                                    id = record.get(field.name);
                                }

                                if(field.name=='nu_partida'){
                                    nu_partida = record.get(field.name);
                                }

                                if(field.name=='de_partida'){
                                    de_partida = record.get(field.name);
                                }

                                if(field.name=='mo_disponible'){
                                    mo_disponible = record.get(field.name);
                                }

                                if(field.name=='monto'){
                                    monto = record.get(field.name);
                                }
                            });

                            monto_total = parseFloat(monto);

                            if(mo_disponible<monto_total){
                                flag = false;
                                Ext.MessageBox.alert('Error en transacción', "El monto de la partida <b>"+nu_partida+"-"+de_partida+"</b> es insuficiente, monto disponible "+paqueteComunJS.funcion.getNumeroFormateado(mo_disponible)+", monto comprobante de ajuste "+paqueteComunJS.funcion.getNumeroFormateado(monto_total));
                                return false;
                            }
                            
                        }, this);
                        
                        if(flag==true){
                             ComprobanteAjuste.main.afectar_partida();
                        }
                 }
             });
	}});
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ComprobanteAjuste.main.winformPanel_.close();
    }
});

function renderMonto(val, attr, record) {
     return paqueteComunJS.funcion.getNumeroFormateado(val);
}

this.agregar_ajuste = new Ext.Button({
    text: 'Agregar',
    iconCls: 'icon-nuevo',
    handler: function () {
        this.msg = Ext.get('formulario');
        
        var list_partida = paqueteComunJS.funcion.getJsonByObjStore({
                store:ComprobanteAjuste.main.gridPanel.getStore()
        });
        
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ComprobanteAjuste/agregarAjuste',
            scripts: true,
            text: "Cargando..",
            params:{
                co_solicitud_ajuste: ComprobanteAjuste.main.co_solicitud_ajuste.getValue(),
                co_orden_pago: ComprobanteAjuste.main.co_orden_pago.getValue(),
                lista_partida:list_partida
            }
        });
    }
});

this.botonEliminar = new Ext.Button({
    text:'Eliminar',
    iconCls: 'icon-eliminar',
    id:'eliminar',
    handler: function(boton){
        RequisicionEditar.main.eliminar();
    }
});

this.botonEliminar.disable();

this.gridPanel = new Ext.grid.GridPanel({
        title:'Partidas de Ajuste',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:300,
        width:1170,
//        tbar:[this.agregar_ajuste,'-',this.botonEliminar],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_detalle_compras', hidden: true, width:320, menuDisabled:true,dataIndex: 'co_detalle_compras'},
            {header: 'Desafectada',width:460, menuDisabled:true,dataIndex: 'co_categoria_desafectada',renderer:textoLargo},
            {header: 'Afectada',width:460, menuDisabled:true,dataIndex: 'co_categoria_afectada',renderer:textoLargo},
            {header: 'Monto',width:200, menuDisabled:true,dataIndex: 'monto',renderer:renderMonto}
        ],
        stripeRows: true,
        autoScroll:true,
        stateful: true
});

this.store_lista.baseParams.co_solicitud = this.OBJ.co_solicitud;
this.store_lista.load();

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:1200,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.co_solicitud,
           this.co_comprobante_ajuste,
           this.hiddenJsonPartida,
           this.fieldBusqueda,
           this.gridPanel]
});

if(this.OBJ.in_procesado!=''){
    this.guardar.disable();
}

this.winformPanel_ = new Ext.Window({
    title:'Comprobante de Ajuste',
    modal:true,
    constrain:true,
    width:1200,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.formPanel_
    ],
    buttons:[
        this.guardar,
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
//PagoNominaLista.main.mascara.hide();
},getListaResumen: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ComprobanteAjuste/storelistaResumen',
    root:'data',
    fields:[
 
                {name :'nu_partida'},
                {name :'de_partida'},
                {name :'mo_disponible'},
                {name :'monto'},
                {name: 'id'}
           ]
    });
    return this.store;      
},
afectar_partida: function(){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ComprobanteAjuste/cambiarEstado',
            params:{
                co_comprobante_ajuste: ComprobanteAjuste.main.co_comprobante_ajuste.getValue(),
                co_solicitud: ComprobanteAjuste.main.co_solicitud.getValue()
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
                    ComprobanteAjuste.main.guardar.disable();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ComprobanteAjuste.main.mascara.hide();
       }});
},getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ComprobanteAjuste/storelistaComprobanteAjuste',
    root:'data',
    fields:[ 
                {name: 'co_partida_comprobante_ajuste'},
                {name: 'co_detalle_compras'},
                {name: 'co_partida_afectada'},
                {name: 'co_categoria_afectada'},
                {name: 'co_partida_desafectada'},
                {name: 'co_categoria_desafectada'},
                {name: 'monto'}
           ]
    });
    return this.store;
},buscarODP: function(){
        Ext.Ajax.request({
                    method:'GET',
                    url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/ComprobanteAjuste/verificarODP',
                    params:{
                        nu_odp: ComprobanteAjuste.main.nu_odp.getValue()
                    },
                    success:function(result, request ) {
                        obj = Ext.util.JSON.decode(result.responseText);
                        if(!obj.data){
                                ComprobanteAjuste.main.tipo_solicitud.setValue("");
                                ComprobanteAjuste.main.co_solicitud_ajuste.setValue("");

                                Ext.Msg.show({
                                title : 'ALERTA',
                                msg : 'La Orden de Pago no se encuentra registrada',
                                width : 400,
                                height : 800,
                                closable : false,
                                buttons : Ext.Msg.OK,
                                icon : Ext.Msg.INFO
                            });

                        }else{

                            ComprobanteAjuste.main.tipo_solicitud.setValue(obj.data.tx_tipo_solicitud);
                            ComprobanteAjuste.main.co_solicitud_ajuste.setValue(obj.data.co_solicitud);
                            ComprobanteAjuste.main.co_orden_pago.setValue(obj.data.co_orden_pago);
                        }
                    }
        });  
}
};
Ext.onReady(ComprobanteAjuste.main.init, ComprobanteAjuste.main);
</script>
<div id="formulario"></div>