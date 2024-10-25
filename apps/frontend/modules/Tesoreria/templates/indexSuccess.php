<script type="text/javascript">
Ext.ns('recaudacion');
recaudacion.formulario = {

init: function(){
 this.store_lista_pagos   = this.getListaPagos();           
 //this.restante = this.OBJ.mo_valor_restante;

 this.store_forma_pago = this.getDataFormaPago();
 this.store_banco = this.getDataBanco();
 this.store_cuenta = this.getDataCuenta();
 this.store_chequera = this.getDataChequera();
 this.store_cheque = this.getDataCheque(); 

 this.store_banco.load();
 this.store_forma_pago.load();
     this.store_lista_pagos.baseParams.co_liquidacion_pago = '<?php echo $co_liquidacion_pago; ?>';
    this.store_lista_pagos.load({        
            callback: function(){
            recaudacion.formulario.getTotal();
        }});
  this.co_solicitud = new Ext.form.Hidden({
            name : 'co_solicitud',
            width: '150px',
            readOnly:true,
            value: '<?php echo $co_solicitud; ?>'

   });
   
  this.co_tipo_odp = new Ext.form.Hidden({
            name : 'co_tipo_odp',
            width: '150px',
            readOnly:true,
            value: '<?php echo $co_tipo_odp; ?>'

   });   
   
this.co_cheque = new Ext.form.Hidden({
        name : 'Pagos[co_cheque]',
        width: '150px',
        readOnly:true,
        value: ''

});   

this.co_tipo_solicitud = new Ext.form.Hidden({
            name : 'co_tipo_solicitud',
            width: '150px',
            readOnly:true,
            value: '<?php echo $co_tipo_solicitud; ?>'

   });

this.hiddenJsonPago = new Ext.form.Hidden({
            name : 'co_liquidacion_pago'

   }); 

this.nu_orden = new Ext.form.TextField({
        fieldLabel : 'Nro. Solicitud',
        name : 'Pagos[tx_serial]',
        style: 'background:#DDDDDD;',
        width: '150px',
        readOnly:true,
         value: '<?php echo $co_solicitud; ?>'

});

this.fe_emision = new Ext.form.DateField({
    name:'Pagos[fe_emision]',
    format:'d-m-Y',
    fieldLabel: 'Fecha',
    allowBlank:false,
    width:100,
    maxValue:new Date()    
});

this.forma_pago = new Ext.form.ComboBox({
    fieldLabel : 'Forma de Pago',
    displayField:'tx_forma_pago',
    store: this.store_forma_pago,
    typeAhead: true,
    valueField: 'co_forma_pago',
    hiddenName:'Pagos[co_forma_pago]',
    name: 'co_forma_pago',
    triggerAction: 'all',
    emptyText:'Seleccione la forma de pago',
    selectOnFocus:true,
    allowBlank:false,
    width:240,
    resizable:true,
    /*onSelect: function(record){
		recaudacion.formulario.forma_pago.setValue(record.data.co_forma_pago);
		recaudacion.formulario.chequera.setValue("");
		recaudacion.formulario.referencia.setValue("");
		if(record.data.co_forma_pago==3){ 
            recaudacion.formulario.chequera.disable();
            Ext.get('co_chequera').setStyle('background-color','#c9c9c9');  
            recaudacion.formulario.referencia.enable();
            Ext.get('referencia').setStyle('background-color','#FFFFFF');            
		}else{ 
            recaudacion.formulario.chequera.enable();
            Ext.get('co_chequera').setStyle('background-color','#FFFFFF'); 
            recaudacion.formulario.referencia.disable();
            Ext.get('referencia').setStyle('background-color','#FFFFFF');            
		}

		this.collapse();
    }*/
});

this.banco = new Ext.form.ComboBox({
    fieldLabel : 'Banco',
    displayField:'tx_banco',
    store: this.store_banco,
    typeAhead: true,
    valueField: 'co_banco',
    hiddenName:'Pagos[co_banco]',
    name: 'co_banco',
    id: 'co_banco',
    triggerAction: 'all',
    emptyText:'Seleccione el Banco',
    selectOnFocus:true,
    width:240,
    resizable:true
});

this.cuenta = new Ext.form.ComboBox({
    fieldLabel : 'Cuenta',
    displayField:'tx_cuenta_bancaria',
    store: this.store_cuenta,
    typeAhead: true,
    valueField: 'co_cuenta_bancaria',
    hiddenName:'Pagos[co_cuenta]',
    name: 'co_cuenta',
    id: 'co_cuenta',
    triggerAction: 'all',
    emptyText:'Seleccione la Cuenta',
    selectOnFocus:true,
    mode:'local',
    width:240,
    resizable:true
});

this.chequera = new Ext.form.ComboBox({
    fieldLabel : 'Chequera',
    displayField:'tx_descripcion',
    store: this.store_chequera,
    typeAhead: true,
    valueField: 'co_chequera',
    hiddenName:'Pagos[co_chequera]',
    name: 'co_chequera',
    id: 'co_chequera',
    triggerAction: 'all',
    emptyText:'Seleccione la Chequera',
    selectOnFocus:true,
    mode:'local',
    width:240,
    resizable:true
});
function renderMonto(val, attr, record) {
     return paqueteComunJS.funcion.getNumeroFormateado(val);
}
this.displayfieldmonto = new Ext.form.DisplayField({
 value:"<span style='font-size:12px;'><b>Total a Pagar: </b></span>"
});
this.gridPanel = new Ext.grid.GridPanel({
        title:'Lista de Pagos',
        iconCls: 'icon-libro',
        store: this.store_lista_pagos,
        loadMask:true,
        height:180,
        width:370,
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_liquidacion_pago', hidden: true,width:10, menuDisabled:true,dataIndex: 'co_liquidacion_pago'},
            {header: 'N° Liquidacion de Pago', width:120, menuDisabled:true,dataIndex: 'tx_serial'},
            {header: 'Monto',width:200, menuDisabled:true,dataIndex: 'mo_pendiente',renderer:renderMonto}
        ],
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        bbar: new Ext.ux.StatusBar({
        id: 'basic-statusbar',
        autoScroll:true,
        defaults:{style:'color:black;font-size:30px;',autoWidth:true},
        items:[
        this.displayfieldmonto
        ]
        }),
        listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
        }}
});

