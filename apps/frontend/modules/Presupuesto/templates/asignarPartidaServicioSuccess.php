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
this.co_producto = this.OBJ.co_producto;


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
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/agregarPartidaServicio',
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

this.gridPanel = new Ext.grid.GridPanel({
        title:'Detalle',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:400,  
        width:1060,
        tbar:[this.agregar_partida,'-',this.quitar_partida],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_detalle_compras', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_detalle_compras'},    
            {header: 'id_partida', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_partida'}, 
            {header: 'co_tipo_movimiento', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_tipo_movimiento'}, 
            //{header: 'Estatus',width:130, menuDisabled:true,dataIndex: 'tx_tipo_movimiento'},    
            {header: 'Servicio',width:200, menuDisabled:true,dataIndex: 'tx_producto',renderer:textoLargo},                
            {header: 'Cod. Partida', width:220, menuDisabled:true,dataIndex: 'nu_partida'},
            {header: 'Partida',width:250, menuDisabled:true,dataIndex: 'de_partida',renderer:textoLargo},
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
            ContabilidadEditar.main.co_producto = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('co_producto');
            ContabilidadEditar.main.agregar_partida.enable();
            
            if(ContabilidadEditar.main.nu_partida==''){
                ContabilidadEditar.main.agregar_partida.enable();
                ContabilidadEditar.main.quitar_partida.disable();
            }else{
                ContabilidadEditar.main.agregar_partida.disable();
                ContabilidadEditar.main.quitar_partida.enable();
            }
          
        }}   
});

if(this.OBJ.co_compras!=''){
    this.getCargarGrid();
}

this.datos  = '<p class="registro_detalle"><b>Cédula: </b>'+this.OBJ.nu_cedula+'</p>';
this.datos += '<p class="registro_detalle"><b>Nombre y Apellido: </b>'+this.OBJ.nb_persona+'</p>';
this.datos +='<p class="registro_detalle"><b>Teléfono: </b>'+this.OBJ.tx_num_celular+'</p>';

this.fieldDatos= new Ext.form.FieldSet({
        title: 'Datos del Proveedor',
        html: this.datos
});

this.datosSolicitud  = '<p class="registro_detalle"><b>Tipo de Servicio: </b>'+this.OBJ.cod_producto+' - '+this.OBJ.tx_producto+'</p>';
this.datosSolicitud+= '<p class="registro_detalle"><b>Descripción: </b>'+this.OBJ.tx_concepto+'</p>';

this.fieldDatosSolicitud= new Ext.form.FieldSet({
        title: 'Datos del Servicio Basico',
        html:this.datosSolicitud
});

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


this.fieldDatosEnte= new Ext.form.FieldSet({
        title: 'Datos del Ente Ejeutor',
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
    items:[         this.co_compra,
                    this.co_documento,
                    this.co_ramo,
                    this.co_solicitud,
                    this.fieldDatos,
//                    this.fieldDatosSolicitud,
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
},
getCargarGrid: function(){
    ContabilidadEditar.main.store_lista.baseParams.co_factura=ContabilidadEditar.main.OBJ.co_factura;
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
            
           /* if(flag == true){
                 Ext.get('co_ejecutor').setStyle('background-color','#c9c9c9');
                 ContabilidadEditar.main.co_ejecutor.setReadOnly(true);
            }else{
                 Ext.get('co_ejecutor').setStyle('background-color','#FFFFFF');
                 ContabilidadEditar.main.co_ejecutor.setReadOnly(false);
            }*/
            
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
            {name: 'nu_ejecutor'},
            {name: 'de_ejecutor'},
            {
                name: 'ejecutor',
                convert:function(v,r){
                    return r.nu_ejecutor+' - '+r.de_ejecutor;
                }
            }
            ]
    });
    return this.store;
},getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storelistaPartida',
    root:'data',
    fields:[
                {name: 'co_partida'},
                {name: 'co_producto'},
                {name :'co_detalle_compras'},
                //{name :'tx_producto'},
                {name: 'tx_producto',
                    convert:function(v,r){
                        return r.nu_factura+' - '+r.tx_producto;
                    }
                },
                {name :'nu_partida'},
                {name :'de_partida'},
                {name :'mo_disponible'},
                {name :'monto'},
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