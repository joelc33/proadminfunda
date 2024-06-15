<script type="text/javascript">
Ext.ns("ContabilidadEditar");
ContabilidadEditar.main = {
init:function(){


this.storeCO_EJECUTOR = this.getStoreCO_EJECUTOR();
this.storeCO_FUENTEFINANCIAMIENTO = this.getStoreCO_FUENTEFINANCIAMIENTO();
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
this.co_asiento_contable='';


this.co_cotizacion = new Ext.form.Hidden({
    name:'co_cotizacion',
    value:this.OBJ.co_cotizacion
});

this.co_solicitud = new Ext.form.Hidden({
    name:'co_solicitud',
    value:this.OBJ.co_solicitud
});


this.store_lista   = this.getLista();


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

function renderPartidaAlerta(val, attr, record) { 
    if(parseFloat(record.data.mo_disponible) >= parseFloat(record.data.monto)){
        return val;     
     }else{
        return '<p style="color:red"><b>'+val+'</b></p>';  
     }
} 

this.agregar_partida= new Ext.Button({
    text:'Agregar Partida',
    iconCls: 'icon-add',
    handler:function(){	
        
    /*    if(ContabilidadEditar.main.co_ejecutor.getValue()=='')
        {
            Ext.Msg.alert("Notificación","Para agregar una partida, debe seleccionar un Ente Ejecutor "+ContabilidadEditar.main.co_ejecutor.getValue());
            return;
        }*/
        
	ContabilidadEditar.main.mascara.show();
        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/listaDesagregadaTodasPb',
         scripts: true,
         text: "Cargando..",
         params:{
             de_ejecutor:ContabilidadEditar.main.co_ejecutor.lastSelectionText,
             co_ejecutor:ContabilidadEditar.main.co_ejecutor.getValue(),
             monto:ContabilidadEditar.main.monto,
             tx_producto:ContabilidadEditar.main.tx_producto,
             co_detalle_cotizacion: ContabilidadEditar.main.co_detalle_cotizacion,
             co_cotizacion: ContabilidadEditar.main.OBJ.co_cotizacion,
             co_partida:ContabilidadEditar.main.id_partida,
             co_producto:ContabilidadEditar.main.co_producto,
             co_solicitud:ContabilidadEditar.main.OBJ.co_solicitud,
             co_fuente_financiamiento: ContabilidadEditar.main.co_fuente_financiamiento.getValue()
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
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/quitarPartidaPb',
            params:{
                co_detalle_cotizacion:ContabilidadEditar.main.gridPanel.getSelectionModel().getSelected().get('co_detalle_cotizacion'),
                co_compras:ContabilidadEditar.main.OBJ.co_compras,
                co_asiento_contable: ContabilidadEditar.main.co_asiento_contable
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
               co_cotizacion: ContabilidadEditar.main.OBJ.co_cotizacion,
            }
        });
    }
});


this.agregar_partida.disable();
this.quitar_partida.disable();

this.gridPanel = new Ext.grid.GridPanel({
        title:'Detalle de las Partidas',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:250,  
        width:1060,
        tbar:[this.agregar_partida,'-',this.quitar_partida,'-',this.resumen],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_detalle_cotizacion', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_detalle_cotizacion'},    
            {header: 'id_partida', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_partida'}, 
            {header: 'co_tipo_movimiento', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_tipo_movimiento'}, 
           // {header: 'Estatus',width:130, menuDisabled:true,dataIndex: 'tx_tipo_movimiento'},    
            {header: 'Material',width:300, menuDisabled:true,dataIndex: 'tx_producto',renderer:textoLargo},                
            {header: 'Cod. Partida', width:140, menuDisabled:true,dataIndex: 'nu_partida',renderer:renderPartidaAlerta},
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
            
            ContabilidadEditar.main.co_detalle_cotizacion  = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('co_detalle_cotizacion');
            ContabilidadEditar.main.id_partida  = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('co_partida');
            ContabilidadEditar.main.monto  = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('monto');
            ContabilidadEditar.main.nu_partida  = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('nu_partida');
            ContabilidadEditar.main.de_partida  = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('de_partida');
            ContabilidadEditar.main.co_tipo_movimiento  = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('co_tipo_movimiento');
            ContabilidadEditar.main.co_presupuesto_movimiento = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('co_presupuesto_movimiento');
            ContabilidadEditar.main.tx_producto = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('tx_producto');
            ContabilidadEditar.main.co_producto = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('co_producto');
            ContabilidadEditar.main.co_asiento_contable = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('co_asiento_contable');
            ContabilidadEditar.main.agregar_partida.enable();
            
            if(ContabilidadEditar.main.nu_partida==''){
                ContabilidadEditar.main.quitar_partida.disable();
            }else{
                ContabilidadEditar.main.quitar_partida.enable();
            }
          
        }}   
});

if(this.OBJ.co_cotizacion!=''){
    this.getCargarGrid();
}

this.datos  = '<p class="registro_detalle"><b>Código: </b>'+this.OBJ.tx_serial_cotizacion+'</p>';
this.datos += '<p class="registro_detalle"><b>Concepto: </b>'+this.OBJ.tx_observacion+'</p>';