this.monto = new Ext.form.NumberField({
    fieldLabel : 'Monto a Pagar',
    name : 'Pagos[monto]',
    id : 'monto',    
    width: '150px',
    minValue : 0,
    allowDecimals : true,
    decimalPrecision : 2,
    decimalSeparator : '.',
    allowNegative : false,
//    style: 'background:#DDDDDD;',
//    readOnly:true,
    allowBlank:false,
    tooltip : '',
    value: '',
    blankText: 'Debe introducir el monto a pagar',
   });

this.referencia = new Ext.form.NumberField({
        fieldLabel : 'Cheque/Transf',
        id : 'referencia',
        name : 'Pagos[nu_referencia]',
        width: '150px',
        minValue : 0,
        allowDecimals : true,
        decimalPrecision : 2,
        decimalSeparator : '.',
        allowNegative : false,
        allowBlank:false,
        tooltip : '',
        blankText: 'Debe introducir el numero de referencia'
});

this.mo_pendiente = new Ext.form.NumberField({
        fieldLabel : 'Monto Pendiente',
        name : 'Pagos[mo_pendiente]',
        width: '150px',
        minValue : 0,
        allowDecimals : true,
        decimalPrecision : 2,
        decimalSeparator : '.',
        allowNegative : false,
        style: 'background:#DDDDDD;',
        tooltip : '',
        readOnly: true
});

this.mo_pagado = new Ext.form.NumberField({
            fieldLabel : 'Monto Pagado',
            name : 'Pagos[mo_pagado]',
            width: '150px',
            minValue : 0,
            allowDecimals : true,
            decimalPrecision : 2,
            style: 'background:#DDDDDD;',
            decimalSeparator : '.',
            allowNegative : false,
            tooltip : '',
            readOnly: true
   });
   
this.tx_descripcion = new Ext.form.TextArea({
	fieldLabel:'Descripción',
	name:'Pagos[tx_descripcion]',
        value: '<?php echo $tx_observacion; ?>',
	width:240,
        allowBlank:false,
        listeners: {
        change: function(field, newValue, oldValue) {
        field.setValue(newValue.toUpperCase());
    }
}   
});   

