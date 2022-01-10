<script type="text/javascript">
Ext.ns("ContabilidadEditar");
ContabilidadEditar.main = {
init:function(){


this.storeCO_EJECUTOR = this.getStoreCO_EJECUTOR();
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
this.co_producto = ''


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

this.agregar_partida= new Ext.Button({
    text:'Agregar Partida',
    iconCls: 'icon-add',
    handler:function(){	
        
        if(ContabilidadEditar.main.co_ejecutor.getValue()=='')
        {
            Ext.Msg.alert("Notificación","Para agregar una partida, debe seleccionar un Ente Ejecutor "+ContabilidadEditar.main.co_ejecutor.getValue());
            return;
        }
        
	ContabilidadEditar.main.mascara.show();
        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/agregarPartidaCompra',
         scripts: true,
         text: "Cargando..",
         params:{
             de_ejecutor:ContabilidadEditar.main.co_ejecutor.lastSelectionText,
             co_ejecutor:ContabilidadEditar.main.co_ejecutor.getValue(),
             monto:ContabilidadEditar.main.monto,
             tx_producto:ContabilidadEditar.main.tx_producto,
             co_detalle_compras: ContabilidadEditar.main.co_detalle_compras,
             co_compras: ContabilidadEditar.main.OBJ.co_compras,
             co_partida:ContabilidadEditar.main.id_partida,
             co_producto:ContabilidadEditar.main.co_producto,
             co_solicitud:ContabilidadEditar.main.OBJ.co_solicitud
         }
        });
    }
});

this.quitar_partida= new Ext.Button({
    text:'Quitar Partida',
    iconCls: 'icon-cancelar',
    handler:function(){		
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar la partida?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/quitarPartida',
            params:{
                co_detalle_compras:ContabilidadEditar.main.gridPanel.getSelectionModel().getSelected().get('co_detalle_compras'),
                co_compras:ContabilidadEditar.main.OBJ.co_compras
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ContabilidadEditar.main.getCargarGrid();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
            }});
	}});
    }
});


this.agregar_partida.disable();
this.quitar_partida.disable();

this.co_ejecutor = new Ext.form.ComboBox({
	fieldLabel:'Ente Ejecutor',
	store: this.storeCO_EJECUTOR,
	typeAhead: true,
	valueField: 'id',
    id:'co_ejecutor',
	displayField:'ejecutor',
	hiddenName:'tb052_compras[co_ejecutor]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:900,
	allowBlank:false,
        listeners: {
            getSelectedIndex: function() {
                var v = this.getValue();
                var r = this.findRecord(this.valueField || this.displayField, v);
                return(this.storeCO_EJECUTOR.indexOf(r));
             }
        }
});
this.storeCO_EJECUTOR.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_ejecutor,
	value:  this.OBJ.co_ejecutor,
	objStore: this.storeCO_EJECUTOR
});


this.resumen= new Ext.Button({
    text:'Ver Resumen',
    iconCls: 'icon-buscar',
    handler:function(){	
	//ContabilidadEditar.main.mascara.show();
        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/verResumen',
            scripts: true,
            text: "Cargando..",
            params:{                
               co_compras: ContabilidadEditar.main.OBJ.co_compras,
            }
        });
    }
});

function renderPartidaAlerta(val, attr, record) { 
     if(parseFloat(record.data.mo_disponible) >= parseFloat(record.data.monto)){
        return val;     
     }else{
        return '<p style="color:red"><b>'+val+'</b></p>';  
     }
}

this.gridPanel = new Ext.grid.GridPanel({
        title:'Detalle de la Compra',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:500,  
        width:1060,
        tbar:[this.agregar_partida,'-',this.quitar_partida,'-',this.resumen],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_detalle_compras', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_detalle_compras'},    
            {header: 'id_partida', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_partida'}, 
            {header: 'co_tipo_movimiento', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_tipo_movimiento'}, 
            {header: 'Estatus',hidden: true, menuDisabled:true,dataIndex: 'tx_tipo_movimiento'},    
            //{header: 'Concepto',width:200, menuDisabled:true,dataIndex: 'tx_producto',renderer:textoLargo},        
            {header: 'Concepto',width:300, menuDisabled:true,dataIndex: 'detalle',renderer:textoLargo},         
            {header: 'Cod. Partida', width:150, menuDisabled:true,dataIndex: 'nu_partida',renderer:renderPartidaAlerta},
            {header: 'Partida',width:400, menuDisabled:true,dataIndex: 'de_partida',renderer:textoLargo},
          //  {header: 'Monto Disponible',width:180, menuDisabled:true,dataIndex: 'mo_disponible',renderer:renderMontoDisponible},
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
            ContabilidadEditar.main.tx_producto = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('detalle');
            ContabilidadEditar.main.co_producto = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('co_producto');
            ContabilidadEditar.main.agregar_partida.enable();
            
            if(ContabilidadEditar.main.nu_partida==''){
                ContabilidadEditar.main.quitar_partida.disable();
            }else{
                ContabilidadEditar.main.quitar_partida.enable();
            }
          
        }}   
});

