<script type="text/javascript">
Ext.ns("ContabilidadEditar");
ContabilidadEditar.main = {
init:function(){

this.storeCO_PROYECTO = this.getStoreCO_PROYECTO();
this.storeCO_ACCION = this.getStoreCO_ACCION();

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});
this.detalle_factura = '';
this.monto_total = 0;

this.co_detalle_compras  = '';
this.id_partida  = '';
this.monto  = '';
this.nu_partida  = '';
this.de_partida  = '';
this.co_tipo_movimiento = '';
this.co_presupuesto_movimiento = '';
this.tx_producto = '';


this.co_compra = new Ext.form.Hidden({
    name:'co_compra',
    value:this.OBJ.co_compras
});

this.co_solicitud = new Ext.form.Hidden({
    name:'co_solicitud',
    value:this.OBJ.co_solicitud
});


this.co_documento = new Ext.form.Hidden({
    name:'co_documento',
    value:this.OBJ.co_documento
});

this.co_ramo = new Ext.form.Hidden({
    name:'co_ramo',
    value:this.OBJ.co_ramo
});
//</ClavePrimaria>

this.store_lista   = this.getLista();


this.Registro = Ext.data.Record.create([
         {name: 'nu_factura', type: 'number'},
         {name: 'fe_emision', type: 'string'},
         {name: 'nu_base_imponible', type:'number'},
         {name: 'co_iva_factura', type:'number'},
         {name: 'nu_iva_factura', type: 'number'},                 
         {name: 'nu_total', type:'number'},
         {name: 'co_iva_retencion', type: 'number'},
         {name: 'nu_iva_retencion', type: 'number'},
         {name: 'nu_total_retencion', type:'number'},
         {name: 'total_pagar', type:'number'},   
         {name: 'nu_total_pagar', type:'number'},
         {name: 'tx_concepto', type:'number'},
         {name: 'json_detalle_retencion', type:'string'}
]);

this.hiddenJsonFactura  = new Ext.form.Hidden({
        name:'json_factura',
        value:''
});


this.comprometer = new Ext.Button({
    text: 'Comprometer',
    iconCls: 'icon-nuevo',
    handler: function () {       
	Ext.MessageBox.confirm('Confirmación', '¿Esta seguro de comprometer el monto '+paqueteComunJS.funcion.getNumeroFormateado(ContabilidadEditar.main.monto)+' a la partida '+ContabilidadEditar.main.nu_partida+'-'+ContabilidadEditar.main.de_partida+'?', function(boton){
	if(boton=="yes"){
             ContabilidadEditar.main.afectar_partida();
	}});
    }
});

this.descomprometer = new Ext.Button({
        text:'Descomprometer',
        iconCls: 'icon-eliminar',
        id:'id_descomprometer',
        handler: function(boton){
            Ext.MessageBox.confirm('Confirmación', '¿Esta seguro que desea descomprometer la partida?', function(boton){
            if(boton=="yes"){
                 ContabilidadEditar.main.afectar_partida();
            }});
        }
});

//Editar un registro
this.cambiar_partida= new Ext.Button({
    text:'Agregar Partida',
    iconCls: 'icon-add',
    handler:function(){	
	ContabilidadEditar.main.mascara.show();
        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/agregarPartida',
         scripts: true,
         text: "Cargando..",
         params:{
             de_ejecutor:ContabilidadEditar.main.OBJ.de_ejecutor,
             co_ejecutor:ContabilidadEditar.main.OBJ.co_ejecutor,
             monto:ContabilidadEditar.main.monto,
             tx_producto:ContabilidadEditar.main.tx_producto,
             co_detalle_compras: ContabilidadEditar.main.co_detalle_compras,
             co_compras: ContabilidadEditar.main.OBJ.co_compras
         }
        });
    }
});

this.comprometer.disable();
this.descomprometer.disable();
this.cambiar_partida.disable();

this.monto_total = new Ext.form.DisplayField({
 value:"<span style='font-size:12px;'><b>Total a Pagar: </b>0,00</b></span>"
});

function renderMonto(val, attr, record) { 
     return paqueteComunJS.funcion.getNumeroFormateado(val);     
} 

function renderMontoDisponible(val, attr, record) { 
    if(parseFloat(record.data.mo_disponible) > parseFloat(record.data.monto)){
        return '<p style="color:green"><b>'+paqueteComunJS.funcion.getNumeroFormateado(record.data.mo_disponible)+'</b></p>';     
     }else{
        return '<p style="color:red"><b>'+paqueteComunJS.funcion.getNumeroFormateado(record.data.mo_disponible)+'</b></p>';  
     }
} 

//textoLargo