this.formpanel = new Ext.FormPanel({
      width: 400,
      padding:'15px',
      url: '<?php echo $_SERVER["SCRIPT_NAME"];?>/Tesoreria/guardar',
      items:[
             recaudacion.formulario.co_solicitud,
             recaudacion.formulario.co_tipo_solicitud,
             recaudacion.formulario.co_cheque,
             recaudacion.formulario.hiddenJsonPago,
             recaudacion.formulario.nu_orden,
             recaudacion.formulario.fe_emision,             
//             recaudacion.formulario.forma_pago,
             recaudacion.formulario.banco,
             recaudacion.formulario.cuenta,
//             recaudacion.formulario.chequera,
             recaudacion.formulario.monto,             
//             recaudacion.formulario.referencia,
             recaudacion.formulario.mo_pendiente,
             recaudacion.formulario.mo_pagado,
             recaudacion.formulario.tx_descripcion
//             recaudacion.formulario.gridPanel
         ]

});

this.guardar = new Ext.Button({
    text:'Procesar',
    iconCls:'icon-save',
    handler: this.onRecaudar
});
        

this.win = new Ext.Window({
   title:'Datos del Pago',
   modal:true,
   constrain:true,
   items:[recaudacion.formulario.formpanel],
   buttonAlign:'center',
   buttons:[
            this.guardar
           ]
});

this.win.show();

this.addEvents();
},

onRecaudar : function(btn, ev) {


  if(recaudacion.formulario.monto.getValue()==0){
                Ext.Msg.alert("Alerta","Disculpe el monto a pagar no puede ser cero");
                return false;
  }else{

        if(recaudacion.formulario.banco.getValue()==""){
                Ext.Msg.alert("Alerta","Disculpe debe seleccionar el banco");
                return false;
        }
        if(recaudacion.formulario.cuenta.getValue()==""){
                Ext.Msg.alert("Alerta","Disculpe debe seleccionar la cuenta bancaria");
                return false;
        }
//        if(recaudacion.formulario.chequera.getValue()==""){
//                Ext.Msg.alert("Alerta","Disculpe debe seleccionar la chequera");
//                return false;
//        }

        }

        if(!recaudacion.formulario.formpanel.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos requeridos! Verifique");
            return false;
        }
        
        if(recaudacion.formulario.monto.getValue()>recaudacion.formulario.mo_pendiente.getValue()){
            Ext.Msg.alert("Alerta","El monto a pagar no puede ser mayor al Pendiente");
            return false;
        }
        var list = paqueteComunJS.funcion.getJsonByObjStore({
        store:recaudacion.formulario.gridPanel.getStore()
        });
        recaudacion.formulario.hiddenJsonPago.setValue(list);
        
         recaudacion.formulario.guardar.setDisabled(true);
       
        
  recaudacion.formulario.formpanel.form.submit({
     success: function(form, action){
         if(action.result.success){
             Ext.MessageBox.show({
                 title: 'Mensaje',
                 msg: action.result.msg,
                 closable: false,
                 resizable: false,
                 buttons: Ext.MessageBox.OK
             });

             window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/soportePago.php?codigo='+action.result.co_pago);
         
//            PagosPanel.main.storeP.load(); 
//            PagosPanel.main.storeP.load(); 
           pendientePagosLista.main.store_lista.load();//bandeja
//           if(panel_detalle.collapsed == false)
//            {
//            panel_detalle.toggleCollapse();
//
//            } 
             recaudacion.formulario.win.close()


         }
     },
     failure: function(form, action) {

         Ext.MessageBox.alert('Mensaje', action.result.msg);

     }
 });
},

/*
*  STORE QUE CARGA LOS COMBOS DE BANCO - CUENTA
*/

getDataBanco: function(){
var store =  new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Tesoreria/banco',
                root:'data',
                fields: ['co_banco','tx_banco']
 });
return store;
},
getDataCuenta: function(){
var store =  new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Tesoreria/cuenta',
                root:'data',
                fields: ['co_cuenta_bancaria','tx_cuenta_bancaria']
 });
return store;
},
getDataChequera: function(){
var store =  new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Tesoreria/chequera',
                root:'data',
                fields: ['co_chequera','tx_descripcion']
 });
return store;
},
getDataCheque: function(){
var store =  new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Tesoreria/cheque',
                root:'data',
                fields: ['co_cheque','tx_descripcion']
 });
