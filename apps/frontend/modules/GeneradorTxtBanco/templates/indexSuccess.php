<script type="text/javascript">
Ext.ns("PagoNominaLista");
PagoNominaLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.store_banco = this.getDataBanco();
this.store_cuenta = this.getDataCuenta();

this.co_liquidacion_pago = new Ext.form.Hidden({
    name:'co_liquidacion_pago',
    value:this.OBJ.co_liquidacion_pago
});    

this.fe_pago = new Ext.form.DateField({
	fieldLabel:'Fecha de Pago',
	name:'fe_pago',
	width:100
});

this.tx_concepto = new Ext.form.TextField({
        fieldLabel:'Concepto',
	name:'tx_concepto',
	allowBlank:false,
	width:485
});

this.banco = new Ext.form.ComboBox({
    fieldLabel : 'Banco',
    displayField:'tx_banco',
    store: this.store_banco,
    typeAhead: true,
    valueField: 'co_banco',
    hiddenName:'co_banco',
    name: 'co_banco',
    id: 'co_banco',
    triggerAction: 'all',
    emptyText:'Seleccione el Banco',
    selectOnFocus:true,
    width:240,
    resizable:true
});

this.banco.on('beforeselect',function(cmb,record,index){
            PagoNominaLista.main.cuenta.clearValue();
            PagoNominaLista.main.store_cuenta.load({
            params:{
                co_banco:record.get('co_banco')
            },
            callback : function(records, operation, success) {
                if (records.length > 0) {
            }else{
                console.log(records.length);
               Ext.Msg.alert("Alerta","La banco seleccionado tiene cuentas Asociados");   
            }
    }
        });
},this);

this.cuenta = new Ext.form.ComboBox({
    fieldLabel : 'Cuenta',
    displayField:'tx_cuenta_bancaria',
    store: this.store_cuenta,
    typeAhead: true,
    valueField: 'co_cuenta_bancaria',
    hiddenName:'co_cuenta',
    name: 'co_cuenta',
    id: 'co_cuenta',
    triggerAction: 'all',
    emptyText:'Seleccione la Cuenta',
    selectOnFocus:true,
    mode:'local',
    width:240,
    resizable:true
});

this.nu_pago = new Ext.form.NumberField({
	fieldLabel:'Nro. Pago',
	name:'nu_pago',
	width:80
});

this.fieldDocumento = new Ext.form.FieldSet({
	title: 'Datos del Pago',
	items:[
               //this.fe_pago,
               this.co_liquidacion_pago,
               this.tx_concepto,
               //this.banco,
               //this.cuenta,
               //this.nu_pago,
               {
                            xtype: 'fileuploadfield',
                            style:"padding-right:330px",
                            id: 'form-file',
                            emptyText: 'Seleccione un archivo',
                            fieldLabel: 'Archivo (txt)',
                            name: 'form-file',
                            buttonText: 'Buscar'            
                }]
});

this.formPanel_ = new Ext.form.FormPanel({
    title:'Generar TXT Nomina',
    fileUpload: true,
   // frame:true,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.fieldDocumento]        
});


this.winformPanel_ = new Ext.Window({
    title:'Cierre Presupuesto Egreso',
    modal:true,
    constrain:true,
    width:800,
    frame:true,
    closabled:true,
    height:210,
    items:[
       this.formPanel_
    ],
    buttons:[
        {
            text:'Generar',
            iconCls:'icon-buscar',
            handler:function(){
                if(!PagoNominaLista.main.formPanel_.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
                    return false;
                }
                PagoNominaLista.main.formPanel_.getForm().submit({
                    method:'POST',
                    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/GeneradorTxtBanco/guardar',
                    failure: function(form, action) {
                        Ext.MessageBox.alert('Error en transacción', action.result.msg);
                     },
                    success: function(form, action) {
                         
                    }
                });
            }
        }
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();



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
}
};
Ext.onReady(PagoNominaLista.main.init, PagoNominaLista.main);
</script>
<div id="contenedorPagoNominaLista"></div>