this.gridPanel = new Ext.grid.GridPanel({
        title:'Detalle de Conceptos',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:500,  
        width:1060,
        tbar:[this.comprometer,'-',this.descomprometer],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_detalle_compras', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_detalle_compras'},    
            {header: 'id_partida', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_partida'}, 
            {header: 'co_tipo_movimiento', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_tipo_movimiento'}, 
            {header: 'Estatus',width:130, menuDisabled:true,dataIndex: 'tx_tipo_movimiento'},    
            {header: 'Material',width:220, menuDisabled:true,dataIndex: 'tx_producto',renderer:textoLargo},                
            {header: 'Cod. Partida', width:100, menuDisabled:true,dataIndex: 'nu_partida'},
            {header: 'Partida',width:220, menuDisabled:true,dataIndex: 'de_partida',renderer:textoLargo},
            {header: 'Monto Disponible',width:180, menuDisabled:true,dataIndex: 'mo_disponible',renderer:renderMontoDisponible},
            {header: 'Monto',width:180, menuDisabled:true,dataIndex: 'monto',renderer:renderMonto}
        ], 
        bbar: new Ext.ux.StatusBar({
            id: 'basic-statusbar',
            autoScroll:true,
            defaults:{style:'color:black;font-size:30px;',autoWidth:true},
            items:[
             this.monto_total
            ]
        }),
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){            
            
            ContabilidadEditar.main.co_detalle_compras  = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('co_detalle_compras');
            ContabilidadEditar.main.id_partida  = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('co_partida');
            ContabilidadEditar.main.monto  = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('monto');
            ContabilidadEditar.main.nu_partida  = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('nu_partida');
            ContabilidadEditar.main.de_partida  = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('de_partida');
            ContabilidadEditar.main.co_tipo_movimiento  = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('co_tipo_movimiento');
            ContabilidadEditar.main.co_presupuesto_movimiento = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('co_presupuesto_movimiento');
            ContabilidadEditar.main.tx_producto = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('tx_producto');
             
            var mo_disponible = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('mo_disponible');
            
            if(ContabilidadEditar.main.co_tipo_movimiento == 0 || ContabilidadEditar.main.co_tipo_movimiento==4 || ContabilidadEditar.main.co_tipo_movimiento == 5){
                ContabilidadEditar.main.comprometer.enable();
                ContabilidadEditar.main.descomprometer.disable();
                ContabilidadEditar.main.cambiar_partida.enable();
            }else{
                ContabilidadEditar.main.descomprometer.enable();
                ContabilidadEditar.main.comprometer.disable();
                ContabilidadEditar.main.cambiar_partida.disable();
            } 
            
            if(parseFloat(mo_disponible)<parseFloat(ContabilidadEditar.main.monto)){
                ContabilidadEditar.main.comprometer.disable();
            }
            
            if(ContabilidadEditar.main.id_partida==''){
                ContabilidadEditar.main.comprometer.disable();
                ContabilidadEditar.main.descomprometer.disable();
                ContabilidadEditar.main.cambiar_partida.enable();
            }
            
        }}   
});

if(this.OBJ.co_compras!=''){

    ContabilidadEditar.main.store_lista.baseParams.co_compra=ContabilidadEditar.main.OBJ.co_compras;
    this.store_lista.load({
        callback: function(){
            ContabilidadEditar.main.total_pagar = paqueteComunJS.funcion.getSumaColumnaGrid({
                 store:ContabilidadEditar.main.store_lista,
                 campo:'monto'
            });
            
            ContabilidadEditar.main.monto_total.setValue("<span style='font-size:12px;'><b>Total a Pagar: </b>"+paqueteComunJS.funcion.getNumeroFormateado(ContabilidadEditar.main.total_pagar)+"</b></span>");     
        }
    });

}


this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ContabilidadEditar.main.winformPanel_.close();
    }
});


this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:1100,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[         this.co_compra,
                    this.co_documento,
                    this.co_ramo,
                    this.co_solicitud,
                    this.hiddenJsonFactura,
                    this.gridPanel
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Presupuesto',
    modal:true,
    constrain:true,
    width:1100,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.formPanel_
    ],
    buttons:[
       // this.guardar,
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
},
afectar_partida: function(){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/cambiarEstadoCompra',
            params:{
                co_detalle_compras: ContabilidadEditar.main.co_detalle_compras,
                co_solicitud: ContabilidadEditar.main.OBJ.co_solicitud,
                id_partida: ContabilidadEditar.main.id_partida,
                monto:ContabilidadEditar.main.monto,
                nu_partida:ContabilidadEditar.main.nu_partida,
                co_tipo_movimiento: ContabilidadEditar.main.co_tipo_movimiento,
                co_presupuesto_movimiento: ContabilidadEditar.main.co_tipo_movimiento,   
                co_compra: ContabilidadEditar.main.co_compra.getValue()
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
                    ContabilidadEditar.main.comprometer.disable();
                    ContabilidadEditar.main.descomprometer.disable();
                    ContabilidadEditar.main.cambiar_partida.disable();
		    ContabilidadEditar.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ContabilidadEditar.main.mascara.hide();
            }
        });
},getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storelista',
    root:'data',
    fields:[
                {name: 'co_partida'},
                {name :'co_detalle_compras'},
                {name :'tx_producto'},
                {name :'nu_partida'},
                {name :'de_partida'},
                {name :'mo_disponible'},
                {name :'monto'},
                {name :'co_tipo_movimiento'},
                {name: 'tx_tipo_movimiento'}
           ]
    });
    return this.store;      
},
getStoreCO_PROYECTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoproyecto',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_proyecto_ac',
            convert:function(v,r){
            return r.nu_proyecto_ac+' - '+r.de_proyecto_ac;
            }
            }
            ]
    });
    return this.store;
},
getStoreCO_ACCION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoaccion',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'accion_especifica',
            convert:function(v,r){
            return r.nu_accion_especifica+' - '+r.de_accion_especifica;
            }
            }
            ]
    });
    return this.store;
}
};
Ext.onReady(ContabilidadEditar.main.init, ContabilidadEditar.main);
</script>
<div id="formularioAgregar"></div>