if(this.OBJ.co_compras!=''){
    this.getCargarGrid();
}

this.co_ejecutor = new Ext.form.ComboBox({
	fieldLabel:'Ente Ejecutor',
	store: this.storeCO_EJECUTOR,
	typeAhead: true,
	valueField: 'id',
        id:'co_ejecutor',
	displayField:'ejecutor',
	hiddenName:'tb052_compras[co_ejecutor]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:900,
	allowBlank:false,
        listeners: {
            getSelectedIndex: function() {
                var v = this.getValue();
                var r = this.findRecord(this.valueField || this.displayField, v);
                return(this.storeCO_EJECUTOR.indexOf(r));
             }
        }
});
this.storeCO_EJECUTOR.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_ejecutor,
	value:  this.OBJ.co_ejecutor,
	objStore: this.storeCO_EJECUTOR
});


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
                    this.co_ejecutor,
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
},getListaResumen: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storelistaResumen',
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
getCargarGrid: function(){
    ContabilidadEditar.main.store_lista.baseParams.co_compra=ContabilidadEditar.main.OBJ.co_compras;
    this.store_lista.load({
        callback: function(){
            ContabilidadEditar.main.total_pagar = paqueteComunJS.funcion.getSumaColumnaGrid({
                 store:ContabilidadEditar.main.store_lista,
                 campo:'monto'
            });
            
            ContabilidadEditar.main.monto_total.setValue("<span style='font-size:12px;'><b>Total a Pagar: </b>"+paqueteComunJS.funcion.getNumeroFormateado(ContabilidadEditar.main.total_pagar)+"</b></span>");     
             
            ContabilidadEditar.main.verificarPartidas();
        }
    });  
},
verificarPartidas: function(){
            var flag = false;
            ContabilidadEditar.main.gridPanel.getStore().each(function(record){
                    record.fields.each(function(field){
                        if(field.name=='nu_partida'){
                           if(record.get(field.name)!=''){                            
                               flag = true;
                           } 
                           
                        }
                });
            }, this);
            
//            if(flag == true){
//                 Ext.get('co_ejecutor').setStyle('background-color','#c9c9c9');
//                 ContabilidadEditar.main.co_ejecutor.setReadOnly(true);
//            }else{
//                 Ext.get('co_ejecutor').setStyle('background-color','#FFFFFF');
//                 ContabilidadEditar.main.co_ejecutor.setReadOnly(false);
//            }
            
},
afectar_partida: function(){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/cambiarEstado',
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
                    ContabilidadEditar.main.agregar_partida.disable();
                    ContabilidadEditar.main.quitar_partida.disable();
		    ContabilidadEditar.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ContabilidadEditar.main.mascara.hide();
       }});
},
getStoreCO_EJECUTOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoejecutor',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_ejecutor'},
            {name: 'ejecutor',
                convert:function(v,r){
                    return r.nu_ejecutor+' - '+r.de_ejecutor;
                }
            }
            ]
    });
    return this.store;
},getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storelistaCompra',
    root:'data',
    fields:[
                {name: 'co_partida'},
                {name: 'co_producto'},
                {name :'co_detalle_compras'},
                {name :'tx_producto'},
                {name :'nu_partida'},
                {name :'de_partida'},
                {name :'mo_disponible'},
                {name :'monto'},
                {name :'detalle'},
                {name :'co_tipo_movimiento'},
                {name: 'tx_tipo_movimiento'}
           ]
    });
    return this.store;      
}
};
Ext.onReady(ContabilidadEditar.main.init, ContabilidadEditar.main);
</script>
<div id="formularioAgregar"></div>