this.fieldDatos= new Ext.form.FieldSet({
        title: 'Datos del Presupuesto Base',
        html: this.datos
});

//this.datosContrato ='<p class="registro_detalle"><b>Ramo: </b>'+this.OBJ.tx_ramo+'</p>';
this.datosContrato ='<p class="registro_detalle"><b>Sub Total: </b>'+paqueteComunJS.funcion.getNumeroFormateado(this.OBJ.monto_sub_total)+'</p>';
this.datosContrato+='<p class="registro_detalle"><b>IVA ('+this.OBJ.nu_iva+'%): </b>'+paqueteComunJS.funcion.getNumeroFormateado(this.OBJ.monto_iva)+'</p>';
this.datosContrato+='<p class="registro_detalle"><b>Monto Total: </b>'+paqueteComunJS.funcion.getNumeroFormateado(this.OBJ.monto_total)+'</p>';

this.co_ejecutor = new Ext.form.ComboBox({
	fieldLabel:'Ente Ejecutor',
	store: this.storeCO_EJECUTOR,
	typeAhead: true,
	valueField: 'id',
        id:'co_ejecutor',
	displayField:'de_ejecutor',
	hiddenName:'tb052_compras[co_ejecutor]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:900,
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


this.fieldDatosContrato= new Ext.form.FieldSet({
        title: 'Datos del Contrato',
        html: this.datosContrato
});

this.co_fuente_financiamiento = new Ext.form.ComboBox({
	fieldLabel:'Fuente de Financiamiento',
	store: this.storeCO_FUENTEFINANCIAMIENTO,
	typeAhead: true,
        id:'co_fuente_financiamiento',
	valueField: 'co_fuente_financiamiento',
	displayField:'tx_fuente_financiamiento',
	hiddenName:'tb052_compras[co_fuente_financiamiento]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:415
});
this.storeCO_FUENTEFINANCIAMIENTO.load();
paqueteComunJS.funcion.seleccionarComboByCo({
    objCMB: this.co_fuente_financiamiento,
    value: this.OBJ.co_fuente_financiamiento,
    objStore: this.storeCO_FUENTEFINANCIAMIENTO
});



this.fieldDatosEnte= new Ext.form.FieldSet({
        title: 'Datos del Ente Ejecutor / Fuente Financiamiento',
        items:[this.co_ejecutor]
});

this.tx_concepto = new Ext.form.TextField({
	fieldLabel:'Concepto',
	name:'tb039_requisiciones[tx_concepto]',
	value:this.OBJ.tx_concepto,
	allowBlank:false,
	width:680
});

this.tx_observacion = new Ext.form.TextArea({
	fieldLabel:'Observaciones',
	name:'tb039_requisiciones[tx_observacion]',
	value:this.OBJ.tx_observacion,
	width:680
});

this.fieldDatosRequisicion= new Ext.form.FieldSet({
    items:[this.tx_concepto,
           this.tx_observacion]
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
    items:[         this.co_cotizacion,
                    this.co_solicitud,
                    this.fieldDatos,
                   // this.fieldDatosContrato,
                  //  this.fieldDatosEnte,
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
getStoreCO_FUENTEFINANCIAMIENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcofuentefinanciamiento',
        root:'data',
        fields:[
            {name: 'co_fuente_financiamiento'},
            {name: 'tx_fuente_financiamiento'}
            ]
    });
    return this.store;
},
getCargarGrid: function(){
    ContabilidadEditar.main.store_lista.baseParams.co_cotizacion=ContabilidadEditar.main.OBJ.co_cotizacion;
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
            
            if(flag == true){
//                 Ext.get('co_ejecutor').setStyle('background-color','#c9c9c9');
//                 ContabilidadEditar.main.co_ejecutor.setReadOnly(true);
//                 
//                 
//                 Ext.get('co_fuente_financiamiento').setStyle('background-color','#c9c9c9');
//                 ContabilidadEditar.main.co_fuente_financiamiento.setReadOnly(true);
                 
                 
            }else{
                 Ext.get('co_fuente_financiamiento').setStyle('background-color','#FFFFFF');
                 ContabilidadEditar.main.co_fuente_financiamiento.setReadOnly(false);
                 
                 Ext.get('co_ejecutor').setStyle('background-color','#FFFFFF');
                 ContabilidadEditar.main.co_ejecutor.setReadOnly(false);
            }
            
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
            {name: 'de_ejecutor',
                convert:function(v,r){
                    return r.nu_ejecutor+' - '+r.de_ejecutor;
                }
            }
            ]
    });
    return this.store;
},getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storelistaCompraPb',
    root:'data',
    fields:[
                {name: 'co_partida'},
                {name: 'co_producto'},
                {name :'co_detalle_cotizacion'},
                {name :'tx_producto'},
                {name :'nu_partida'},
                {name :'de_partida'},
                {name :'mo_disponible'},
                {name :'monto'},
                {name :'co_tipo_movimiento'},
                {name: 'tx_tipo_movimiento'},
                {name: 'co_asiento_contable'}
           ]
    });
    return this.store;      
}
};
Ext.onReady(ContabilidadEditar.main.init, ContabilidadEditar.main);
</script>
<div id="formularioAgregar"></div>