return store;
},
getDataFormaPago: function(){
var store =  new Ext.data.JsonStore({
        url:'<?php echo $_SERVER['SCRIPT_NAME']?>/Tesoreria/formapago',
                root:'data',
                fields: ['co_forma_pago','tx_forma_pago']
 });
return store;
},
getListaPagos: function(){

    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Tesoreria/storefkcoliquidacionpago',
    root:'data',
    fields:[
                {name: 'co_liquidacion_pago'},
                {name: 'tx_serial'},
                {name: 'mo_pendiente'},
                {name: 'mo_pagado'},
                {name: 'mo_pagar'},
           ]
    });
    return this.store;
},
getTotal:function(){

this.total_pendiente = 0;
this.total_pagado = 0;
this.cancelar = 0;
this.tcancelar = 0;
var cant = recaudacion.formulario.store_lista_pagos.getCount();
this.total_pendiente = paqueteComunJS.funcion.getSumaColumnaGrid({
            store:recaudacion.formulario.store_lista_pagos,
            campo:'mo_pendiente'
            });
            
this.total_pagado = paqueteComunJS.funcion.getSumaColumnaGrid({
            store:recaudacion.formulario.store_lista_pagos,
            campo:'mo_pagado'
            });            

if(recaudacion.formulario.co_tipo_odp.getValue()==1){
    Ext.get('monto').setStyle('background-color','#c9c9c9');
    recaudacion.formulario.monto.setReadOnly(true);
    recaudacion.formulario.tx_descripcion.setReadOnly(true);

}else{
   recaudacion.formulario.tx_descripcion.setValue(''); 
   recaudacion.formulario.monto.setValue(0); 
}

//if(cant>1){
//    Ext.get('referencia').setStyle('background-color','#c9c9c9');
//    recaudacion.formulario.referencia.setReadOnly(true);
//    Ext.get('monto').setStyle('background-color','#c9c9c9');
//    recaudacion.formulario.monto.setReadOnly(true);    
//
//}
this.tcancelar = parseFloat(this.total_pendiente);
this.tcancelar = this.tcancelar.toFixed(2);
recaudacion.formulario.monto.setValue(this.tcancelar);
recaudacion.formulario.mo_pendiente.setValue(this.total_pendiente);
recaudacion.formulario.mo_pagado.setValue(this.total_pagado);
recaudacion.formulario.displayfieldmonto.setValue("<span style='font-size:12px;'><b>Total a Pagar: </b>"+paqueteComunJS.funcion.getNumeroFormateado(recaudacion.formulario.monto.getValue())+"</b></span>");

},
/*
*  FUNCION QUE CAPTURA LOS EVENTOS AL SELECCIONAR CADA UNO DE LOS COMBOS ANIDADOS
*  (BANCO - CUENTA)
*/
addEvents: function(){
recaudacion.formulario.forma_pago.on('beforeselect',function(cmb,record,index){
    if(record.get('co_forma_pago')==2){

        recaudacion.formulario.banco.clearValue();
        recaudacion.formulario.cuenta.clearValue();
        recaudacion.formulario.chequera.clearValue();
        recaudacion.formulario.referencia.setValue('');
        recaudacion.formulario.chequera.setReadOnly(true);
        recaudacion.formulario.referencia.setReadOnly(false);
        
        /*Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Tesoreria/correlativoTransferencia',
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                recaudacion.formulario.referencia.setValue(obj.correlativo);     
        }});*/
        
    }else if(record.get('co_forma_pago')==3){ 
        alert("e");
            recaudacion.formulario.chequera.disable();
            Ext.get('co_chequera').setStyle('background-color','#c9c9c9');  
            recaudacion.formulario.referencia.enable();
            Ext.get('referencia').setStyle('background-color','#FFFFFF');    
            recaudacion.formulario.referencia.setReadOnly(false);        
	}else{
        recaudacion.formulario.banco.clearValue();
        recaudacion.formulario.cuenta.clearValue();
        recaudacion.formulario.chequera.clearValue();
        recaudacion.formulario.referencia.setValue('');
        recaudacion.formulario.chequera.setReadOnly(false);
        recaudacion.formulario.referencia.setReadOnly(true);  
        
        recaudacion.formulario.chequera.enable();
        Ext.get('co_chequera').setStyle('background-color','#FFFFFF'); 
        recaudacion.formulario.referencia.disable();
        Ext.get('referencia').setStyle('background-color','#FFFFFF');  
    }

    /*var forma_pago = record.get('co_forma_pago');

    switch (forma_pago) {
        case 2:

            recaudacion.formulario.banco.clearValue();
            recaudacion.formulario.cuenta.clearValue();
            recaudacion.formulario.chequera.clearValue();
            recaudacion.formulario.referencia.setValue('');
            recaudacion.formulario.chequera.setReadOnly(true);
            recaudacion.formulario.referencia.setReadOnly(false);
            
            Ext.Ajax.request({
                method:'POST',
                url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Tesoreria/correlativoTransferencia',
                success:function(result, request ) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    recaudacion.formulario.referencia.setValue(obj.correlativo);     
            }});

            break;
        case 3:

            recaudacion.formulario.chequera.disable();
            Ext.get('co_chequera').setStyle('background-color','#c9c9c9');  
            recaudacion.formulario.referencia.enable();
            Ext.get('referencia').setStyle('background-color','#FFFFFF'); 

            break;
        default:

            recaudacion.formulario.banco.clearValue();
            recaudacion.formulario.cuenta.clearValue();
            recaudacion.formulario.chequera.clearValue();
            recaudacion.formulario.referencia.setValue('');
            recaudacion.formulario.chequera.setReadOnly(false);
            recaudacion.formulario.referencia.setReadOnly(true);  
            
            recaudacion.formulario.chequera.enable();
            Ext.get('co_chequera').setStyle('background-color','#FFFFFF'); 
            recaudacion.formulario.referencia.disable();
            Ext.get('referencia').setStyle('background-color','#FFFFFF');

            break;
    }*/
        
},this);
recaudacion.formulario.banco.on('beforeselect',function(cmb,record,index){
        recaudacion.formulario.cuenta.clearValue();
        recaudacion.formulario.chequera.clearValue();
        recaudacion.formulario.store_cuenta.load({
            params:{
                co_banco:record.get('co_banco')
                //co_tipo_solicitud:recaudacion.formulario.co_tipo_solicitud.getValue()
            },
        callback : function(records, operation, success) {
                if (records.length > 0) {
            }else{
                console.log(records.length);
//               if(recaudacion.formulario.co_tipo_solicitud.getValue()==14 || recaudacion.formulario.co_tipo_solicitud.getValue()==38){
//                Ext.Msg.alert("Alerta","La banco seleccionado no tiene cuentas de fondos de terceros Asociadas");    
//            }else{
                Ext.Msg.alert("Alerta","La banco seleccionado no tiene cuentas Asociadas");   
//            }
            }
    }
        });
},this);

recaudacion.formulario.cuenta.on('beforeselect',function(cmb,record,index){
        recaudacion.formulario.chequera.clearValue();
//        recaudacion.formulario.referencia.setValue('');
        recaudacion.formulario.store_chequera.load({
            params:{
                co_cuenta_bancaria:record.get('co_cuenta_bancaria')
            },
       callback : function(records, operation, success) {
                if (records.length > 0) {
            }else{
              // Ext.Msg.alert("Alerta","La cuenta seleccionado tiene chequeras disponibles");   
            }
    }
        });
},this);

recaudacion.formulario.chequera.on('beforeselect',function(cmb,record,index){
    var cant = recaudacion.formulario.store_lista_pagos.getCount();
        recaudacion.formulario.store_cheque.load({
            params:{
                co_chequera:record.get('co_chequera'),
                cant_pagos:cant
            },
    callback : function(records, operation, success) {
        
        
     if(recaudacion.formulario.co_tipo_solicitud.getValue()==38){
                recaudacion.formulario.referencia.setValue('');   
            }else{
                if (records.length > 0) {
                    if(cant>records.length){
         recaudacion.formulario.referencia.setValue('');
         Ext.Msg.alert("Alerta","La chequera seleccionada no tiene la cantidad de cheques disponibles para el numero de pago! solo tiene "+records.length+" cheques disponibles.");   
             recaudacion.formulario.chequera.clearValue();        
            }else{
          recaudacion.formulario.referencia.setValue(records[0].data.tx_descripcion);
          recaudacion.formulario.co_cheque.setValue(records[0].data.co_cheque);
            }      
            }else{
                recaudacion.formulario.referencia.setValue('');
         Ext.Msg.alert("Alerta","La chequera seleccionada no tiene cheques disponibles");   
            }
        }
    }            
});
},this);



}

}

Ext.onReady(recaudacion.formulario.init, recaudacion.formulario);
</script>
